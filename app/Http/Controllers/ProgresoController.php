<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgresoPeso;
use App\Models\ProgresoMedidas;
use App\Models\ProgresoFoto;

class ProgresoController extends Controller
{
    /*
        Registrar peso del cliente
     */
    public function registrarPeso(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'peso'  => 'required|numeric'
        ]);
        
        $fecha = $request->fecha ?? now()->toDateString();

        $registro = ProgresoPeso::create([
            'user_id' => $request->user()->id,
            'fecha'   => $request->fecha,
            'peso'    => $request->peso
        ]);

        return response()->json([
            'message' => 'Peso registrado correctamente',
            'registro' => $registro
        ]);
    }

    /*
        Registrar medidas corporales
     */
    public function registrarMedidas(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        $registro = ProgresoMedidas::create([
            'user_id' => $request->user()->id,
            'fecha'   => $request->fecha,
            'pecho'   => $request->pecho,
            'espalda' => $request->espalda,
            'cintura' => $request->cintura,
            'cadera'  => $request->cadera,
            'brazo'   => $request->brazo,
            'pierna'  => $request->pierna,
            'gemelo'  => $request->gemelo
        ]);

        return response()->json([
            'message' => 'Medidas registradas correctamente',
            'registro' => $registro
        ]);
    }

    /*
        Subir foto de progreso
     */
    public function registrarFoto(Request $request)
    {
        $request->validate([
            'foto'  => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'fecha' => 'required|date'
        ]);

        $user = $request->user();

        // Guardar en storage/app/public/progreso/
        $ruta = $request->file('foto')->store('progreso', 'public');

        $registro = ProgresoFoto::create([
            'user_id'   => $user->id,
            'ruta_foto' => $ruta,
            'fecha'     => $request->fecha
        ]);

        return response()->json([
            'message' => 'Foto subida correctamente',
            'registro' => $registro
        ]);
    }

    /*
        Historial completo del cliente
     */
    public function historial(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'peso'    => $user->progresoPeso()->orderBy('fecha', 'desc')->get(),
            'medidas' => $user->progresoMedidas()->orderBy('fecha', 'desc')->get(),
            'fotos'   => $user->progresoFotos()->orderBy('fecha', 'desc')->get(),
        ]);
    }

    /*
        Últimos datos de PanelCliente
     */
    public function ultimosDatos(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'ultimo_peso'    => $user->progresoPeso()->orderBy('fecha', 'desc')->first(),
            'ultimas_medidas'=> $user->progresoMedidas()->orderBy('fecha', 'desc')->first(),
            'ultima_foto'    => $user->progresoFotos()->orderBy('fecha', 'desc')->first(),
        ]);
    }
}

