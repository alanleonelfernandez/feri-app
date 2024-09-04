@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Pedido</h1>

    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="numero">Número de Pedido</label>
            <input type="text" name="numero" class="form-control" value="{{ $pedido->numero }}" required>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $pedido->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $pedido->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" name="total" class="form-control" value="{{ $pedido->total }}" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="1" {{ $pedido->estado ? 'selected' : '' }}>Pagado</option>
                <option value="0" {{ !$pedido->estado ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
