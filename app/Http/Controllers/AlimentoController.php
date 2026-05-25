<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentoController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('search', '');

        $alimentos = Alimento::where('nombre', 'like', "%{$query}%")
            ->limit(20)
            ->get(['id', 'nombre', 'categoria', 'proteinas', 'carbohidratos', 'grasas', 'kcal_por_100g']);

        return response()->json($alimentos);
    }
}