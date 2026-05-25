<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserQuestionnaire;


class QuestionnaireController extends Controller
{
    public function store(Request $request) {
        
        //validamos datos
        $request->validate([
            'objetivo' => 'required|string',
            'actividad' => 'required|string',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'dias' => 'required|integer',
            'experiencia' => 'required|string',
            'tuvo_lesion' => 'required|string',
            'lesion_pasada' => 'nullable|string',
            'intolerancias' => 'nullable|array',
            'estilo_alimentacion' => 'nullable|string',
            'alimentos_no_gustan' => 'nullable|string',
        ]);
        //Guardamos el cuestionario 

        $cuestionario = UserQuestionnaire::create([
            'user_id' => auth()->id(),

            'objetivo' => $request->objetivo,
            'actividad' => $request->actividad,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'dias' => $request->dias,
            'experiencia' => $request->experiencia,

            'tuvo_lesion' => $request->tuvo_lesion,
            'lesion_pasada' => $request->lesion_pasada,

            'intolerancias' => $request->intolerancias,
            'estilo_alimentacion' => $request->estilo_alimentacion,
            'alimentos_no_gustan' => $request->alimentos_no_gustan,
            'agua' => $request->agua,
            'sueno' => $request->sueno,
            'estres'=> $request->estres,
        ]);

    
        return response()->json([
            'message' => 'Cuestionario guardado correctamente',
            'data' => $cuestionario
        ]);
    }

    public function check(Request $request) {
    $userId = auth()->id();

    // Buscar si el usuario ya tiene un cuestionario
    $existe = \App\Models\UserQuestionnaire::where('user_id', $userId)->exists();

    return response()->json([
        'completed' => $existe
    ]);
}
}
