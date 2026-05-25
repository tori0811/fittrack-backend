<?php

namespace App\Http\Controllers;

use App\Models\SerieEjercicio;
use Illuminate\Http\Request;

class SerieEjercicioController extends Controller
{
    public function crear(Request $request)
    {
        $request->validate([
            'ejercicio_id' => 'required|exists:ejercicios,id'
        ]);

        $serie = SerieEjercicio::create($request->all());

        return response()->json(['serie' => $serie]);
    }

    public function editar(Request $request, $id)
    {
        $serie = SerieEjercicio::findOrFail($id);
        $serie->update($request->all());

        return response()->json(['serie' => $serie]);
    }

    public function eliminar($id)
    {
        SerieEjercicio::findOrFail($id)->delete();
        return response()->json(['message' => 'Serie eliminada']);
    }
}
