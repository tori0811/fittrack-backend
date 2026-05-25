<?php

namespace App\Http\Controllers;

use App\Models\Dieta;
use App\Models\Comida;
use App\Models\OpcionComida;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\DietaService;
use App\Models\plantillaDieta;

class DietaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | OBTENER DIETA ACTIVA DEL CLIENTE
    |--------------------------------------------------------------------------
    */
    public function dietaActiva(Request $request)
    {
        $user = $request->user();

        $dieta = Dieta::where('user_id', $user->id)
            ->where('activa', true)
            ->with(['comidas.opciones'])
            ->first();

        return response()->json([
            'dieta' => $dieta
        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | CREAR DIETA MANUAL (SIGUE FUNCIONANDO)
    |--------------------------------------------------------------------------
    */
    public function crearDieta(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'trainer_id' => 'required|exists:users,id',
            'titulo'     => 'required|string'
        ]);

        $dieta = Dieta::create($request->all());

        return response()->json([
            'message' => 'Dieta creada correctamente.',
            'dieta'   => $dieta
        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | AÑADIR COMIDA MANUAL
    |--------------------------------------------------------------------------
    */
    public function agregarComida(Request $request)
    {
        $request->validate([
            'dieta_id' => 'required|exists:dietas,id',
            'tipo'     => 'required|string',
            'dia'      => 'required|in:on,off'
        ]);

        $comida = Comida::create($request->all());

        return response()->json([
            'message' => 'Comida añadida.',
            'comida'  => $comida
        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | AÑADIR OPCIÓN MANUAL
    |--------------------------------------------------------------------------
    */
    public function agregarOpcion(Request $request)
    {
        $request->validate([
            'comida_id'     => 'required|exists:comidas,id',
            'titulo_opcion' => 'nullable|string',
            'alimentos'     => 'required|array'
        ]);

        $opcion = OpcionComida::create([
            'comida_id'     => $request->comida_id,
            'titulo_opcion' => $request->titulo_opcion,
            'alimentos'     => $request->alimentos
        ]);

        return response()->json([
            'message' => 'Opción añadida.',
            'opcion'  => $opcion
        ]);
    }

    public function duplicarComida($id)
{
    $comida = Comida::with('opciones')->findOrFail($id);

    // 1. duplicamos la comida
    $nueva = Comida::create([
        'dieta_id' => $comida->dieta_id,
        'tipo'     => $comida->tipo,
        'dia'      => $comida->dia,
        'hora'     => $comida->hora,
    ]);

    // 2. duplicamos las opciones
    foreach ($comida->opciones as $opcion) {
        OpcionComida::create([
            'comida_id'     => $nueva->id,
            'titulo_opcion' => $opcion->titulo_opcion,
            'alimentos'     => $opcion->alimentos,
        ]);
    }

    return response()->json([
        'message' => 'Comida duplicada correctamente',
        'comida'  => $nueva->load('opciones')
    ]);
}

public function editarOpcion(Request $request, $id)
{
    $request->validate([
        'titulo_opcion' => 'nullable|string',
        'alimentos'     => 'required|array'
    ]);

    $opcion = OpcionComida::findOrFail($id);

    $opcion->update([
        'titulo_opcion' => $request->titulo_opcion ?? $opcion->titulo_opcion,
        'alimentos'     => $request->alimentos
    ]);

    return response()->json([
        'message' => 'Opción actualizada correctamente',
        'opcion'  => $opcion
    ]);
}

    // --Funcion para Guardar la dieta!--
   public function storePlantilla(Request $request) {
    try {
        // Validar
        $request->validate([
            'titulo' => 'required|string',
        ]);
        
        // Crear Plantilla (con JSON)
        $plantilla = PlantillaDieta::create([
            'trainer_id' => auth()->id(),
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'tema' => $request->tema,
            'descripcion' => $request->descripcion,
            'modo_seguro' => $request->modo_seguro ?? false,
            'alergenos' => $request->alergenos ?? [],
            'advertencias' => $request->advertencias ?? [],
            'calorias_on' => $request->calorias_on,
            'calorias_off' => $request->calorias_off,
            'proteinas_on' => $request->proteinas_on,
            'proteinas_off' => $request->proteinas_off,
            'carbohidratos_on' => $request->carbohidratos_on,
            'carbohidratos_off' => $request->carbohidratos_off,
            'grasas_on' => $request->grasas_on,
            'grasas_off' => $request->grasas_off,
            'actividad_on' => $request->actividad_on,
            'actividad_off' => $request->actividad_off,
            'pre_entreno' => $request->pre_entreno,
            'post_entreno' => $request->post_entreno,
            'activa' => $request->activa ?? 0,
            'estructura' => $request->comidas ?? []
        ]);
        
        return response()->json([
            'message' => 'Plantilla guardada correctamente',
            'plantilla' => $plantilla
        ], 201);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al guardar la plantilla',
            'error' => $e->getMessage()
        ], 500);
    }
}
    public function indexPlantillas(Request $request) {
        //Obtenemos el trainer_id de la plantilla
        $trainerId = auth()->id();

        //Buscar las dietas
        $dietas = plantillaDieta::where('trainer_id', $trainerId)->get();
            return response()->json($dietas);
    }

    // --Funcion para Mostrar la dieta!--
    public function showPlantilla($id) {

        $dieta = plantillaDieta::where('id', $id)
            ->where('trainer_id', auth()->id())
            ->first();

            if(!$dieta) {
                return response()->json([
                    'message' => 'Plantilla no encontrada',
                ], 404);
            }

            return response()->json($dieta);
    }

    // --Funcion para actualizar la dieta!--
   public function updatePlantilla(Request $request, $id) {
    try {
        $request->validate([
            'titulo' => 'required|string',
            'comidas' => 'nullable|array',
        ]);
        
        $plantilla = PlantillaDieta::where('id', $id)
            ->where('trainer_id', auth()->id())
            ->first();
        
        if (!$plantilla) {
            return response()->json(['message' => 'No encontrada'], 404);
        }
        
        $plantilla->update([
            
            'titulo' => $request->titulo,
            'calorias_on' => $request->calorias_on,
            'calorias_off' => $request->calorias_off,
            'proteinas_on' => $request->proteinas_on,
            'proteinas_off' => $request->proteinas_off,
            'carbohidratos_on' => $request->carbohidratos_on,
            'carbohidratos_off' => $request->carbohidratos_off,
            'grasas_on' => $request->grasas_on,
            'grasas_off' => $request->grasas_off,
            'actividad_on' => $request->actividad_on,
            'actividad_off' => $request->actividad_off,
            'pre_entreno' => $request->pre_entreno,
            'post_entreno' => $request->post_entreno,
            'activa' => $request->activa ?? 0,
            'estructura' => $request->comidas
        ]);
        
        
        return response()->json([
            'message' => 'Actualizada',
            'plantilla' => $plantilla
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    // --Funcion para Eliminar la dieta!--
    public function destroyPlantilla($id) {
        
       $dieta = plantillaDieta::where('id', $id)
            ->where('trainer_id', auth()->id())
            ->first();
        
        if(!$dieta) {
            return response()->json([
                'message' => 'Plantilla no encontrada'
            ], 404);
        }

        $dieta->delete();

        return response()->json([
            'message' => 'Plantilla Eliminada correctamente'
        ]);
    }

    public function asignarPlantilla(Request $request, $id) {
        
        try {

        //validar que viene cliente_id

        $request->validate([
            'cliente_id' => 'required|exists:users,id'
        ]);

        //Buscar la plantilla con id 
        $plantilla = plantillaDieta::where('id', $id)
        ->where('trainer_id', auth()->id())
        ->first();

        if (!$plantilla) {
            return response()->json([
                'message' => 'Plantilla no encontrada'
            ], 404);
        }

        // Verificar si ya existe esta plantilla asignada a un cliente

        $existeAsignacion = Dieta::where('user_id', $request->cliente_id)
            ->where('plantillas_dieta_id', $id)
            ->exists();

        if($existeAsignacion) {
            return response()->json([
                'message' => 'Este cliente ya tiene esta plantilla asignada'
            ], 400);
        }

        //Crear una nueva plantilla copiando los datos de la plantilla y asi se guarda 
        $dieta = Dieta::create([
            'user_id' => $request->cliente_id,
            'trainer_id' => auth()->id(),
            'plantillas_dieta_id' => $id,
            'titulo' => $plantilla->titulo,
            'calorias_on' => $plantilla->calorias_on,
            'calorias_off' => $plantilla->calorias_off,
            'proteinas_on' => $plantilla->proteinas_on,
            'proteinas_off' => $plantilla->proteinas_off,
            'carbohidratos_on' => $plantilla->carbohidratos_on,
            'carbohidratos_off' => $plantilla->carbohidratos_off,
            'grasas_on' => $plantilla->grasas_on,
            'grasas_off' => $plantilla->grasas_off,
            'actividad_on' => $plantilla->actividad_on,
            'actividad_off' => $plantilla->actividad_off,
            'pre_entreno' => $plantilla->pre_entreno,
            'post_entreno' => $plantilla->post_entreno,
            'activa' => $plantilla->activa ?? 0,
            'estructura' => $plantilla->estructura
        ]);

        //return success

        return response()->json([
            'message' => 'Plantilla asignada con exito',
            'dieta' => $dieta
        ]);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asignar la plantilla',
                'error' => $e->getMessage()
            ],500);
        }
        
    }


}