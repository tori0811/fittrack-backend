<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrenador;

class EntrenadorController extends Controller
{
    public function index()
    {
        return Entrenador::all();
    }
}
