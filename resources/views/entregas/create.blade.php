@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Entrega</h1>

    <form action="{{ route('entregas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" name="hora" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="1">Entregado</option>
                <option value="0">Pendiente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
