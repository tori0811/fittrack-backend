<?php

namespace App\Http\Controllers;

use App\Models\Entreno;
use Illuminate\Http\Request;

class EntrenoController extends Controller
{
    public function crear(Request $request)
    {
        $request->validate([
            'microciclo_id' => 'required|exists:microciclos,id',
            'titulo' => 'nullable|string',
            'dia_semana' => 'nullable|string',
            'orden' => 'nullable|integer'
        ]);

        $entreno = Entreno::create([
            'microciclo_id' => $request->microciclo_id,
            'titulo' => $request->titulo ?? '',
            'dia_semana' => $request->dia_semana ?? '',
            'orden' => $request->orden ?? 1,
]);

        return response()->json(['entreno' => $entreno]);
    }

    public function listar($microId)
    {
        return response()->json([
            'entrenos' => Entreno::where('microciclo_id', $microId)
                ->with('ejercicios.series')
                ->orderBy('orden')
                ->get()
        ]);
    }

    public function editar(Request $request, $id)
    {
        $entreno = Entreno::findOrFail($id);
        $entreno->update($request->all());

        return response()->json(['entreno' => $entreno]);
    }

    public function eliminar($id)
    {
        Entreno::findOrFail($id)->delete();
        return response()->json(['message' => 'Entreno eliminado']);
    }

    public function duplicar($id)
    {
        $original = Entreno::with('ejercicios.series')->findOrFail($id);

        $nuevo = Entreno::create([
            'microciclo_id' => $original->microciclo_id,
            'titulo' => $original->titulo,
            'dia_semana' => $original->dia_semana,
            'orden' => $original->orden + 1
        ]);

        foreach ($original->ejercicios as $e) {
            $newEj = $nuevo->ejercicios()->create([
                'grupo_muscular' => $e->grupo_muscular,
                'nombre' => $e->nombre,
                'video_url' => $e->video_url,
                'fatiga' => $e->fatiga
            ]);

            foreach ($e->series as $s) {
                $newEj->series()->create([
                    'reps_objetivo' => $s->reps_objetivo,
                    'rpe_objetivo' => $s->rpe_objetivo
                ]);
            }
        }

        return response()->json(['entreno_duplicado' => $nuevo]);
    }
}
