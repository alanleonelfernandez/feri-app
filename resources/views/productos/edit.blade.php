@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" class="form-control" value="{{ $producto->descripcion }}" required>
        </div>

        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ $producto->sku }}" required>
        </div>

        <div class="form-group">
            <label for="id_categoria">Categoría</label>
            <select name="id_categoria" class="form-control" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $producto->id_categoria == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control" required>
                <option value="1" {{ $producto->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$producto->estado ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
