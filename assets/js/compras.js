let productos;
let carrito = [];
function init() {
    listadoCompras();
}

function cargarDatos() {
    listadoProductos();
    listadoSedes();
    metodosPago();
}

function listadoCompras() {
    $.ajax({
        url: 'ajax/comprasAjax.php',
        type: 'GET',
        data: { accion: 'listadoCompras' },
        success: function(response) {
            response = JSON.parse(response);
            cargarTablaCompras(response.data);
        }
    });
}

function cargarTablaCompras(data) {

    $("#tabla_compras").DataTable({
        destroy: true,
        responsive: true,
        data: data,
        columns: [
            {data: "id"},
            {data: "proveedor"},
            {data: "fecha_compra"},
            {data: "numero_factura"},
            {data: "total_factura"},
            {data: "tipo_pago"},
            {data: "sedes"},
            {data: "observacion"},
            {
                data: "estado",
                className: "text-center",
                render: function(data, type, row){
                    if ( data != '1') {/* data != 'Entregado' && */
                        return `
                            <button class="btn btn-primary btn-sm btnAccionListadoPedidos" data-bs-toggle="modal" data-bs-target="#modalDetalle" onclick="detalleCompraVer(${row.id})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            <button class="btn btn-success btn-sm btnAccionListadoPedidos" onclick="modalEditarEstado(${row.id}, ${row.idEstado})"> <i class="fa-solid fa-pencil"></i> </button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-primary btn-sm btnAccionListadoPedidos" data-bs-toggle="modal" data-bs-target="#modalDetalle" onclick="detalleCompraVer(${row.id})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            <button class="btn btn-warning btn-sm btnAccionListadoPedidos" data-bs-toggle="modal" data-bs-target="#formCompra" onclick="cargarFormEditar(${row.id})"> <i class="fa-solid fa-pencil"></i> </button>
                        `;
                    }
                }
            },
        ],
        order: [[0, "desc"]],
        language: {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "loadingRecords": "Cargando...",
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
}

function detalleCompraVer(idCompra) {
    $.ajax({
        url: 'ajax/comprasAjax.php',
        type: 'GET',
        data: { accion: 'detalleCompra', idCompra: idCompra },
        success: function(response) {
            response = JSON.parse(response);
            let detalles = '';
            response.data.forEach(detalle => {
                detalles += `
                    <tr>
                        <td>${detalle.nombre_produto}</td>
                        <td>${detalle.tamano_presentacion}</td>
                        <td>${detalle.cantidad}</td>
                        <td>$${separarMiles(detalle.precio_costo_unitario)}</td>
                        <td>$${separarMiles(detalle.subtotal)}</td>
                    </tr>
                `;
            });
            $('#detalleCompraModalBody').html(detalles);
        }
    });
}

function listadoProductos(sedeId = 0) {
    $.ajax({
        url: 'ajax/listadoProductosAjax.php',
        method: 'GET',
        data: { sedeId: sedeId },
        success: function(response) {
            response = JSON.parse(response);
            productos = response.data; // Guardar los productos en la variable global
            $data = dataSelectProductos(response.data);
            selectProductos($data);
            $('#idProducto').val('').trigger('change');
        },
        error: function(error) {
            console.error('Error al cargar los productos:', error);
        }
    });
}

function listadoSedes() {
    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'GET',
        data: { accion: 'listadoSedes' },
        success: function(response) {
            response = JSON.parse(response);
            let sedes = '<option value="">Seleccione una sede</option>';
            response.data.forEach(sede => {
                sedes += `<option value="${sede.id_sede}">${sede.nombre_sede}</option>`;
            });
            $('#idSede').html(sedes);
        }
    });
}

function dataSelectProductos(params) {
    $data = [];
    params.forEach(item => {
        $data.push({
            id: item.idPresentacion,
            text: `${item.nombre} - ${item.presentacion}`
        });
    });
    return $data;
}

function selectProductos(data) {
    $('#idProducto').select2({
        data: data,
        placeholder: "Seleccione una opción",
        allowClear: true,
        theme: "default",
        zindex: 20001,
        dropdownParent: $('#formCompra'), // <-- agrega esto
        width: '100%'
    });
}

function metodosPago() {
    $.ajax({
        url: 'ajax/metodosPagoAjax.php',
        type: 'GET',
        data: { accion: 'metodosPago' },
        success: function(response) {
            response = JSON.parse(response);
            let metodos = '<option value="">Seleccione un método de pago</option>';
            response.data.forEach(metodo => {
                metodos += `<option value="${metodo.id_tipo_de_pago}">${metodo.nombre_tipo_de_pago}</option>`;
            });
            $('#tipoPago').html(metodos);
        }
    });
}

function agregarDetalleCompra() {
    const idProducto = document.getElementById('idProducto').value;
    const cantidad = document.getElementById('cantidad').value;
    const precio = document.getElementById('precio').value;

    if (idProducto && cantidad && precio) {
        let iodProducto = productos.find(p => p.idPresentacion == idProducto);
        if (iodProducto) {
            nombreProducto = iodProducto.nombre + ' - ' + iodProducto.presentacion;
            let subtotal = precio * cantidad;
            let precioCompra = parseFloat(precio);
            let valorVentaJM = calcularYRedondear(precioCompra, 20)
            let valorCliente = calcularYRedondear(valorVentaJM, 20);
            carrito.push({
                idProducto,
                nombre: nombreProducto,
                precio,
                cantidad,
                subtotal,
                valorVentaJM,
                valorCliente
            });

            cargarDetalleCompraTable();
            $('#idProducto').val('').trigger('change');
            $('#cantidad').val('');
            $('#precio').val('');
        } else {
            alert('Producto no encontrado.');
        }
    } else {
        alert('Por favor, complete todos los campos del detalle de compra.');
    }
}

// Variable para saber si estamos editando
let modoEdicionCompra = false;

function cargarFormEditar(idCompra) {
    limpiarFormularioCompra();
    mostrarBotonesEditar();
    $('#formCompra').data('idCompra', idCompra);
    modoEdicionCompra = true;
    cargarDatos();

    setTimeout(() => {
        $.ajax({
            url: 'ajax/comprasAjax.php',
            type: 'GET',
            data: { accion: 'obtenerCompra', idCompra: idCompra },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    const compra = response.data[0];
                    $('#proveedor').val(compra.proveedor);
                    $('#numFactura').val(compra.numero_factura);
                    $('#idSede').val(compra.id_sede).trigger('change');
                    $('#tipoPago').val(compra.id_tipo_de_pago).trigger('change');
                    $('#descripcion').val(compra.observacion);

                    carrito = [];
                    response.data.forEach(detalle => {
                        carrito.push({
                            idDetalleCompra: detalle.id_detalle_compra || null, // <-- importante
                            idProducto: detalle.id_presentacion,
                            nombre: detalle.nombre_produto + ' - ' + detalle.tamano_presentacion,
                            precio: detalle.precio_costo_unitario,
                            cantidad: detalle.cantidad,
                            subtotal: detalle.subtotal,
                            valorVentaJM: detalle.precio_venta_jm_presentacion,
                            valorCliente: detalle.precio_venta_cliente_presentacion
                        });
                    });
                    cargarDetalleCompraTable();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.mensaje,
                    });
                }
            },
            error: function(error) {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al comunicarse con el servidor. Por favor, inténtelo de nuevo.');
            }
        });
    }, 1000);
}

