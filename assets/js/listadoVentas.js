
var idEditarEstado = 0;
var productosListados = [];
var carrito = [];
var idPedidoSeleccionado = 0;

function initListadoVentas() {
    listadoVentas();
}

function listadoVentas(admin = 2) {
    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'GET',
        data: {
            accion: 'listadoVentas',
            admin: admin
        },
        success: function(response) {
            response = JSON.parse(response);
            if (admin == 1) {
                cargarTablaVentasAdmin(response.data);
            }else{
                cargarTable(response.data, rol);
            }
        }
    });
}

function cargarTable(data, rol) {
    
    const tabla = $("#tabla_pedidos").DataTable({
        destroy: true,
        responsive: true,
        data: data,
        columns: [
            {data: "idPedido"},
            {data: "cliente"},
            {data: "telefono"},
            {data: "direccion"},
            {data: "totalVenta",
                className: "text-center",
                render: function(data, type, row) {
                    return '$' + separarMiles(data);
                }
            },
            {data: "totalGanancia",
                className: "text-center",
                render: function(data, type, row) {
                    return '$' + separarMiles(data);
                }
            },
            {data: "fechaPedido"},
            {data: "vendedor"},

          
            /* {data: "fechaEntrega", render: function(data, type, row) {
                if (!data || data === '') {
                    return '<span>No Entregado</span>';
                }
                return data;
            }}, */
            {data: "estado", className: "text-center", render: function(data, type, row) {
                if (data === 'Creado') {
                    return '<span class="bg-secondary text-white p-2 estados">Creado</span>';
                } else if (data === 'Confirmado') {
                    return '<span class="bg-info p-2 estados">Confirmado</span>';
                } else if (data === 'Alistado') {
                    return '<span class="bg-warning p-2 estados">Alistado</span>';
                } else if (data === 'Entregado') {
                    return '<span class="bg-success text-white p-2 estados">Entregado</span>';
                } else if (data === 'Cancelado') {
                    return '<span class="bg-danger p-2 estados">Cancelado</span>';
                } else if (data === 'Finalizado') {
                    return '<span class="bg-dark text-white p-2 estados">Finalizado</span>';
                }
                
            }},
            {
                data: "estado",
                className: "text-center",
                render: function(data, type, row){
                    if ( data != 'Finalizado' && data !='Cancelado') {/* data != 'Entregado' && */
                        return `
                            <button class="btn btn-primary btn-sm btnAccionListadoPedidos" onclick="detallePedido(${row.idPedido})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            <button class="btn btn-success btn-sm btnAccionListadoPedidos" onclick="modalEditarEstado(${row.idPedido}, ${row.idEstado})"> <i class="fa-solid fa-pencil"></i> </button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-primary btn-sm btnAccionListadoPedidos" onclick="detallePedido(${row.idPedido})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        `;
                    }
                }
            }
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

    if (rol != 1) {
        tabla.column(7).visible(false); // columna 7 = vendedor
    }
}

function cargarTablaVentasAdmin(data) {
    
    $("#tabla_ventas_admin").DataTable({
        destroy: true,
        responsive: true,
        data: data,
        columns: [
            {data: "idPedido"},
            {data: "cliente"},
            {data: "telefono"},
            {data: "direccion"},
            {data: "totalVenta",
                className: "text-center",
                render: function(data, type, row) {
                    return '$' + separarMiles(data);
                }
            },
            {data: "gananciaAdmin",
                className: "text-center",
                render: function(data, type, row) {
                    return '$' + separarMiles(data);
                }
            },
            {data: "fechaPedido"},
            
            {data: "estado", className: "text-center", render: function(data, type, row) {
                if (data === 'Creado') {
                    return '<span class="bg-secondary text-white p-2 estados">Creado</span>';
                } else if (data === 'Confirmado') {
                    return '<span class="bg-info p-2 estados">Confirmado</span>';
                } else if (data === 'Alistado') {
                    return '<span class="bg-warning p-2 estados">Alistado</span>';
                } else if (data === 'Entregado') {
                    return '<span class="bg-success text-white p-2 estados">Entregado</span>';
                } else if (data === 'Cancelado') {
                    return '<span class="bg-danger p-2 estados">Cancelado</span>';
                } else if (data === 'Finalizado') {
                    return '<span class="bg-dark text-white p-2 estados">Finalizado</span>';
                }
                
            }},
            {
                data: "estado",
                className: "text-center",
                render: function(data, type, row){
                    if ( data != 'Finalizado') {/* data != 'Entregado' && */
                        return `
                            <button class="btn btn-primary btn-sm btnAccionListadoPedidos" onclick="detallePedido(${row.idPedido})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            <button class="btn btn-success btn-sm btnAccionListadoPedidos" onclick="modalEditarEstado(${row.idPedido}, ${row.idEstado})"> <i class="fa-solid fa-pencil"></i> </button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-primary btn-sm btnAccionListadoPedidos" onclick="detallePedido(${row.idPedido})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        `;
                    }
                }
            }
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

function detallePedido(idPedido) {
    idPedidoSeleccionado = idPedido;
    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'GET',
        data: {
            accion: 'detallePedido',
            idPedido: idPedido
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status == 'success') {
                mostrarDetallesPedido(response.data, idPedido);
            } else {
                alert("Error al obtener detalles del pedido.");
            }
        }
    });
}

function mostrarDetallesPedido(data, idPedido) {
    cargarProductosListado();

    $("#modalDetalle").modal('show');
    $("#detallePedidoBody").empty(); 

    data.forEach(item => {
        const rowId = `detalle-row-${item.idPresentacion}`;
        const cantidadId = `td-cantidad-${item.idPresentacion}`;
        let botones = '';

        if (item.estado != 1) {
            $("#btnAgregarProducto").hide();
        }

        // Si item.estado != 6, mostrar botones
        if (item.estado != 6) {
            botones = `
                <button class="btn btn-warning btn-sm btn-editar-cantidad" onclick="editarCantidad(${item.idPresentacion}, ${idPedido}, ${item.cantidad}, ${item.idDetallePedido}, ${item.precioVenta})"> <i class="fa-solid fa-pencil"></i> </button>
                <button class="btn btn-danger btn-sm btn-eliminar-producto" onclick="eliminarProducto(${item.idDetallePedido} , ${idPedido})" style="margin-top: 5px;"> <i class="fa-solid fa-trash"></i> </button>
            `;
        }
        $("#detallePedidoBody").append(`
            <tr id="${rowId}">
                <td>${item.nombreProducto}</td>
                <td>${item.presentacion}</td>
                <td id="${cantidadId}">${item.cantidad}</td>
                <td>${separarMiles(item.subtotal)}</td>
                <td class="text-center" id="td-btns-${item.idPresentacion}">
                    ${botones}
                </td>
            </tr>
        `);
    });
}

function editarCantidad(idPresentacion, idPedido, cantidadActual, idDetallePedido, precioVenta) {
    const inputHtml = `<input type='number' min='1' class='form-control form-control-sm' id='input-cantidad-edit-${idPresentacion}' value='${cantidadActual}' style='width:80px;display:inline-block;'>`;

    $(`#td-cantidad-${idPresentacion}`).html(inputHtml);

    // Ocultar botones editar y eliminar
    $(`#td-btns-${idPresentacion}`).html(`
        <button class="btn btn-success btn-sm btn-confirmar-cantidad"  onclick="confirmarEdicionCantidad(${idPresentacion}, ${idPedido}, ${idDetallePedido}, ${precioVenta})"> <i class="fa-solid fa-check"></i> </button>

        <button class="btn btn-danger btn-sm btn-cancelar-cantidad" onclick="cancelarEdicionCantidad(${idPresentacion}, ${idPedido}, ${idDetallePedido})"> <i class="fa-solid fa-xmark"></i> </button>
    `);
}

function cancelarEdicionCantidad(idPresentacion, idPedido, idDetallePedido) {
    detallePedido(idPedido);
}

function confirmarEdicionCantidad(idPresentacion, idPedido, idDetallePedido, precioVenta) {
    const nuevaCantidad = $(`#input-cantidad-edit-${idPresentacion}`).val();

    if (nuevaCantidad <= 0) {
        Swal.fire({ icon: 'error', title: 'Cantidad inválida', text: 'La cantidad debe ser mayor a 0.' });
        return;
    }

    // Llamada AJAX para actualizar cantidad
    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'POST',
        data: {
            accion: 'actualizarPedido',
            idDetallePedido: idDetallePedido,
            cantidad: nuevaCantidad,
            idPedido: idPedido,
            precioVenta: precioVenta
        },
        success: function(response) {
            response = JSON.parse(response);

            if (response.status == 'success') {
                Swal.fire({ icon: 'success', title: 'Actualizado', text: 'Cantidad actualizada correctamente.' });
                listadoVentas();
                detallePedido(idPedido); // idPedido debe venir en la respuesta
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'No se pudo actualizar la cantidad.' });
            }
        }
    });
}

