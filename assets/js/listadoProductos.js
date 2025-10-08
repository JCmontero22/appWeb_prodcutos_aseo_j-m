function initProductos() {
    listadoProductos();
}


function listadoProductos() {
    $.ajax({
        url: 'ajax/listadoProductosAjax.php',
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            cargarTable(response.data);
        }
    });
}

function cargarTable(data) {
    $("#tablaProductos").DataTable({
            destroy: true,
            responsive: true,
            data: data,
            columns: [
                /* {data: "id"}, */
                {data: "nombre"},
                {data: "presentacion"},
                {data: "cantidad"},
                {data: "precio",
                    className: "text-center",
                    render: function(data, type, row) {
                        return `<span class="badge bg-success">$${separarMiles(data)}</span>`;
                    }
                },
               /*  {data: null,
                    className: "text-center",
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm" onclick="modalInfo(${row.idPresentacion})"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            
                        `;
                    }
                } */
            ],
            /* order: [[0, "asc"]], */
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


function separarMiles(numero) {
    numero = Number(numero);
    return numero.toLocaleString("es-CO"); // formato Colombia
}

initProductos();