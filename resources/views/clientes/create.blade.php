@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre</label> <input type="text" name="nombre" class="form-control" required> </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" name="facebook" class="form-control">
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" class="form-control" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
       

