@extends('layouts.app')

@section('content')
    <h1>Crear Pedido</h1>

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf

        <!-- Cliente -->
        <div class="form-group">
            <label for="cliente">Cliente:</label>
            <select name="id_cliente" class="form-control">
                <option value="" disabled selected>Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Evento -->
        <div class="form-group">
            <label for="evento">Evento:</label>
            <select name="id_evento" class="form-control">
            <option value="" disabled selected>Seleccione un evento</option>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}">{{ $evento->fecha_evento }}</option>
                @endforeach
            </select>
        </div>

        <!-- Punto de Entrega -->
        <div class="form-group">
            <label for="entrega">Punto de Entrega:</label>
            <select name="id_entrega" class="form-control">
                <option value="" disabled selected>Seleccione un punto de entrega</option>
                @foreach($entregas as $entrega)
                    <option value="{{ $entrega->id }}">{{ $entrega->punto_entrega }}</option>
                @endforeach
            </select>
        </div>

        <!-- Seleccionar productos -->
        <div class="form-group">
            <label for="producto">Seleccionar Producto</label>
            <input type="hidden" name="productos" id="productosSeleccionados">
            <select id="selectProductos" class="form-control">
                <option value="">Seleccione un producto</option>
                <!-- Aquí se llenarán los productos con app.js -->
            </select>
            <button type="button" id="agregarProducto" class="btn btn-primary mt-2">Agregar Producto</button>
        </div>
        <!-- Contenedor para los productos seleccionados -->
        <div id="productos-seleccionados" class="mt-3">
            <h4>Productos seleccionados:</h4>
            <ul id="lista-productos" class="list-group"></ul>
        </div>

        <!-- Fecha del pedido -->
        <div class="form-group">
            <label for="fecha_pedido">Fecha del Pedido</label>
            <input type="date" id="fecha_pedido" name="fecha_pedido" class="form-control" value="{{ old('fecha_pedido', isset($pedido) ? $pedido->fecha_pedido : now()->format('Y-m-d')) }}">
        </div>

        <!-- Estado de pago -->
        <div class="form-group">
            <label for="pago">Estado</label>
            <select name="pago" id="pago" class="form-control">
                <option value="0" {{ old('pago', $pedido->pago ?? '') == 0 ? 'selected' : '' }}>Pendiente</option>
                <option value="1" {{ old('pago', $pedido->pago ?? '') == 1 ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>
        <!-- Solo se muestra si esta Pagado -->
        <div id="forma_pago_container" style="display: none;">
            <label for="forma_pago">Forma de Pago</label>
            <select name="forma_pago" id="forma_pago" class="form-control">
                <option value="">Seleccione una opción</option>
                <option value="Efectivo" {{ old('forma_pago', $pedido->forma_pago ?? '') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="Transferencia" {{ old('forma_pago', $pedido->forma_pago ?? '') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                <option value="Mixto" {{ old('forma_pago', $pedido->forma_pago ?? '') == 'Mixto' ? 'selected' : '' }}>Mixto</option>
            </select>
        </div>

        <!-- Total del pedido -->
        <div class="form-group mt-3">
            <label for="totalPedido">Total del Pedido:</label>
            <input type="text" id="totalPedido" class="form-control" value="0" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    <script>
        document.addEventListener('input', function() {
            let total = 0;
            document.querySelectorAll('input[name^="productos"]').forEach(function(input) {
                const cantidad = parseInt(input.value || 0);
                const precio = @json($productos->pluck('precio_venta', 'id'));
                total += cantidad * (precio[input.name.split('[')[1].replace(']', '')] || 0);
            });
            document.getElementById('total').value = total;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectEstado = document.querySelector('#pago');
            const selectFormaPago = document.querySelector('#forma_pago');
            const formaPagoContainer = document.querySelector('#forma_pago_container');

            function toggleFormaPago() {
                if (selectEstado.value === '1') {
                    formaPagoContainer.style.display = 'block';
                    selectFormaPago.required = true;
                } else {
                    formaPagoContainer.style.display = 'none';
                    selectFormaPago.required = false;
                }
            }

            toggleFormaPago();

            selectEstado.addEventListener('change', toggleFormaPago);
        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
