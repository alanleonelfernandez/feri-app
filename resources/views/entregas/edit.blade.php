@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Entrega</h1>

    <form action="{{ route('entregas.update', $entrega->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="{{ $entrega->direccion }}" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $entrega->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" name="hora" class="form-control" value="{{ $entrega->hora }}" required>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $entrega->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="1" {{ $entrega->estado ? 'selected' : '' }}>Entregado</option>
                <option value="0" {{ !$entrega->estado ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
