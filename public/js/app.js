document.addEventListener('DOMContentLoaded', function () {
    const selectProductos = document.querySelector('#selectProductos');
    const agregarProductoBtn = document.querySelector('#agregarProducto');
    const listaProductos = document.querySelector('#lista-productos');
    const totalPedido = document.querySelector('#totalPedido');

    // Si existen productos preseleccionados al editar el pedido, los cargamos; sino, array vacío.
    let productosSeleccionados = typeof productosPreseleccionados !== 'undefined' ? productosPreseleccionados.map(producto => {
        return {
            id: producto.id,
            descripcion: producto.descripcion,
            sku: producto.sku,
            precio_venta: producto.precio_venta,
            cantidad: producto.pivot.cantidad,
            stock: producto.stock
        };
    }) : [];

    let total = 0;

    // Función para cargar los productos disponibles
    function cargarProductos() {
        fetch('/obtener-productos')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la API');
                }
                return response.json();
            })
            .then(data => {
                if (Array.isArray(data)) {
                    data.sort((a, b) => a.descripcion.localeCompare(b.descripcion));

                    selectProductos.innerHTML = '<option value="">Seleccione un producto</option>';

                    data.forEach(producto => {
                        const option = document.createElement('option');
                        option.value = JSON.stringify(producto);
                        option.textContent = `${producto.descripcion} (SKU: ${producto.sku}) - Precio: $${producto.precio_venta}`;
                        selectProductos.appendChild(option);
                    });

                    //Solo en edit: Si ya hay productos preseleccionados, los renderizamos
                    if (productosSeleccionados.length > 0) {
                        renderizarListaProductos();
                    }
                } else {
                    console.error('Respuesta inesperada de productos: ', data);
                }
            })
            .catch(error => {
                console.error('Error al obtener los productos: ', error);
            });
    }

    //Función para renderizar la lista de productos seleccionados(preseleccionados o nuevos)
    function renderizarListaProductos() {
        listaProductos.innerHTML = ''; //Limpiamos la lista de productos previamente seleccionados
        total = 0;

        productosSeleccionados.forEach(producto => {
            const totalProducto = producto.precio_venta * producto.cantidad; //Calculamos el total por producto
            total += totalProducto;

            const li = document.createElement('li');
            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

            li.innerHTML = `
                ${producto.descripcion} (SKU: ${producto.sku}) - Precio: $${producto.precio_venta}
                <input type="hidden" name="productos[${producto.id}][id]" value="${producto.id}">
                <input type="number" name="productos[${producto.id}][cantidad]" min="1" max="${producto.stock}" value="${producto.cantidad}" class="form-control cantidad-producto mx-2" style="width: 60px;" data-id="${producto.id}">
                <span class="badge badge-primary badge-pill total-producto">Total: $${totalProducto.toFixed(2)}</span>
                <button class="btn btn-danger btn-sm eliminar-producto" data-id="${producto.id}">Eliminar</button>
            `;

            listaProductos.appendChild(li);
        });

        totalPedido.value = total.toFixed(2); //Total del pedido con 2 decimales
    }

    //Función para agregar un producto seleccionado desde el select
    function agregarProducto() {
        const productoSeleccionado = selectProductos.value ? JSON.parse(selectProductos.value) : null;

        if (productoSeleccionado) {
            const productoExistente = productosSeleccionados.find(p => p.id === productoSeleccionado.id);

            //Si el producto no está seleccionado, lo agregamos con cantidad inicial de 1
            if (!productoExistente) {
                productoSeleccionado.cantidad = 1;
                productosSeleccionados.push(productoSeleccionado);
            } else {
                if (productoExistente.cantidad < productoSeleccionado.stock) {
                    productoExistente.cantidad++;
                } else {
                    alert('No puedes agregar más de este producto, no hay suficiente stock.');
                }
            }

            renderizarListaProductos(); //Renderizamos la lista actualizada de productos
        } else {
            alert('Por favor, selecciona un producto válido.');
        }
    }

    //Eventlistener para el botón "Agregar Producto"
    agregarProductoBtn.addEventListener('click', agregarProducto);

    //Eventlistener para eliminar un producto de la lista
    listaProductos.addEventListener('click', function (e) {
        if (e.target.classList.contains('eliminar-producto')) {
            const productoId = e.target.getAttribute('data-id');
            productosSeleccionados = productosSeleccionados.filter(p => p.id !== parseInt(productoId));
            renderizarListaProductos(); //Actualizamos la lista después de eliminar un producto
        }
    });

    //Eventlistener para cambiar la cantidad de un producto seleccionado
    listaProductos.addEventListener('input', function (e) {
        if (e.target.classList.contains('cantidad-producto')) {
            const productoId = e.target.getAttribute('data-id');
            const nuevaCantidad = parseInt(e.target.value);
            const producto = productosSeleccionados.find(p => p.id === parseInt(productoId));

            if (producto && nuevaCantidad <= producto.stock && nuevaCantidad > 0) {
                producto.cantidad = nuevaCantidad;
                renderizarListaProductos(); //Actualizamos lista de prodcutos
            } else {
                alert('Cantidad inválida o excede el stock disponible.');
                e.target.value = producto.cantidad; //Revertimos a la cantidad previa si es inválida
            }
        }
    });

    //Función para actualizar el campo de productos en el formulario antes de enviarlo
    function actualizarInputProductos() {
        const inputProductos = document.querySelector('#productosSeleccionados');
        inputProductos.value = JSON.stringify(productosSeleccionados);
    }

    // Event listener para enviar el formulario
    const formulario = document.querySelector('form');
    formulario.addEventListener('submit', actualizarInputProductos);

    // Cargamos los productos disponibles en el select (create y edit)
    cargarProductos();
});
