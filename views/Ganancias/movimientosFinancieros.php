<?php
session_start();
?>

<main class="container mt-4">
    <section class="content-header">
        <div class="row w-100 align-items-center">
            <div class="col-12 col-md-9">
                <h1>Movimientos Financieros</h1>
                <p>Aquí puedes monitorear todos los ingresos, egresos y el balance en cuenta.</p>
            </div>
            <div class="col-12 col-md-3 header-btn mt-2 mt-md-0">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end flex-wrap gap-2">
                <button class="btn btn-secondary" onclick="obtenerListadoMovimientosAntiguos()">
                    <i class="fa-solid fa-clock-rotate-left"></i> Historial
                </button>
                <button class="btn btn-primary" onclick="redireccionar('home')">
                    <i class="fa-solid fa-arrow-left"></i> Regresar
                </button>
            </div>
        </div>

        <div class="row">
            <div class="content-option">
                <div class="card-option bg-primary">
                    <i class="fa-solid fa-scale-balanced card-option-icon"></i>
                    <h2>Dinero en Cuenta (Diferencia)</h2>
                    <span class="detalle-card">Total ingresos - Total egresos</span>
                    <p class="valor-card" id="diferencia"></p>
                </div>

                <div class="card-option bg-success">
                    <i class="fa-solid fa-circle-arrow-up card-option-icon"></i>
                    <h2>Ingresos Totales</h2>
                    <span class="detalle-card">Suma de todos los ingresos</span>
                    <p class="valor-card" id="ingresos"></p>
                </div>

                <div class="card-option bg-danger">
                    <i class="fa-solid fa-circle-arrow-down card-option-icon"></i>
                    <h2>Egresos Totales</h2>
                    <span class="detalle-card">Total de todos los egresos</span>
                    <p class="valor-card" id="egresos"></p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h2>Historial de Movimientos</h2>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" onclick="obtenerListadoMovimientos()">
                            <i class="fa-solid fa-rotate"></i> Actualizar
                        </button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#formEgreso">
                            <i class="fa-solid fa-minus"></i> Ingresar Egreso
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tablaMovimientosFinancieros">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Movimiento</th>
                                <th>Monto</th>
                                <th>Descripción</th>
                                <th>Referencia</th>
                                <th>Realizado por</th>
                                <th>Sede</th>
                            </tr>
                        </thead>
                        <tbody id="tablaMovimientos" class="text-center">
                            <!-- Los movimientos se cargarán aquí mediante JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>


<!-- Modal -->
<div class="modal fade" id="formEgreso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Registro Egreso</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <input class="form-control" type="number" name="montoEgreso" id="montoEgreso" placeholder="* Monto" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <input class="form-control" type="text" name="referencia" id="referencia" placeholder="* Referencia">
                        </div>
                        <div class="col-12 col-md-4">
                            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="* Descripción"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="registrarEgreso()">Registrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL PARA EL HISTORIAL -->


<!-- Modal -->
<div class="modal fade" id="historialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historialModalLabel">Historial de Movimientos Financieros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-bordered table-hover" id="tablaMovimientosHistorial">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Movimiento</th>
                                <th>Monto</th>
                                <th>Descripción</th>
                                <th>Referencia</th>
                                <th>Realizado por</th>
                            </tr>
                        </thead>
                        <tbody id="tablaMovimientosHistorial" class="text-center">
                            <!-- Los movimientos se cargarán aquí mediante JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/movimientosFinancieros.js"></script>