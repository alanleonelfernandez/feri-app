@extends('layouts.app')

@section('content')
    <h1>Categorías</h1>

    <div class="mb-3">
        <a href="{{ route('categorias.create') }}" class="btn btn-success">Crear Nueva Categoría</a>
    </div>

    <!-- Formulario de Búsqueda y Filtros -->
    <form method="GET" action="{{ route('categorias.index') }}" class="form-inline mb-3">
        <div class="form-group mr-2">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
        </div>
        <div class="form-group mr-2">
            <select name="estado" class="form-control">
                <option value="">-- Estado --</option>
                <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Tabla de Categorías -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->id }}</td>
                    <td>{{ $categoria->nombre }}</td>
                    <td>{{ $categoria->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No se encontraron categorías.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $categorias->links() }}
@endsection
