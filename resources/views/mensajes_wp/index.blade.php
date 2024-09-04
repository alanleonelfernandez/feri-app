@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mensajes de WhatsApp</h1>
    <a href="{{ route('mensajes_wp.create') }}" class="btn btn-primary mb-3">Agregar Mensaje</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mensaje</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mensajes as $mensaje)
                <tr>
                    <td>{{ $mensaje->id }}</td>
                    <td>{{ $mensaje->texto }}</td>
                    <td>{{ $mensaje->cliente->nombre }}</td>
                    <td>{{ $mensaje->fecha }}</td>
                    <td>{{ $mensaje->hora }}</td>
                    <td>
                        <a href="{{ route('mensajes_wp.edit', $mensaje->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('mensajes_wp.destroy', $mensaje->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $mensajes->links() }}
</div>
@endsection
