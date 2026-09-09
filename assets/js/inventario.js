let inventarioActual = [];
let sedeActual = 0;
let productoEditando = {};

function init() {
    cargarSedes();
}

/**
 * Cargar lista de sedes
 */
function cargarSedes() {
    $.ajax({
        url: 'ajax/inventarioAjax.php',
        type: 'GET',
        data: { accion: 'listadoSedes' },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                let html = '<option value="">-- Seleccione una sede --</option>';
                response.data.forEach(sede => {
                    html += `<option value="${sede.id_sede}">${sede.nombre_sede}</option>`;
                });
                $('#sedes').html(html);
            }
        },
        error: function(error) {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudieron cargar las sedes', 'error');
        }
    });
}

/**
 * Cargar inventario de la sede seleccionada
 */
function cargarInventarioPorSede() {
    sedeActual = $('#sedes').val();

    if (!sedeActual) {
        return;
    }

    $.ajax({
        url: 'ajax/inventarioAjax.php',
        type: 'POST',
        data: {
            accion: 'inventarioPorSede',
            idSede: sedeActual
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                inventarioActual = response.data;
                cargarTablaInventario(response.data);
            } else {
                Swal.fire('Error', response.mensaje, 'error');
            }
        },
        error: function(error) {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudo cargar el inventario', 'error');
        }
    });
}

/**
 * Cargar tabla de inventario con DataTable
 */
function cargarTablaInventario(data) {
    $('#tablaInventario').DataTable({
        destroy: true,
        responsive: true,
        data: data,
        columns: [
            {data: "nombre_produto"},
            {data: "tamano_presentacion"},
            {
                data: "cantidad_stock_presentacion_sede",
                className: "text-center"
            },
            {
                data: "precio_compra_presentacion",
                className: "text-center",
                render: function(data) {
                    return '$' + separarMiles(data);
                }
            },
            {
                data: "precio_venta_jm_presentacion",
                className: "text-center",
                render: function(data) {
                    return '$' + separarMiles(data);
                }
            },
            {
                data: "precio_venta_cliente_presentacion",
                className: "text-center",
                render: function(data) {
                    return '$' + separarMiles(data);
                }
            },
            {
                data: null,
                className: "text-center",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<button class="btn btn-primary btn-sm" onclick="abrirModalEditar(${row.id_presentacion}, '${row.nombre_produto} - ${row.tamano_presentacion}', ${row.cantidad_stock_presentacion_sede}, ${row.precio_compra_presentacion})">
                        <i class="fa-solid fa-pencil"></i>
                    </button>`;
                }
            }
        ],
        order: [[0, "asc"]],
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
 * Abrir modal para editar stock
 */
function abrirModalEditar(idPresentacion, nombreProducto, cantidad, costo) {
    productoEditando = {
        idPresentacion: idPresentacion,
        nombreProducto: nombreProducto
    };

    $('#productoNombre').val(nombreProducto);
    $('#cantidad').val(cantidad);
    $('#costoUnitario').val(costo);

    const modal = new bootstrap.Modal(document.getElementById('modalEditarStock'));
    modal.show();
}

/**
 * Guardar cambios de stock
 */
function guardarCambiosStock() {
    const cantidad = $('#cantidad').val();
    const costoUnitario = $('#costoUnitario').val();

    if (!cantidad || !costoUnitario) {
        Swal.fire('Error', 'Complete todos los campos', 'error');
        return;
    }

    $.ajax({
        url: 'ajax/inventarioAjax.php',
        type: 'POST',
        data: {
            accion: 'actualizarStock',
            idSede: sedeActual,
            idPresentacion: productoEditando.idPresentacion,
            cantidad: cantidad,
            costoUnitario: costoUnitario
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                });

                // Cerrar modal y recargar inventario
                bootstrap.Modal.getInstance(document.getElementById('modalEditarStock')).hide();
                cargarInventarioPorSede();
            } else {
                Swal.fire('Error', response.mensaje, 'error');
            }
        },
        error: function(error) {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudo actualizar el stock', 'error');
        }
    });
}

/**
 * Separar miles en números
 */
function separarMiles(numero) {
    numero = Number(numero);
    return new Intl.NumberFormat("es-CO").format(numero);
}

init();
