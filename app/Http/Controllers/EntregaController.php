<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrega;

class EntregaController extends Controller
{
    public function index()
    {
        $entregas = Entrega::paginate(10);
        return view('entregas.index', compact('entregas'));
    }

    public function create()
    {
        return view('entregas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'punto_entrega' => 'required|string|max:255',
        ]);

        Entrega::create($request->all());
        return redirect()->route('entregas.index')->with('success', 'Entrega creada exitosamente.');
    }

    public function show(Entrega $entrega)
    {
        return view('entregas.show', compact('entrega'));
    }

    public function edit(Entrega $entrega)
    {
        return view('entregas.edit', compact('entrega'));
    }

    public function update(Request $request, Entrega $entrega)
    {
        $request->validate([
            'punto_entrega' => 'required|string|max:255',
        ]);

        $entrega->update($request->all());
        return redirect()->route('entregas.index')->with('success', 'Entrega actualizada exitosamente.');
    }

    public function destroy(Entrega $entrega)
    {
        $entrega->delete();
        return redirect()->route('entregas.index')->with('success', 'Entrega eliminada exitosamente.');
    }
}
