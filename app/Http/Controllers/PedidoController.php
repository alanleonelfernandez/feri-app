<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Entrega;
use App\Models\Producto;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        //Obtener los datos necesarios para los filtros y la visualización
        $clientes = Cliente::all();
        $entregas = Entrega::all();
        $eventos = Evento::all();

        $query = Pedido::query();

        if ($request->filled('numero')) {
            $query->where('id', $request->input('numero'));
        }
    
        if ($request->filled('id_cliente')) {
            $query->where('id_cliente', $request->input('id_cliente'));
        }
    
        if ($request->filled('fecha_pedido')) {
            $query->whereDate('fecha_pedido', $request->input('fecha_pedido'));
        }
    
        if ($request->filled('pago')) {
            $query->where('pago', $request->input('pago'));
        }
    
        if ($request->filled('id_entrega')) {
            $query->where('id_entrega', $request->input('id_entrega'));
        }
    
        if ($request->filled('fecha_evento')) {
            $query->whereHas('evento', function ($q) use ($request) {
                $q->whereDate('fecha_evento', $request->input('fecha_evento'));
            });
        }
    
        if ($request->filled('forma_pago')) {
            $query->where('forma_pago', $request->input('forma_pago'));
        }
    
        $pedidos = $query->paginate(10);

        return view('pedidos.index', compact('pedidos', 'clientes', 'entregas', 'eventos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $eventos = Evento::all();
        $entregas = Entrega::all();
        $productos = Producto::where('stock', '>', 0)->get();
        return view('pedidos.create', compact('clientes', 'eventos', 'entregas', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'id_evento' => 'required|exists:evento,id',
            'id_entrega' => 'required|exists:entregas,id',
            'pago' => 'required|in:0,1',
            'forma_pago' => 'required_if:pago,1|nullable',
            'fecha_pedido' => 'required|date',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $pedido = new Pedido();
        $pedido->id_cliente = $request->input('id_cliente');
        $pedido->id_evento = $request->input('id_evento');
        $pedido->id_entrega = $request->input('id_entrega');
        $pedido->pago = $request->input('estado') === 'Pagado' ? 1 : 0;
        $pedido->forma_pago = $request->input('estado') === 'Pagado' ? $request->input('forma_pago') : null;
        $pedido->estado = 1;
        $pedido->fecha_pedido = $request->input('fecha_pedido');
        $pedido->save();
    
        $productos = $request->input('productos');
        foreach ($productos as $producto) {
            $productoModel = Producto::findOrFail($producto['id']);
            $pedido->productos()->attach($producto['id'], [
                'cantidad' => $producto['cantidad'],
                'precio' => $productoModel->precio_venta,
            ]);
        }
    
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente');
    }

    public function show($id)
    {
        $pedido = Pedido::with('productos')->findOrFail($id);
    
        //Calcular el precio total del pedido
        $total = $pedido->productos->sum(function ($producto) {
            return $producto->pivot->precio_total;
        });
    
        return view('pedidos.show', compact('pedido', 'total'));
    }

    public function edit($id)
    {
        $pedido = Pedido::with('productos')->findOrFail($id);
        $clientes = Cliente::all();
        $productos = Producto::where('stock', '>', 0)->get();
        $productos_ = Producto::orderBy('descripcion')->get();
        $eventos = Evento::all();
        $entregas = Entrega::all();
    
        return view('pedidos.edit', compact('pedido', 'clientes', 'productos', 'eventos', 'entregas'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'pago' => 'required|in:0,1',
            'forma_pago' => 'required_if:pago,1|nullable',
            'fecha_pedido' => 'required|date',
            'id_evento' => 'nullable|exists:evento,id',
            'id_entrega' => 'nullable|exists:entregas,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $pedido->update($request->all());

        $pedido->productos()->detach();
        $productos = $request->input('productos');
        foreach ($productos as $producto) {
            $productoModel = Producto::findOrFail($producto['id']);
            $pedido->productos()->attach($producto['id'], [
                'cantidad' => $producto['cantidad'],
                'precio' => $productoModel->precio_venta,
            ]);
        }
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente.');
    }

    public function obtenerProductos()
    {
        try {
            $productos = Producto::where('estado', 1)
                ->where('stock', '>', 0)
                ->get(['id', 'descripcion', 'sku', 'precio_venta', 'stock']);
    
            return response()->json($productos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los productos'], 500);
        }
    }
    
    
}
