@extends('layouts.app')

@section('content')
    <h1>Detalle del Pedido</h1>

    <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre }}</p>
    <p><strong>Fecha del Pedido:</strong> {{ $pedido->fecha_pedido }}</p>
    <p><strong>Punto de Entrega:</strong> {{ $pedido->entrega->punto_entrega }}</p>
    <p><strong>Evento:</strong> {{ $pedido->evento->fecha_evento }}</p>
    <p><strong>Estado de Pago:</strong> {{ $pedido->pago ? 'Saldado' : 'Pendiente' }}</p>

    @if($pedido->pago)
        <p><strong>Forma de Pago:</strong> {{ $pedido->forma_pago }}</p>
    @endif

    <h3>Productos</h3>
    <table class="table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPedido = 0;
            @endphp
            @foreach($pedido->productos as $producto)
                @php
                    $subtotal = $producto->pivot->cantidad * $producto->pivot->precio;
                    $totalPedido += $subtotal;
                @endphp
                <tr>
                    <td>{{ $producto->sku }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->pivot->cantidad }}</td>
                    <td>${{ $producto->pivot->precio }}</td>
                    <td>${{ $subtotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

        <h4>Precio Total del Pedido: ${{ $totalPedido }}</h4>

    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
@endsection
