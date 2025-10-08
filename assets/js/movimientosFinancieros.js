function initMovimientos() {
    obtenerListadoMovimientos();
    totales();
}

function obtenerListadoMovimientos() {
    $.ajax({
        url: 'ajax/movimientosFinancierosAjax.php',
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            console.log(response);
            
            cargarTable(response.data);
            
        }
    });
}

function cargarTable(data) {
    $("#tablaMovimientosFinancieros").DataTable({
        destroy: true,
        responsive: true,
        data: data,
        columns: [
            {data: "fecha"},
            {data: "tipo", render: function(data, type, row) {
                if (data === 'Ingresos') {
                    return '<span class="badge bg-success">Ingreso</span>';
                } else if (data === 'Egresos') {
                    return '<span class="badge bg-danger">Egreso</span>';
                } else {
                    return data;
                }
            }},
            {data: "monto"},
            {data: "descripcion"},
            {data: "refencia"},
            {data: "usuario"},
            
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

function registrarEgreso() {
    const monto = $("#montoEgreso").val();
    const referencia = $("#referencia").val();
    const descripcion = $("#descripcion").val();

    if (monto === "" || referencia === "" || descripcion === "") {
        Swal.fire({
                    icon: "warning",
                    title: "Advertencia",
                    text: "Por favor complete todos los campos",
                });
        return;
    }

    $.ajax({
        url: 'ajax/movimientosFinancierosAjax.php',
        type: 'POST',
        data: {
            accion: 'registrarEgreso',
            monto: monto,
            referencia: referencia,
            descripcion: descripcion
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Resultado',
                    text: 'Egreso registrado con exito.'
                });
                $("#formEgreso").modal("hide");
                obtenerListadoMovimientos();
                totales();
                $("#formEgreso")[0].reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo registrar el egreso.'
                });
            }
        }
    });
}

function totales() {
    $.ajax({
        url: 'ajax/movimientosFinancierosAjax.php',
        type: 'GET',
        data: {
            accion: 'totales',
        },
        success: function(response) {
            response = JSON.parse(response);
            $("#ingresos").text(`$${response.data[0].total_ingresos}`);
            $("#egresos").text(`$${response.data[0].total_egresos}`);
            $("#diferencia").text(`$${response.data[0].total_diferencia}`);
        }
    });
}

initMovimientos();