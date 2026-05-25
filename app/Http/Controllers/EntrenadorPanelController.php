<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainerRequest;

class EntrenadorPanelController extends Controller
{
    // =========================================================
    // ===============        DASHBOARD       ==================
    // =========================================================

    public function dashboard(Request $request)
    {
        $trainer = $request->user();

        // Obtener clientes asignados mediante tabla user_trainers
        $clientes = $trainer->clientesAsignados()
            ->select('users.id', 'users.name', 'users.email')
            ->get();

        return response()->json([
            'clientes' => $clientes
        ]);
    }


    // =========================================================
    // =============   SOLICITUDES ENTRENADOR   ===============
    // =========================================================

    public function enviarSolicitud(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $trainer = $request->user();

        // Buscar cliente por email
        $cliente = User::where('email', $request->email)->first();

        if (!$cliente) {
            return response()->json(['error' => 'No existe un usuario con ese email'], 404);
        }

        // No permitir enviarse a sí mismo
        if ($cliente->id === $trainer->id) {
            return response()->json(['error' => 'No puedes enviarte solicitud a ti mismo'], 400);
        }

        // Verificar si el cliente YA tiene entrenador
        if ($cliente->assignedTrainer()->exists()) {
            return response()->json(['error' => 'Este cliente ya tiene un entrenador asignado'], 409);
        }

        // Solicitud duplicada
        $existe = TrainerRequest::where('user_id', $cliente->id)
            ->where('trainer_id', $trainer->id)
            ->whereNull('aceptada')
            ->first();

        if ($existe) {
            return response()->json(['error' => 'Ya enviaste una solicitud a este cliente'], 409);
        }

        // Crear solicitud
        $solicitud = TrainerRequest::create([
            'trainer_id' => $trainer->id,
            'user_id'    => $cliente->id,
            'aceptada'   => null
        ]);

        return response()->json([
            'message' => 'Solicitud enviada correctamente',
            'solicitud' => $solicitud
        ], 201);
    }



    // =========================================================
    // ============   SOLICITUDES PARA EL CLIENTE   ============
    // =========================================================

    public function solicitudesPendientes(Request $request)
    {
        $cliente = $request->user();

        $solicitudes = TrainerRequest::where('user_id', $cliente->id)
            ->whereNull('aceptada')
            ->with('trainer:id,name,email')
            ->get();

        return response()->json($solicitudes);
    }



    // =========================================================
    // ============   ACEPTAR / RECHAZAR SOLICITUD   ==========
    // =========================================================

    public function responderSolicitud(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|in:aceptar,rechazar'
        ]);

        $solicitud = TrainerRequest::findOrFail($id);

        // Validar que pertenece al cliente autenticado
        if ($solicitud->user_id !== $request->user()->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // ACEPTAR
        if ($request->respuesta === 'aceptar') {

            $solicitud->aceptada = true;
            $solicitud->save();

            // Asignar entrenador en user_trainers
            $solicitud->trainer->clientesAsignados()
                ->syncWithoutDetaching([$solicitud->user_id]);

            // Eliminar otras solicitudes pendientes
            TrainerRequest::where('user_id', $solicitud->user_id)
                ->where('id', '!=', $solicitud->id)
                ->delete();

            return response()->json(['message' => 'Entrenador asignado correctamente']);
        }

        // RECHAZAR
        $solicitud->aceptada = false;
        $solicitud->save();

        return response()->json(['message' => 'Solicitud rechazada']);
    }
}
