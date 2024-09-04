@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Agregar Producto</a>

    <form method="GET" action="{{ route('productos.index') }}">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="descripcion" class="form-control" placeholder="Descripción" value="{{ request('descripcion') }}">
            </div>
            <div class="col">
                <input type="text" name="sku" class="form-control" placeholder="SKU" value="{{ request('sku') }}">
            </div>
            <div class="col">
                <select name="id_categoria" class="form-control">
                    <option value="">-- Categoría --</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('id_categoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select name="estado" class="form-control">
                    <option value="">-- Estado --</option>
                    <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
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
                <th>Descripción</th>
                <th>SKU</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->sku }}</td>
                    <td>{{ $producto->categoria->nombre }}</td>
                    <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $productos->links() }}
</div>
@endsection