function cargarDetalleCompraTable() {
    let tableBody = $('#detalleCompraBody');
    tableBody.empty();
    carrito.forEach((item, idx) => {
        let row = '';
        if (modoEdicionCompra) {
            row = `
                <tr>
                    <td>${item.nombre}</td>
                    <td><input type="number" class="form-control form-control-sm inputPrecio" value="${item.precio}" data-idx="${idx}" min="0"></td>
                    <td><input type="number" class="form-control form-control-sm inputCantidad" value="${item.cantidad}" data-idx="${idx}" min="1"></td>
                    <td class="text-center"><span class="spanSubtotal">$${separarMiles(item.precio * item.cantidad)}</span></td>
                    <td class="text-center"><span class="spanValorJM">$${separarMiles(calcularYRedondear(item.precio, 20))}</span></td>
                    <td class="text-center"><span class="spanValorCliente">$${separarMiles(calcularYRedondear(calcularYRedondear(item.precio, 20), 20))}</span></td>
                    <td class="text-center"><button class="btn btn-danger btn-sm" onclick="eliminarDetalleCompra('${item.idProducto}')">X</button></td>
                </tr>
            `;
        } else {
            row = `
                <tr>
                    <td>${item.nombre}</td>
                    <td>$${separarMiles(item.precio)}</td>
                    <td>${item.cantidad}</td>
                    <td>$${separarMiles(item.subtotal)}</td>
                    <td>$${separarMiles(item.valorVentaJM)}</td>
                    <td>$${separarMiles(item.valorCliente)}</td>
                    <td class="text-center"><button class="btn btn-danger" onclick="eliminarDetalleCompra('${item.idProducto}')">X</button></td>
                </tr>
            `;
        }
        tableBody.append(row);
    });
    calcularTotal();

    // Solo en modo edición: listeners para inputs
    if (modoEdicionCompra) {
        tableBody.find('.inputPrecio, .inputCantidad').on('input', function() {
            const idx = $(this).data('idx');
            const precio = parseFloat(tableBody.find(`.inputPrecio[data-idx="${idx}"]`).val()) || 0;
            const cantidad = parseFloat(tableBody.find(`.inputCantidad[data-idx="${idx}"]`).val()) || 1;
            carrito[idx].precio = precio;
            carrito[idx].cantidad = cantidad;
            carrito[idx].subtotal = precio * cantidad;
            carrito[idx].valorVentaJM = calcularYRedondear(precio, 20);
            carrito[idx].valorCliente = calcularYRedondear(carrito[idx].valorVentaJM, 20);
            // Actualizar celdas
            const fila = $(this).closest('tr');
            fila.find('.spanSubtotal').text('$' + separarMiles(carrito[idx].subtotal));
            fila.find('.spanValorJM').text('$' + separarMiles(carrito[idx].valorVentaJM));
            fila.find('.spanValorCliente').text('$' + separarMiles(carrito[idx].valorCliente));
            calcularTotal();
        });
    }
}

