var idEditarEstado = 0;

function initListadoPedidos() {
    listadoMisPedidos();
}

function listadoMisPedidos() {
    $.ajax({
        url: 'ajax/pedidosAjax.php',
        type: 'GET',
        data: {
            accion: 'listadoPedidos'
        },
        success: function(response) {
            response = JSON.parse(response);
            cargarTable(response.data);
        }
    });
}

function cargarTable(data) {
    
    $("#tabla_pedidos").DataTable({
            destroy: true,
            responsive: true,
            data: data,
            columns: [
                /* {data: "id"}, */
                {data: "idPedido"},
                {data: "cliente"},
                {data: "totalVenta",
                    className: "text-center",
                    render: function(data, type, row) {
                        return separarMiles(data);
                    }
                },
                
                {data: "totalGanancia",
                    className: "text-center",
                    render: function(data, type, row) {
                        return separarMiles(data);
                    }
                },
                {data: "fechaPedido"},
                {data: "fechaEntrega", render: function(data, type, row) {
                    if (!data || data === '') {
                        return '<span>No Entregado</span>';
                    }
                    return data;
                   
                }},
                {data: "estado", render: function(data, type, row) {
                    if (data === 'Creado') {
                        return '<span class="bg-secondary p-2">Creado</span>';
                    } else if (data === 'Confirmado') {
                        return '<span class="bg-info p-2">Confirmado</span>';
                    } else if (data === 'Alistado') {
                        return '<span class="bg-warning p-2">Alistado</span>';
                    } else if (data === 'Entregado') {
                        return '<span class="bg-success p-2">Entregado</span>';
                    }else if (data === 'Cancelado') {
                        return '<span class="bg-danger p-2">Cancelado</span>';
                    }
                }},
                {data: null,
                    className: "text-center",
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm" onclick="detallePedido(${row.idPedido})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            <button class="btn btn-success btn-sm" onclick="modalEditarEstado(${row.idPedido})"> <i class="fa-solid fa-pencil"></i> </button>
                        `;
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
                mostrarDetallesPedido(response.data);
            } else {
                alert("Error al obtener detalles del pedido.");
            }
        }
    });
}

function mostrarDetallesPedido(data) {
    $("#modalDetalle").modal('show');
    $("#detallePedidoBody").empty(); // Limpiar contenido previo

    // Agregar filas con los detalles del pedido
    data.forEach(item => {
        $("#detallePedidoBody").append(`
            <tr>
                <td>${item.nombreProducto}</td>
                <td>${item.presentacion}</td>
                <td>${item.cantidad}</td>
                <td>${separarMiles(item.subtotal)}</td>
            </tr>
        `);
    });
}

function modalEditarEstado(idPedido) {
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
                initListadoPedidos();
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

function separarMiles(numero) {
  return numero.toLocaleString("es-CO"); // formato Colombia
}

initListadoPedidos();