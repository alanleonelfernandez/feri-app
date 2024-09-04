<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class HomeController extends Controller
{
    public function index()
    {
        //Muestra el próximo evento
        $proximoEvento = Evento::where('fecha_evento', '>=', now()->toDateString())
                               ->orderBy('fecha_evento', 'asc')
                               ->first();

        return view('home', compact('proximoEvento'));
    }
}
