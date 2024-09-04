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
                <select name="cliente_id" class="form-control">
                    <option value="">-- Cliente --</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id }}</td>
                    <td>{{ $pedido->numero }}</td>
                    <td>{{ $pedido->cliente->nombre }}</td>
                    <td>{{ $pedido->fecha }}</td>
                    <td>{{ $pedido->total }}</td>
                    <td>{{ $pedido->estado ? 'Pagado' : 'Pendiente' }}</td>
                    <td>
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
</div>
@endsection
