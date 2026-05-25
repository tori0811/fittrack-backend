<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantillaEntrenamiento;
use App\Models\Bloque;


class plantillaEntrenamientoController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'type' => 'nullable|string',
        'description' => 'nullable|string',
        'gender' => 'nullable|string',
        'routineType' => 'required|string',
        'level' => 'nullable|string',
        'theme' => 'nullable|string',
        'estructura' => 'nullable|array',
    ]);

    $plantilla = PlantillaEntrenamiento::create([
        'trainer_id' => auth()->id(),
        'name' => $data['name'],
        'type' => $data['type'] ?? null,
        'description' => $data['description'] ?? null,
        'gender' => $data['gender'] ?? null,
        'routineType' => $data['routineType'],
        'level' => $data['level'] ?? null,
        'theme' => $data['theme'] ?? null,
        'estructura' => $data['estructura'] ?? [],
    ]);

    return response()->json([
        'message' => 'Plantilla guardada correctamente',
        'plantilla' => $plantilla,
    ], 201);
}

    public function index() {
        $user = auth()->user(); 

        $plantillas = PlantillaEntrenamiento::where('trainer_id', $user->id )->get();
        
        return response()->json($plantillas);
        
        }

    public function destroy($id) {
        $user = auth()->user();
        $plantilla = PlantillaEntrenamiento::where('id', $id)
            ->where('trainer_id',$user->id)
            ->first();

        if($plantilla === null ) {
            return response()->json([
                'message' => 'Plantilla no encontrada'
            ],404);
        }
        $plantilla -> delete();
        return response()->json([
            'message' => 'La plantilla ha sido eliminada'
        ]);
    }

    public function update(Request $request, $id)
{
    $plantilla = PlantillaEntrenamiento::where('id', $id)
        ->where('trainer_id', auth()->id())
        ->first();

    if ($plantilla === null) {
        return response()->json(['message' => 'Plantilla no encontrada'], 404);
    }

    $data = $request->validate([
        'name' => 'required|string',
        'type' => 'nullable|string',
        'description' => 'nullable|string',
        'gender' => 'nullable|string',
        'routineType' => 'required|string',
        'level' => 'nullable|string',
        'theme' => 'nullable|string',
        'estructura' => 'nullable|array',
    ]);

    $plantilla->update($data);

    return response()->json([
        'message' => 'Plantilla editada correctamente',
        'plantilla' => $plantilla
    ]);
}

    public function show($id) {
        $plantilla = PlantillaEntrenamiento::findOrFail($id);
        return response()->json($plantilla);
    }

    public function asignarPlantilla(Request $request, $id) {
        
        try {

        //validar que viene cliente_id

        $request->validate([
            'cliente_id' => 'required|exists:users,id'
        ]);

        //Buscar la plantilla con id 
        $plantilla = plantillaEntrenamiento::where('id', $id)
        ->where('trainer_id', auth()->id())
        ->first();

        if (!$plantilla) {
            return response()->json([
                'message' => 'Plantilla no encontrada'
            ], 404);
        }

        //verificar si ya existe esta plantilla asignada a un cliente

        $existeAsignacion = Bloque::where('user_id', $request->cliente_id)
            ->where('plantilla_entrenamiento_id', $id)
            ->exists();

            if($existeAsignacion) {
                return response()->json([
                    'message' => 'Este cliente ya tiene esta plantilla asignada'
                ], 400);
            }

        //Crear una nueva plantilla copiando los datos de la plantilla y asi se guarda 
        $bloque = Bloque::create([
            'user_id' => $request->cliente_id,
            'trainer_id' => auth()->id(),
            'plantilla_entrenamiento_id' => $id,
            'titulo' => $plantilla->nombre,
            'descripcion' => $plantilla->descripcion,
            'numero_microciclos' => 0, 
            'completado' => false
        ]);

        //return success

        return response()->json([
            'message' => 'Plantilla asignada con exito',
            'bloque' => $bloque
        ]);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asignar la plantilla',
                'error' => $e->getMessage()
            ],500);
        }
        
    }

}
