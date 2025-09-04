var usuarioIdActualizar = 0;

function initClientes() {
    listadoClientes();
}

function listadoClientes() {
    $.ajax({
        url: 'ajax/clientesAjax.php',
        type: 'GET',
        success: function(response){
            response = JSON.parse(response);
            cargarTablaClientes(response.data);
            
        }
    });
}

function cargarTablaClientes(data) {
    $("#tabla-clientes").DataTable({
        destroy: true,
        responsive: true,
        data: data,
        columns: [
            {data: "id_usuario"},
            {data: "nombre_usuario"},
            {data: "telefono_usuario"},
            {data: "direccion_usuario"},
            {data: "estado", className: "text-center", render: function(data, type, row){
                if ( data == 1) {
                    return `<span class="badge bg-success">Activo</span>`;
                } else {
                    return `<span class="badge bg-danger">Inactivo</span>`;
                }
            },},
            {
                data: "estado",
                className: "text-center",
                render: function(data, type, row){
                    if ( data != 0) {/* data != 'Entregado' && */
                        return `
                            <button class="btn btn-danger btn-sm btnAccionListadoPedidos" onclick="inactivarUsuario(${row.id_usuario})"> <i class="fa-solid fa-xmark"></i> </button>
                            <button class="btn btn-success btn-sm btnAccionListadoPedidos" onclick="modalUsuario(${row.id_usuario}, '${row.nombre_usuario}', '${row.telefono_usuario}', '${row.direccion_usuario}')"> <i class="fa-solid fa-pencil"></i> </button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-primary btn-sm btnAccionListadoPedidos" onclick="activarUsuario(${row.id_usuario})"> <i class="fa-solid fa-check"></i> </button>
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

function modalUsuario(idUsuario, nombre, telefono, direccion) {
    console.log(nombre, telefono, direccion);

    usuarioIdActualizar = idUsuario;
    $('#nombre').val(nombre);
    $('#telefono').val(telefono);
    $('#direccion').val(direccion);
    $("#modalUsuario").modal("show");
}

function actualizarCliente() {
    let nombre = $('#nombre').val();
    let telefono = $('#telefono').val();
    let direccion = $('#direccion').val();

    if (nombre === '' || telefono === '' || direccion === '') {
        Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, complete todos los campos.'
            });
        return;
    }else{
        let data = {
            'id_usuario': usuarioIdActualizar,
            'nombre': nombre,
            'telefono': telefono,
            'direccion': direccion
        }

        $.ajax({
            url: 'ajax/actualizarClienteAjax.php',
            type: 'POST',
            data: {data: data},
            success: function(response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente actualizado',
                        text: response.message
                    });
                    $('#modalUsuario').modal('hide');
                    listadoClientes();
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
}

initClientes();