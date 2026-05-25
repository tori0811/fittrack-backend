<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use Illuminate\Http\Request;

class BloqueController extends Controller
{
    public function crear(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'trainer_id' => 'required|exists:users,id',
            'plantilla_entrenamiento_id' => 'nullable|exists:plantillas_entrenamiento,id',
            'titulo' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $bloque = Bloque::create([
            'user_id' => $request->user_id,
            'trainer_id' => $request->trainer_id,
            'plantilla_entrenamiento_id' => $request->plantilla_entrenamiento_id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json(['bloque' => $bloque]);
    }

    public function listar(Request $request)
    {
        return response()->json([
            'bloques' => Bloque::where('user_id', $request->user()->id)
                ->with('microciclos')
                ->get()
        ]);
    }

    public function mostrar($id)
    {
        $bloque = Bloque::with([
            'microciclos.entrenos.ejercicios.series'
        ])->findOrFail($id);

        return response()->json(['bloque' => $bloque]);
    }

    public function editar(Request $request, $id)
    {
        $bloque = Bloque::findOrFail($id);
        $bloque->update($request->all());

        return response()->json(['bloque' => $bloque]);
    }

    public function eliminar($id)
    {
        Bloque::findOrFail($id)->delete();
        return response()->json(['message' => 'Bloque eliminado']);
    }

    public function buscarPorPlantilla($plantillaId)
{
    $bloque = Bloque::where('plantilla_entrenamiento_id', $plantillaId)
        ->where('trainer_id', auth()->id())
        ->with('microciclos.entrenos.ejercicios.series')
        ->first();

    return response()->json(['bloque' => $bloque]);
}
}
