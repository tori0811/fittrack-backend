<?php

namespace App\Http\Controllers;

use App\Mail\InvitacionCliente;
use App\Models\Invitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitacionController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $token = Str::uuid();
        $entrenador = $request->user();

        Invitacion::create([
            'entrenador_id' => $entrenador->id,
            'email' => $request->email,
            'token' => $token,
        ]);

        $urlInvitacion = config('app.frontend_url') . '/registro?token=' . $token;

        Mail::to($request->email)->send(
            new InvitacionCliente($urlInvitacion, $entrenador->name)
        );

        return response()->json(['message' => 'Invitación enviada correctamente']);
    }
}