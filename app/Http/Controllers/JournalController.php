<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    // Cliente registra su diario
    public function crear(Request $request)
    {
        $request->validate([
            'fecha'        => 'required|date',
            'estado_animo' => 'nullable|string',
            'energia'      => 'nullable|integer',
            'suenio_horas' => 'nullable|integer',
            'entreno'      => 'nullable|boolean',
            'nota'         => 'nullable|string'
        ]);

        $entry = JournalEntry::create([
            'user_id'      => $request->user()->id,
            'fecha'        => $request->fecha,
            'estado_animo' => $request->estado_animo,
            'energia'      => $request->energia,
            'suenio_horas' => $request->suenio_horas,
            'entreno'      => $request->entreno ?? false,
            'nota'         => $request->nota
        ]);

        return response()->json([
            'message' => 'Journal registrado correctamente',
            'entry'   => $entry
        ]);
    }

    // Cliente obtiene su journal histórico
    public function historial(Request $request)
    {
        $user = $request->user();

        $historial = JournalEntry::where('user_id', $user->id)
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'historial' => $historial
        ]);
    }
}
