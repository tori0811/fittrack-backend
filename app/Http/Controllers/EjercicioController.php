<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    public function crear(Request $request)
    {
        $request->validate([
            'entreno_id' => 'required|exists:entrenos,id',
            'grupo_muscular' => 'required|string',
            'nombre' => 'required|string'
        ]);

        $ej = Ejercicio::create($request->all());
        return response()->json(['ejercicio' => $ej]);
    }

    public function eliminar($id)
    {
        Ejercicio::findOrFail($id)->delete();
        return response()->json(['message' => 'Ejercicio eliminado']);
    }

    public function editar(Request $request, $id)
    {
        $ej = Ejercicio::findOrFail($id);
        $ej->update($request->all());

        return response()->json(['ejercicio' => $ej]);
    }
}
