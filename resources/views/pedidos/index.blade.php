@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pedidos</h1>
    <a href="{{ route('pedidos.create') }}" class="btn btn-primary mb-3">Agregar Pedido</a>

    <form method="GET" action="{{ route('pedidos.index') }}">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="numero" class="form-control" placeholder="Número de Pedido" value="{{ request('numero') }}">
            </div>
            <div class="col">
                <select name="id_cliente" class="form-control">
                    <option value="">-- Cliente --</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('id_cliente') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <input type="date" name="fecha_pedido" class="form-control" placeholder="Fecha de Pedido" value="{{ request('fecha_pedido') }}">
            </div>
            <div class="col">
                <select name="pago" class="form-control">
                    <option value="">-- Estado Pago --</option>
                    <option value="1" {{ request('pago') == '1' ? 'selected' : '' }}>Pagado</option>
                    <option value="0" {{ request('pago') == '0' ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>
            <div class="col">
                <select name="id_entrega" class="form-control">
                    <option value="">-- Punto de Entrega --</option>
                    @foreach($entregas as $entrega)
                        <option value="{{ $entrega->id }}" {{ request('id_entrega') == $entrega->id ? 'selected' : '' }}>
                            {{ $entrega->punto_entrega }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <input type="date" name="fecha_evento" class="form-control" placeholder="Fecha de Evento" value="{{ request('fecha_evento') }}">
            </div>
            <div class="col">
                <select name="forma_pago" class="form-control">
                    <option value="">-- Forma de Pago --</option>
                    <option value="Efectivo" {{ request('forma_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="Transferencia" {{ request('forma_pago') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                    <option value="Mixto" {{ request('forma_pago') == 'Mixto' ? 'selected' : '' }}>Mixto</option>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <!-- Listado de pedidos -->
    @if($pedidos->count())
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha Pedido</th>
                    <th>Pago</th>
                    <th>Forma Pago</th>
                    <th>Punto de Entrega</th>
                    <th>Fecha Evento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->cliente->nombre }}</td>
                        <td>{{ $pedido->fecha_pedido }}</td>
                        <td>{{ $pedido->pago ? 'Saldado' : 'No Saldado' }}</td>
                        <td>{{ $pedido->forma_pago }}</td>
                        <td>{{ $pedido->entrega->punto_entrega }}</td>
                        <td>{{ $pedido->evento->fecha_evento }}</td>
                        <td>
                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-info">Ver Detalle</a>
                            <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pedidos->links() }}
    @else
        <p>No hay pedidos disponibles.</p>
    @endif
</div>
@endsection
