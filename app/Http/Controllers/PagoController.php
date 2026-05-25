<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;

class PagoController extends Controller
{
    public function ingresos(Request $request)
    {
        $trainer = $request->user();

        $pagos = Pago::where('trainer_id', $trainer->id)->get();

        return response()->json([
            "total" => $pagos->sum('cantidad'),
            "mes_actual" => $pagos->whereBetween("fecha", [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->sum('cantidad'),
            "pagos" => $pagos,
        ]);
    }

    public function historialPagos(Request $request)
    {
        $trainer = $request->user();

        $pagos = Pago::where('trainer_id', $trainer->id)
            ->with("cliente:id,name,email")
            ->orderBy("fecha", "desc")
            ->get();

        return response()->json($pagos);
    }

    public function registrarPago(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "cantidad" => "required|numeric|min:0",
            "descripcion" => "nullable|string",
        ]);

        $trainer = $request->user();

        $pago = Pago::create([
            "user_id" => $request->user_id,
            "trainer_id" => $trainer->id,
            "cantidad" => $request->cantidad,
            "descripcion" => $request->descripcion,
            "fecha" => now()->toDateString(),
        ]);

        return response()->json([
            "message" => "Pago registrado correctamente",
            "pago" => $pago
        ]);
    }
}
