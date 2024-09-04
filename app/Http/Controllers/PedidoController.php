<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Entrega;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::paginate(10);
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $eventos = Evento::all();
        $entregas = Entrega::all();
        return view('pedidos.create', compact('clientes', 'eventos', 'entregas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'pago' => 'required|boolean',
            'forma_pago' => 'required|string|max:50',
            'fecha_pedido' => 'required|date',
            'id_evento' => 'nullable|exists:eventos,id',
            'id_entrega' => 'nullable|exists:entregas,id',
            'estado' => 'required|string|max:50',
        ]);

        Pedido::create($request->all());
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }

    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::all();
        $eventos = Evento::all();
        $entregas = Entrega::all();
        return view('pedidos.edit', compact('pedido', 'clientes', 'eventos', 'entregas'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'pago' => 'required|boolean',
            'forma_pago' => 'required|string|max:50',
            'fecha_pedido' => 'required|date',
            'id_evento' => 'nullable|exists:eventos,id',
            'id_entrega' => 'nullable|exists:entregas,id',
            'estado' => 'required|string|max:50',
        ]);

        $pedido->update($request->all());
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente.');
    }
}
