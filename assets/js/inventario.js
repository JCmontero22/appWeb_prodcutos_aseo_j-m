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
        // Destruir DataTable si existe
        if ($.fn.DataTable.isDataTable('#tablaInventario')) {
            $('#tablaInventario').DataTable().destroy();
        }
        // Limpiar la tabla
        let html = '<tr><td colspan="7" class="text-center text-muted">Seleccione una sede para ver el inventario</td></tr>';
        $('#tablaInventario tbody').html(html);
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
    // Si DataTable ya existe, destruirlo
    if ($.fn.DataTable.isDataTable('#tablaInventario')) {
        $('#tablaInventario').DataTable().destroy();
    }

    let tableData = [];

    if (data.length > 0) {
        data.forEach(item => {
            tableData.push([
                item.nombre_produto,
                item.tamano_presentacion,
                item.cantidad_stock_presentacion_sede,
                '$' + separarMiles(item.precio_compra_presentacion),
                '$' + separarMiles(item.precio_venta_jm_presentacion),
                '$' + separarMiles(item.precio_venta_cliente_presentacion),
                `<button class="btn btn-primary btn-sm" onclick="abrirModalEditar(${item.id_presentacion}, '${item.nombre_produto} - ${item.tamano_presentacion}', ${item.cantidad_stock_presentacion_sede}, ${item.precio_compra_presentacion})">
                    <i class="fa-solid fa-pencil"></i>
                </button>`
            ]);
        });
    }

    // Limpiar tbody antes de inicializar
    $('#tablaInventario tbody').empty();

    // Inicializar DataTable
    $('#tablaInventario').DataTable({
        data: tableData,
        responsive: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json"
        },
        columnDefs: [
            { targets: -1, orderable: false, searchable: false }
        ],
        pageLength: 10,
        order: [[0, 'asc']],
        layout: {
            topStart: 'search',
            topEnd: 'info',
            bottomStart: 'pageLength',
            bottomEnd: 'paging'
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
