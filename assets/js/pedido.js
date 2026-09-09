var productosListados = [];
var carrito = [];

function initPedidos() {
    listadoProductos();
    listadoClientes();
    
}

function listadoProductos(historial = 0) {
    $.ajax({
        url: 'ajax/listadoProductosAjax.php',
        type: 'GET',
        data: { sedeId: SEDE_ID }, // Pasar la sede_id para obtener stock correcto
        success: function(response) {
            response = JSON.parse(response);
            productosListados = response.data; // Guardar los productos en la variable global
            $data = dataSelectProductos(response.data);
            selectProductos($data);
        }
    });
}

function listadoClientes() {
    $.ajax({
        url: 'ajax/clientesAjax.php',
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            $data = dataSelectClientes(response.data);
            selectClientes($data);
        }
    });
}

function dataSelectProductos(params) {
    $data = [];
    params.forEach(item => {
        let cantidad = parseFloat(item.cantidad) || 0;
        let textoStock = cantidad > 0 ? `(${cantidad})` : '(Sin stock)';
        let claseStock = cantidad === 0 ? 'style="color: #dc3545; font-weight: bold;"' : '';

        $data.push({
            id: item.idPresentacion,
            text: `${item.nombre} - ${item.presentacion} - $${separarMiles(item.precio)} <span ${claseStock}>${textoStock}</span>`,
            html: `${item.nombre} - ${item.presentacion} - $${separarMiles(item.precio)} <span ${claseStock}>${textoStock}</span>`,
            cantidad: cantidad,
            disabled: cantidad === 0
        });
    });

    return $data;
}

function dataSelectClientes(params) {
    $data = [];
    params.forEach(item => {
        $data.push({
            id: item.id_usuario,
            text: `${item.nombre_usuario}`
        });
    });

    return $data;
}

function selectClientes(data) {
    $('#cliente-select').select2({
        data: data,
        placeholder: "Seleccione una opción",
        allowClear: true,
        theme: "default"
    });
}

function selectProductos(data) {
    $('#producto-select').select2({
        data: data,
        placeholder: "Seleccione una opción",
        allowClear: true,
        theme: "default",
        templateResult: function(option) {
            if (!option.id) return option.text;
            let $span = $('<span>' + option.html + '</span>');
            if (option.cantidad === 0) {
                $span.css('opacity', '0.6');
            }
            return $span;
        },
        templateSelection: function(option) {
            if (!option.id) return option.text;
            let text = option.text.replace(/<span[^>]*>.*<\/span>/g, '').trim();
            return $('<span>' + text + '</span>');
        }
    });

    // Validar selección de producto
    $('#producto-select').on('select2:selecting', function(e) {
        let optionId = e.params.data.id;

        // Buscar el producto en el array para obtener la cantidad real
        let producto = productosListados.find(p => p.idPresentacion == optionId);

        if (producto && parseFloat(producto.cantidad) === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Sin stock disponible',
                text: `"${e.params.data.text.replace(/<span[^>]*>.*<\/span>/g, '').trim()}" no tiene stock disponible. No se permite seleccionar este producto.`,
                confirmButtonText: 'Entendido'
            });
            return false;
        }
    });

    // Estilizar opciones sin stock al abrir el dropdown
    $('#producto-select').on('select2:open', function() {
        setTimeout(() => {
            $('.select2-results__option').each(function() {
                let $option = $(this);
                let text = $option.text();
                if (text.includes('Sin stock')) {
                    $option.css({
                        'opacity': '0.5',
                        'color': '#dc3545',
                        'cursor': 'not-allowed'
                    });
                    $option.on('click', function(e) {
                        e.stopPropagation();
                    });
                }
            });
        }, 10);
    });
}

