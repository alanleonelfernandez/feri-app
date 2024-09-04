@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Mensaje de WhatsApp</h1>

    <form action="{{ route('mensajes_wp.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="texto">Mensaje</label>
            <textarea name="texto" class="form-control" required></textarea>
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
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" name="hora" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
