function initVentasFinalizadas() {
    cargarVentasFinalizadas();
}

/**
 * Cargar ventas finalizadas
 */
function cargarVentasFinalizadas() {
    $.ajax({
        url: 'ajax/ventasFinalizadasAjax.php',
        type: 'GET',
        data: { accion: 'obtenerVentas' },
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
    $('#tablaVentasFinalizadas').DataTable({
        destroy: true,
        responsive: true,
        data: data,
        columns: [
            {data: "id_pedido"},
            {data: "nombre_sede"},
            {data: "vendedor"},
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
                data: "costo_total_pedido",
                className: "text-center",
                render: function(data) {
                    return '$' + separarMiles(data);
                }
            },
            {
                data: "totalGanancia",
                className: "text-center",
                render: function(data) {
                    return '$' + separarMiles(data);
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
            }
        }
    });
}

/**
 * Separar miles en números
 */
function separarMiles(numero) {
    numero = Number(numero);
    return numero.toLocaleString("es-CO");
}

initVentasFinalizadas();