function modalEditarEstado(idPedido, idEstado) {
    console.log(idEstado);
    // Reiniciar el select al valor vacío
    $("#estado").val('');
    if (idEstado === 4) {
        $("#estado-2").hide();
        $("#estado-3").hide();
        $("#estado-5").hide();
        $("#estado-4").hide();
        $("#estado-6").show();
    } else {
        $("#estado-2").show();
        $("#estado-3").show();
        $("#estado-5").show();
        $("#estado-4").show();
        $("#estado-6").hide();
    }

    $("#modalEditarEstado").modal('show');
    idEditarEstado = idPedido;
}

function actualizarEstado() {
    if ($("#estado").val() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debe seleccionar un estado para el pedido.'
        });
        return;
    }

    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'POST',
        data: {
            accion: 'actualizarEstado',
            idPedido: idEditarEstado,
            estado: $("#estado").val()
        },
        success: function(response) {
            response = JSON.parse(response);

            if (response.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: 'El estado del pedido ha sido actualizado.'
                });
                $("#modalEditarEstado").modal('hide');
                listadoVentas();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el estado del pedido.'
                });
            }
        }
    });
}

function eliminarProducto(idDetallePedido, idPedido) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás recuperar este producto eliminado.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'ajax/pedidosAjax.php',
                type: 'POST',
                data: {
                    accion: 'eliminarProducto',
                    idDetallePedido: idDetallePedido,
                    idPedido: idPedido
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'El producto ha sido eliminado.',
                            'success'
                        );
                        listadoVentas();
                        detallePedido(idPedido);
                    } else {
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar el producto.',
                            'error'
                        );
                    }
                }
            });
        }
    });
}

