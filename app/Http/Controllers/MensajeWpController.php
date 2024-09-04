<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeWp;

class MensajeWpController extends Controller
{
    public function index()
    {
        $mensajes = MensajeWp::paginate(10);
        return view('mensajes_wp.index', compact('mensajes'));
    }

    public function create()
    {
        return view('mensajes_wp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cuerpo' => 'required|string|max:255',
        ]);

        MensajeWp::create($request->all());
        return redirect()->route('mensajes_wp.index')->with('success', 'Mensaje de WhatsApp creado exitosamente.');
    }

    public function show(MensajeWp $mensajeWp)
    {
        return view('mensajes_wp.show', compact('mensajeWp'));
    }

    public function edit(MensajeWp $mensajeWp)
    {
        return view('mensajes_wp.edit', compact('mensajeWp'));
    }

    public function update(Request $request, MensajeWp $mensajeWp)
    {
        $request->validate([
            'cuerpo' => 'required|string|max:255',
        ]);

        $mensajeWp->update($request->all());
        return redirect()->route('mensajes_wp.index')->with('success', 'Mensaje de WhatsApp actualizado exitosamente.');
    }

    public function destroy(MensajeWp $mensajeWp)
    {
        $mensajeWp->delete();
        return redirect()->route('mensajes_wp.index')->with('success', 'Mensaje de WhatsApp eliminado exitosamente.');
    }
}