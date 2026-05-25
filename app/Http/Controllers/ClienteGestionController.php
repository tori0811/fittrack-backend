<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserQuestionnaire;
use App\Models\Bloque;
use App\Models\Dieta;
use App\Models\ProgresoPeso;
use App\Models\ProgresoMedidas;
use App\Models\ProgresoFoto;
use App\Models\Microciclo;
use App\Models\Entreno;

class ClienteGestionController extends Controller
{
    public function detalleCliente($id)
{
    // 1. Cliente con perfil
    $cliente = User::with('profile')->findOrFail($id);

    //2. Cuestionario del usuario

    $cuestionario = UserQuestionnaire::where('user_id', $id)->first(); 

    // 2. Bloques
    $bloques = Bloque::where('user_id', $id)->get();

    // 3. Microciclos por bloque
    $microciclos = Microciclo::whereIn('bloque_id', $bloques->pluck('id'))
        ->with('entrenos.ejercicios.series')
        ->orderBy('numero')
        ->get();

    // 4. Entrenos del cliente
    
    $entrenos = Entreno::whereIn('microciclo_id', $microciclos->pluck('id'))->get();

    // 5. Dieta activa
    $dieta = Dieta::where('user_id', $id)
        ->with('comidas.opciones')
        ->orderBy('created_at', 'desc')
        ->first();

    // 6. Progreso de PESO
    $progresoPeso = \App\Models\ProgresoPeso::where('user_id', $id)
        ->orderBy('fecha', 'asc')
        ->get();

    // 7. Progreso de MEDIDAS
    $progresoMedidas = \App\Models\ProgresoMedidas::where('user_id', $id)
        ->orderBy('fecha', 'asc')
        ->get();

    // 8. Progreso de FOTOS agrupado por fecha
    $fotosRaw = \App\Models\ProgresoFoto::where('user_id', $id)
        ->orderBy('fecha', 'desc')
        ->get();

    $progresoFotos = $fotosRaw->groupBy('fecha')->map(function ($items) {
        return $items->map(function ($foto) {
            return [
                "id" => $foto->id,
                "ruta" => $foto->ruta_foto,
            ];
        });
    });

    return response()->json([
        "cliente"       => $cliente,
        "cuestionario" => $cuestionario,
        "bloques"       => $bloques,
        "microciclos"   => $microciclos,
        "dieta"         => $dieta,

        "progreso" => [
            "peso"     => $progresoPeso,
            "medidas"  => $progresoMedidas,
            "fotos"    => $progresoFotos  
        ]
    ]);
}

}
