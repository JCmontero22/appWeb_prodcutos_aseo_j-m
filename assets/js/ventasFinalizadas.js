function initVentasFinalizadas() {
    cargarVentasFinalizadas();
}

/**
 * Cargar ventas finalizadas
 */
function cargarVentasFinalizadas() {
    let mes = $('#filtroMes').val() || '';

    $.ajax({
        url: 'ajax/ventasFinalizadasAjax.php',
        type: 'GET',
        data: {
            accion: 'obtenerVentas',
            mes: mes
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                cargarTablaVentas(response.data);
            } else {
                Swal.fire('Error', response.mensaje, 'error');
            }
        },
        error: function(error) {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudieron cargar las ventas finalizadas', 'error');
        }
    });
}

/**
 * Cargar tabla de ventas con DataTable
 */
function cargarTablaVentas(data) {
    $("#tabla_ventas_finalizadas").DataTable({
        destroy: true,
        responsive: true,
        data: data,
        pageLength: 25,
        columns: [
            {data: "id_pedidos"},
            {data: "nombre_sede"},
            {data: "vendedor"},
            {
                data: "nombre_rol",
                className: "text-center",
                render: function(data) {
                    let rol = data || 'Sin rol';
                    let badgeClass = rol.toLowerCase().includes('admin') ? 'bg-info text-dark' : 'bg-secondary text-white';
                    return `<span class="badge ${badgeClass} p-2">${rol}</span>`;
                }
            },
            {data: "fecha_pedido"},
            {
                data: "id_estado",
                className: "text-center",
                render: function(data) {
                    const estadoMap = {
                        6: 'Finalizado',
                        7: 'Pagado'
                    };
                    let nombreEstado = estadoMap[data] || 'Desconocido';
                    const clasesEstado = {
                        'Pagado': 'bg-primary text-white',
                        'Finalizado': 'bg-dark text-white'
                    };
                    let clase = clasesEstado[nombreEstado] || 'bg-light text-dark';
                    return `<span class="${clase} p-2 estados">${nombreEstado}</span>`;
                }
            },
            {
                data: "fecha_actualizacion",
                className: "text-center"
            },
            {
                data: "costo_total_pedido",
                className: "text-center",
                render: function(data) {
                    return '$' + separarMiles(data);
                }
            },
            {
                data: "ganancia_total_pedido",
                className: "text-center",
                render: function(data) {
                    let ganancia = parseFloat(data) || 0;
                    return '$' + separarMiles(ganancia);
                }
            },
            {
                data: "separado",
                className: "text-center",
                render: function(data, type, row) {
                    let checked = parseInt(data) === 1 ? 'checked' : '';
                    return `<input type="checkbox" class="check-separado" data-id="${row.id_pedidos}" ${checked}>`;
                }
            }
        ],
        createdRow: function(row, data) {
            try {
                if (parseInt(data.separado) === 1) {
                    $(row).css('background-color', '#e9f7ef');
                }
            } catch (e) {
                // ignore
            }
        },
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
            }
        }
    });

    // Manejar change en el checkbox para marcar/desmarcar separado
    $('#tabla_ventas_finalizadas').off('change', '.check-separado').on('change', '.check-separado', function() {
        let checkbox = $(this);
        let idPedido = checkbox.data('id');
        let valor = checkbox.is(':checked') ? 1 : 0;

        // Si se está desmarcando, pedir confirmación al usuario
        if (valor === 0) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Confirma que deseas desmarcar este pedido como separado.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, desmarcar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceder con la petición AJAX para desmarcar
                    enviarActualizacionSeparado(idPedido, valor, checkbox);
                } else {
                    // Revertir el checkbox (dejarlo marcado)
                    checkbox.prop('checked', true);
                }
            });
        } else {
            // Si se está marcando, no hace falta confirmación
            enviarActualizacionSeparado(idPedido, valor, checkbox);
        }
    });

    /**
     * Función auxiliar para enviar la actualización via AJAX
     */
    function enviarActualizacionSeparado(idPedido, valor, checkbox) {
        $.ajax({
            url: 'ajax/ventasFinalizadasAjax.php',
            type: 'POST',
            data: {
                accion: 'marcarSeparado',
                id_pedidos: idPedido,
                valor: valor
            },
            success: function(response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    // response might already be an object
                }

                if (response.status === 'success') {
                    let tr = checkbox.closest('tr');
                    if (valor === 1) {
                        tr.css('background-color', '#e9f7ef');
                    } else {
                        tr.css('background-color', '');
                    }
                    Swal.fire({icon: 'success', title: 'Actualizado', text: response.mensaje, timer: 900, showConfirmButton: false});
                } else {
                    // Revertir el estado del checkbox si hubo error
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    Swal.fire('Error', response.mensaje || 'No se pudo actualizar', 'error');
                }
            },
            error: function(err) {
                checkbox.prop('checked', !checkbox.is(':checked'));
                Swal.fire('Error', 'No se pudo actualizar el estado', 'error');
            }
        });
    }
}

/**
 * Separar miles en números
 */
function separarMiles(numero) {
    numero = Number(numero);
    return numero.toLocaleString("es-CO");
}

initVentasFinalizadas();