function realizarCalculo() {
    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'POST',
        data: {
            accion: 'calculoVentas'
        },
        success: function(response) {
            response = JSON.parse(response);
            
            if (response.status == 'success') {
                if (response.data[0].enviar != null) {
                    $('#modalCalculo').modal('show');
                    $('#valorEnviar').text(separarMiles(parseInt(response.data[0].enviar)));
                    $('#valorGanancias').text(separarMiles(parseInt(response.data[0].ganancia)));                    
                }else{
                    Swal.fire({
                    icon: 'warning',
                    title: 'No hay datos',
                    text: 'No hay pedidos entregados para calcular.'
                });    
                }
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.mensaje
                });
            }
        }
    });
}

function finalizarPedidos() {
    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'POST',
        data: {
            accion: 'finalizarPedidos'
        },
        success: function(response) {
            response = JSON.parse(response);

            if (response.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Finalizado',
                    text: 'Los pedidos han sido finalizados.'
                });
                listadoVentas();
                $('#modalCalculo').modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        }
    });
}

function cargarProductosListado() {
    $.ajax({
        url: 'ajax/listadoProductosAjax.php',
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            productosListados = response.data;
            let options = '<option value="">Seleccione un producto</option>';
            productosListados.forEach(item => {
                options += `<option value="${item.idPresentacion}">${item.nombre} - ${item.presentacion} - ${separarMiles(item.precio)}</option>`;
            });
            $('#producto-select').html(options);
        }
    });
}

function agregarProducto() {
    
    // Evitar múltiples filas de edición
    if ($('#fila-nueva-producto').length > 0) return;

    // Generar opciones del select
    let options = '<option value="">Seleccione un producto</option>';
    productosListados.forEach(item => {
        options += `<option value="${item.idPresentacion}">${item.nombre} - ${item.presentacion} - ${separarMiles(item.precio)}</option>`;
    });

    let nuevaFila = `
        <tr id="fila-nueva-producto">
            <td colspan="2">
                <select id="nuevo-producto-select" class="form-select">${options}</select>
            </td>
            <td>
                <input type="number" min="1" id="nuevo-cantidad" class="form-control" style="width:90px;display:inline-block;">
            </td>
            <td></td>
            <td>
                <button class="btn btn-success btn-sm" onclick="confirmarAgregarProducto()">✔</button>
                <button class="btn btn-danger btn-sm" onclick="$('#fila-nueva-producto').remove()">✖</button>
            </td>
        </tr>
    `;
    $('#detallePedidoBody').append(nuevaFila);
}

function confirmarAgregarProducto() {
    let productoId = $('#nuevo-producto-select').val();
    let cantidad = $('#nuevo-cantidad').val();

    if (productoId && cantidad > 0) {
        let producto = productosListados.find(p => p.idPresentacion == productoId);
        if (producto) {
            let total = producto.precio * cantidad;
            $.ajax({
                url: 'ajax/pedidosAjax.php',
                type: 'POST',
                data: {
                    accion: 'agregarProducto',
                    idPedido: idPedidoSeleccionado,
                    idPresentacion: producto.idPresentacion,
                    cantidad: cantidad,
                    total: total,
                    precioVenta: producto.precio,
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Producto agregado',
                            text: 'El producto ha sido agregado al pedido.'
                        });
                        
                        listadoVentas();
                        detallePedido(idPedidoSeleccionado);
                        
                        

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            });
        }
    } else {
        alert("Seleccione un producto y una cantidad válida.");
    }
}

function separarMiles(numero) {
    numero = Number(numero); // convierte a número (acepta enteros y decimales)
    return new Intl.NumberFormat("es-CO").format(numero);
}


initListadoVentas();