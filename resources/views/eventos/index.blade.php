@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Eventos</h1>
    <a href="{{ route('eventos.create') }}" class="btn btn-primary mb-3">Agregar Evento</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventos as $evento)
                <tr>
                    <td>{{ $evento->id }}</td>
                    <td>{{ $evento->nombre }}</td>
                    <td>{{ $evento->fecha }}</td>
                    <td>{{ $evento->ubicacion }}</td>
                    <td>
                        <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $eventos->links() }}
</div>
@endsection
