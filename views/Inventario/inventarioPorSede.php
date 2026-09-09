<?php
session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Gestión de Inventario por Sede</h1>
                <p>Actualiza el stock y costo unitario de productos por sede.</p>
            </div>
            <div class="col-md-2 header-btn">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end mb-3">
                <button class="btn btn-primary" onclick="redireccionar('home')">Regresar</button>
            </div>
        </div>

        <!-- Seleccionar Sede -->
        <div class="row mt-3 mb-4">
            <div class="col-md-12">
                <label for="sedes" class="form-label">Seleccione una sede:</label>
                <select name="sedes" id="sedes" class="form-select" onchange="cargarInventarioPorSede()">
                    <option value="">-- Seleccione una sede --</option>
                </select>
            </div>
        </div>

        <!-- Tabla de Inventario -->
        <div class="row mt-4">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-hover" id="tablaInventario">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Presentación</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Precio Venta J&M</th>
                            <th>Precio Cliente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="inventarioBody">
                        <tr>
                            <td colspan="7" class="text-center text-muted">Seleccione una sede para ver el inventario</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<!-- Modal Editar Stock -->
<div class="modal fade" id="modalEditarStock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Editar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarStock">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="productoNombre" class="form-label">Producto:</label>
                        <input type="text" class="form-control" id="productoNombre" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="costoUnitario" class="form-label">Costo Unitario:</label>
                        <input type="number" class="form-control" id="costoUnitario" required min="0" step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambiosStock()">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/inventario.js"></script>
