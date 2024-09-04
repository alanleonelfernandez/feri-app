@extends('layouts.app')

@section('content')
    <h1>Bienvenido a Feri-App</h1>

    <section class="mt-5">
        <h2>Próximo Evento</h2>
        @if($proximoEvento)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Fecha: {{ \Carbon\Carbon::parse($proximoEvento->fecha_evento)->format('d/m/Y') }}</h5>
                    @if($proximoEvento->link_vivo)
                        <p class="card-text"><a href="{{ $proximoEvento->link_vivo }}" target="_blank">Ver Evento en Vivo</a></p>
                    @endif
                </div>
            </div>
        @else
            <p>No hay eventos próximos programados.</p>
        @endif
    </section>

    <section class="mt-5">
        <h2>Secciones</h2>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('categorias.index') }}" class="btn btn-primary btn-block">Categorías</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('productos.index') }}" class="btn btn-primary btn-block">Productos</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-block">Clientes</a>
            </div>
            <div class="col-md-4 mt-3">
                <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-block">Pedidos</a>
            </div>
            <div class="col-md-4 mt-3">
                <a href="{{ route('eventos.index') }}" class="btn btn-primary btn-block">Eventos</a>
            </div>
            <div class="col-md-4 mt-3">
                <a href="{{ route('entregas.index') }}" class="btn btn-primary btn-block">Entregas</a>
            </div>
            <div class="col-md-4 mt-3">
                <a href="{{ route('mensajes_wp.index') }}" class="btn btn-primary btn-block">Mensajes WhatsApp</a>
            </div>
        </div>
    </section>
@endsection