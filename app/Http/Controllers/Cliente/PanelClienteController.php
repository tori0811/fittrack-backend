<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanelClienteController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user();

    return response()->json([
        'user' => $user,
        'trainer' => $user->assignedTrainer()->first(),
        'profile' => $user->profile,
        'questionnaire' => $user->questionnaire ?? null,

        // AÚN NO EXISTE EN BD
        'today_routine' => null,
        'diet' => null,
        'weekly_progress' => null,
        'journal' => null,
    ]);
}

}
