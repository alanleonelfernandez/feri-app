@extends('layouts.app')

@section('content')
    <h1>Editar Categoría</h1>

    <form method="POST" action="{{ route('categorias.update', $categoria->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre) }}" required>
            @error('nombre')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="estado">Estado:</label>
            <select name="estado" class="form-control">
                <option value="1" {{ old('estado', $categoria->estado) == '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado', $categoria->estado) == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
