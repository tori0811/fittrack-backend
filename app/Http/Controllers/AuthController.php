<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request) {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Login correcto',
            'user' => $user,
            'role' => $user->role,
            'token' => $token
        ]);
    }

    public function register(Request $request) {

        $role = $request->input('role', 'cliente');

        if ($role === 'entrenador') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'especialidad' => 'nullable|string',
                'telefono' => 'nullable|string',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'entrenador'
            ]);

            \App\Models\Entrenador::create([
                'user_id' => $user->id,
                'nombre' => $request->name,
                'especialidad' => $request->especialidad,
            ]);

        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'documento' => 'required|string',
                'email' => 'required|email|unique:users',
                'telefono' => 'required|string',
                'pais' => 'required|string',
                'provincia' => 'required|string',
                'ciudad' => 'required|string',
                'codigo_postal' => 'required|string',
                'direccion' => 'required|string',
                'direccion_secundaria' => 'nullable|string',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'cliente'
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'apellido' => $request->apellido,
                'documento' => $request->documento,
                'telefono' => $request->telefono,
                'pais' => $request->pais,
                'provincia' => $request->provincia,
                'ciudad' => $request->ciudad,
                'codigo_postal' => $request->codigo_postal,
                'direccion' => $request->direccion,
                'direccion_secundaria' => $request->direccion_secundaria,
            ]);

            // Vincular con entrenador si viene con token de invitación
            if ($request->token) {
                $invitacion = \App\Models\Invitacion::where('token', $request->token)
                    ->where('usado', false)
                    ->first();

                if ($invitacion) {
                    $user->trainer_id = $invitacion->trainer_id;
                    $user->save();

                    $invitacion->usado = true;
                    $invitacion->save();
                }
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user,
            'role' => $user->role,
            'token' => $token
        ]);
    }
}