function calcularTotal() {
    let total = carrito.reduce((totalAcumulado, item) => totalAcumulado + item.subtotal, 0);
    totalFinal = (total != '') ? total : 0;
    $('#totalCompra').text(`Total: ${separarMiles(totalFinal)}`);
    return total;
}

function calcularYRedondear(costo, porcentajeMargen) {
    let factor = 1 + (porcentajeMargen / 100);
    let precioBruto = costo * factor;
    // Math.ceil asegura que siempre suba (ej. 2100 sube a 2500, protegiendo la ganancia)
    return Math.ceil(precioBruto / 500) * 500;
}

function registrarCompra() {
    if (carrito.length === 0) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: 'El carrito de compra está vacío. Agregue productos antes de registrar la compra.',
        });
        return;
    }

    let proveedor = $('#proveedor').val();
    let numFactura = $('#numFactura').val();
    let idSede = $('#idSede').val();
    let tipoPago = $('#tipoPago').val();
    let descripcion = $('#descripcion').val();
    let total = calcularTotal();
    let detalles = carrito.map(item => ({
        idProducto: item.idProducto,
        cantidad: item.cantidad,
        precioCompra: item.precio,
        subtotal: item.subtotal,
    }));

    if (!proveedor && !numFactura && !idSede && !tipoPago) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: 'Por favor, complete todos los campos del formulario de compra.',
        });
    }

    $.ajax({
        url: 'ajax/comprasAjax.php',
        type: 'POST',
        data: {
            proveedor,
            numFactura,
            idSede,
            tipoPago,
            descripcion,
            total,
            detalles,
            accion: 'registrarCompra'
        },
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
                limpiarFormularioCompra();
                listadoCompras();
                $('#cerrarModalRegistro').click();
            }else{
              Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.mensaje,
                });
            }
        },
        error: function(error) {
            console.error('Error en la solicitud AJAX:', error);
            alert('Error al comunicarse con el servidor. Por favor, inténtelo de nuevo.');
        }
    });
}

function separarMiles(numero) {
    numero = Number(numero); // convierte a número (acepta enteros y decimales)
    return new Intl.NumberFormat("es-CO").format(numero);
}

function eliminarDetalleCompra(idProducto) {
    carrito = carrito.filter(item => item.idProducto !== idProducto);
    cargarDetalleCompraTable();
}

function limpiarFormularioCompra() {
    $('#proveedor').val('');
    $('#numFactura').val('');
    $('#idSede').val('').trigger('change');
    $('#tipoPago').val('').trigger('change');
    $('#descripcion').val('');
    $('#idProducto').val('').trigger('change');
    $('#cantidad').val('');
    $('#precio').val('');
    carrito = [];
    cargarDetalleCompraTable();
    $('#btnRegistrarCompra').show();
    $('#btnGuardarCambios').hide();
    modoEdicionCompra = false;
}

function mostrarBotonesEditar() {
    $('#btnRegistrarCompra').hide();
    $('#btnGuardarCambios').show();
}

function guardarCambiosCompra() {
    let detalles = [];
    let totalCompra = 0;
    // Tomar los productos del carrito
    carrito.forEach(item => {
        let precio = parseFloat(item.precio) || 0;
        let cantidad = parseFloat(item.cantidad) || 0;
        let subtotal = precio * cantidad;
        totalCompra += subtotal;
        detalles.push({
            id_detalle_compra: item.idDetalleCompra || null, // <-- importante
            id_presentacion: item.idProducto,
            precio_costo_unitario: precio,
            cantidad: cantidad,
            subtotal: subtotal
        });
    });
    if (detalles.length === 0) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: 'No hay detalles para guardar.',
        });
        return;
    }
    let dataCompra = {
        idCompra: $('#formCompra').data('idCompra'),
        proveedor: $('#proveedor').val(),
        numFactura: $('#numFactura').val(),
        idSede: $('#idSede').val(),
        tipoPago: $('#tipoPago').val(),
        descripcion: $('#descripcion').val(),
        total: totalCompra,
        detalles: detalles
    };
    $.ajax({
        url: 'ajax/comprasAjax.php',
        type: 'POST',
        data: {
            accion: 'actualizarDetallesCompra',
            dataCompra: JSON.stringify(dataCompra)
        },
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
                limpiarFormularioCompra();
                listadoCompras();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.mensaje,
                });
            }
        },
        error: function(error) {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: 'Error al guardar los cambios.',
            });
        }
    });
}

init();