function agregarProducto() {
    let productoId = $('#producto-select').val();
    let cantidad = $('#cantidad').val();

    if (!productoId || !cantidad) {
        Swal.fire('Error', 'Por favor, seleccione un producto y una cantidad.', 'error');
        return;
    }

    let producto = productosListados.find(p => p.idPresentacion == productoId);

    if (!producto) {
        Swal.fire('Error', 'Producto no encontrado.', 'error');
        return;
    }

    // Validar stock disponible
    let stockDisponible = parseFloat(producto.cantidad) || 0;
    if (stockDisponible === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin stock',
            text: `"${producto.nombre} - ${producto.presentacion}" no tiene stock disponible.`,
            confirmButtonText: 'Entendido'
        });
        return;
    }

    // Validar que cantidad solicitada no exceda el stock
    if (parseFloat(cantidad) > stockDisponible) {
        Swal.fire({
            icon: 'warning',
            title: 'Stock insuficiente',
            text: `Solo hay ${stockDisponible} unidades disponibles de "${producto.nombre} - ${producto.presentacion}".`,
            confirmButtonText: 'Entendido'
        });
        return;
    }

    let total = producto.precio * cantidad;
    let precioCompraTotal = producto.precioCompra * cantidad;
    let precioVentaJMTotal = producto.precioVentaJM * cantidad;
    carrito.push({
        nombre: producto.nombre + ' - ' + producto.presentacion,
        presentacion: producto.presentacion,
        idPresentacion: producto.idPresentacion,
        cantidad: cantidad,
        precioVenta: producto.precio,
        precioCompra: producto.precioCompra,
        precioCompraTotal: precioCompraTotal,
        precioVentaJMTotal: precioVentaJMTotal,
        total: total
    });

    mostrarCarrito();
    $('#producto-select').val(null).trigger('change');
    $('#cantidad').val('');
}

function mostrarCarrito() {
    
    let tableBody = $('#carrito-table tbody');
    tableBody.empty();

    carrito.forEach(item => {
        let row = `
            <tr>
                <td>${item.nombre}</td>
                <td>${item.cantidad}</td>
                <td>$${separarMiles(item.total)}</td>
                <td><button class="btn btn-danger" title="Eliminar" onclick="eliminarProducto('${item.presentacion}')"><i class="fa-solid fa-trash"></i></button></td>
            </tr>
        `;
        tableBody.append(row);
    });

    calcularTotal();
}

function eliminarProducto(presentacion) {
    carrito = carrito.filter(item => item.presentacion !== presentacion);
    mostrarCarrito();
}

function calcularTotal() {
    let total = carrito.reduce((totalAcumulado, item) => totalAcumulado + item.total, 0);
    $('#total').text(`Total: ${separarMiles(total)}`);
    return total;
}

function separarMiles(numero) {
    numero = Number(numero); // convierte a número (acepta enteros y decimales)
    return new Intl.NumberFormat("es-CO").format(numero);
}

function realizarPedido() {
    if (carrito.length === 0) {
        alert("El carrito está vacío. Por favor, agregue productos antes de realizar el pedido.");
        return;
    }

    let clienteId = $('#cliente-select').val();
    if (!clienteId) {
        alert("Por favor, seleccione un cliente.");
        return;
    }

    let pedidoData = {
        cliente: clienteId,
        productos: carrito,
        totalVenta: calcularTotal(),
        accion: 'realizarPedido'
    };

    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'POST',
        data: pedidoData,
        
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === "success") {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: response.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                });          
                limpiar();     
            }else{
              Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.mensaje,
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error al comunicarse con el servidor.",
            });
        }
    });   
}

function limpiar() {
    $('#cliente-select').val(null).trigger('change');
    $('#carrito-table tbody').empty();
    $('#total').text('Total: 0');
    carrito = [];
}

function registrarUsuario() {
    
    if ($('#nombre').val() === '' || $('#telefono').val() === '' || $('#direccion').val() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, complete todos los campos.'
            });
            return;
    }

    let data = {
        'nombre': $('#nombre').val(),
        'telefono': $('#telefono').val(),
        'direccion': $('#direccion').val()
    }

    $.ajax({
        url: 'ajax/registroClientesAjax.php',
        type: 'POST',
        data: data,
        success: function(response) {
            response = JSON.parse(response);
            if (response.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Cliente registrado',
                    text: response.message
                });
                $('#staticBackdrop').modal('hide');
                $('#formRegistrarUsuario')[0].reset();
                listadoClientes();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        }
    })
    
}


initPedidos();
