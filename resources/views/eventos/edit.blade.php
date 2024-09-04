@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Evento</h1>

    <form action="{{ route('eventos.update', $evento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre del Evento</label>
            <input type="text" name="nombre" class="form-control" value="{{ $evento->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha del Evento</label>
            <input type="date" name="fecha" class="form-control" value="{{ $evento->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" value="{{ $evento->ubicacion }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
