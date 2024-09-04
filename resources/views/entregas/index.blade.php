@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entregas</h1>
    <a href="{{ route('entregas.create') }}" class="btn btn-primary mb-3">Agregar Entrega</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dirección</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entregas as $entrega)
                <tr>
                    <td>{{ $entrega->id }}</td>
                    <td>{{ $entrega->direccion }}</td>
                    <td>{{ $entrega->fecha }}</td>
                    <td>{{ $entrega->hora }}</td>
                    <td>{{ $entrega->cliente->nombre }}</td>
                    <td>{{ $entrega->estado ? 'Entregado' : 'Pendiente' }}</td>
                    <td>
                        <a href="{{ route('entregas.edit', $entrega->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('entregas.destroy', $entrega->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $entregas->links() }}
</div>
@endsection
