<?php

namespace App\Http\Controllers;

use App\Models\Microciclo;
use App\Models\Entreno;
use Illuminate\Http\Request;

class MicrocicloController extends Controller
{
    public function crear(Request $request)
    {
        $request->validate([
            'bloque_id' => 'required|exists:bloques,id',
            'numero' => 'required|integer|min:1',
            'descarga' => 'boolean'
        ]);

        $micro = Microciclo::create([
            'bloque_id' => $request->bloque_id,
            'numero' => $request->numero,
            'descarga' => $request->descarga ?? false
        ]);

        return response()->json(['microciclo' => $micro]);
    }

    public function listar($bloqueId)
    {
        return response()->json([
            'microciclos' => Microciclo::where('bloque_id', $bloqueId)
                ->with(['entrenos.ejercicios.series'])
                ->orderBy('numero')
                ->get()
        ]);
    }

    public function editar(Request $request, $id)
    {
        $micro = Microciclo::findOrFail($id);

        $micro->update($request->only([
            'numero',
            'descarga'
        ]));

        return response()->json(['microciclo' => $micro]);
    }

    public function eliminar($id)
    {
        Microciclo::findOrFail($id)->delete();

        return response()->json(['message' => 'Microciclo eliminado']);
    }

    public function duplicar($microId)
    {
        $original = Microciclo::with('entrenos.ejercicios.series')->findOrFail($microId);

        // Buscar el número más alto del bloque
        $maxNumero = Microciclo::where('bloque_id', $original->bloque_id)->max('numero');

        // Crear nuevo microciclo
        $nuevo = Microciclo::create([
            'bloque_id' => $original->bloque_id,
            'numero' => $maxNumero + 1,
            'descarga' => $original->descarga
        ]);

        // Duplicar entrenos → ejercicios → series
        foreach ($original->entrenos as $entreno) {

            $newEntreno = Entreno::create([
                'microciclo_id' => $nuevo->id,
                'titulo' => $entreno->titulo,
                'dia_semana' => $entreno->dia_semana,
                'orden' => $entreno->orden
            ]);

            foreach ($entreno->ejercicios as $e) {

                $newEj = $newEntreno->ejercicios()->create([
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
        }

        return response()->json(['microciclo_duplicado' => $nuevo]);
    }
}
