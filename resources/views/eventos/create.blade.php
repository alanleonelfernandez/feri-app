@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Evento</h1>

    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre del Evento</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha del Evento</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
