var productosListados = [];
var carrito = [];

function initPedidos() {
    listadoProductos();
    listadoClientes();
}

function listadoProductos() {
    $.ajax({
        url: 'ajax/listadoProductosAjax.php',
        type: 'GET',
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
        $data.push({
            id: item.idPresentacion,
            text: `${item.nombre} - ${item.presentacion} - $${separarMiles(item.precio)}`
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
        theme: "default"
    });
}

function agregarProducto() {
    let productoId = $('#producto-select').val();
    let cantidad = $('#cantidad').val();

    if (productoId && cantidad) {
        let producto = productosListados.find(p => p.idPresentacion == productoId);
        
        if (producto) {
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
    } else {
        alert("Por favor, seleccione un producto y una cantidad.");
    }
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
                <td><button class="btn btn-danger" onclick="eliminarProducto('${item.presentacion}')">X</button></td>
            </tr>
        `;
        tableBody.append(row);
        calcularTotal();
    });
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
