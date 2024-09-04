@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Mensaje de WhatsApp</h1>

    <form action="{{ route('mensajes_wp.update', $mensaje->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="texto">Mensaje</label>
            <textarea name="texto" class="form-control" required>{{ $mensaje->texto }}</textarea>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $mensaje->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $mensaje->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" name="hora" class="form-control" value="{{ $mensaje->hora }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
