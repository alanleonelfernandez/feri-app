@extends('layouts.app')

@section('content')
    <h1>Editar Pedido</h1>

    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Cliente -->
        <div class="form-group">
            <label for="id_cliente">Cliente</label>
            <select name="id_cliente" id="id_cliente" class="form-control">
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $pedido->id_cliente == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        

        <!-- Evento -->
        <div class="form-group">
            <label for="id_evento">Evento</label>
            <select name="id_evento" id="id_evento" class="form-control">
                @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}" {{ $pedido->id_evento == $evento->id ? 'selected' : '' }}>
                        {{ $evento->fecha_evento }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Punto de Entrega -->
        <div class="form-group">
            <label for="id_entrega">Punto de Entrega</label>
            <select name="id_entrega" id="id_entrega" class="form-control">
                @foreach($entregas as $entrega)
                    <option value="{{ $entrega->id }}" {{ $pedido->id_entrega == $entrega->id ? 'selected' : '' }}>
                    {{ $entrega->punto_entrega}}
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
            <ul id="lista-productos" class="list-group">
                <!-- Aquí se rellenarán los productos preseleccionados -->
                @foreach($pedido->productos as $producto)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $producto->descripcion }} (SKU: {{ $producto->sku }}) - Precio: ${{ $producto->precio_venta }}
                        <input type="hidden" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}">
                        <input type="number" name="productos[{{ $producto->id }}][cantidad]" min="1" max="{{ $producto->stock }}" value="{{ $producto->pivot->cantidad }}" class="form-control cantidad-producto mx-2" style="width: 60px;" data-id="{{ $producto->id }}">
                        <span class="badge badge-primary badge-pill total-producto">Total: ${{ $producto->precio_venta * $producto->pivot->cantidad }}</span>
                        <button class="btn btn-danger btn-sm eliminar-producto" data-id="{{ $producto->id }}">Eliminar</button>
                    </li>
                @endforeach
            </ul>
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

        <button type="submit" class="btn btn-primary">Actualizar</button>
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
    <script>
        const productosPreseleccionados = @json($pedido->productos);
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
