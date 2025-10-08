<?php 
    session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Movimientos financieros</h1>
                <p>Aquí puedes ver todos los movimientos financieros generados </p>
            </div>
            <div class="col-md-2 header-btn">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-primary" onclick="redireccionar('home')">Regresar</button>
            </div>
        </div>

        <div class="row mt-5">
             <div class="content-option">
                <div class="card-option bg-success">
                    <h2>Ingresos</h2>
                    <span class="detalle-card">Suma de todos los ingresos</span>
                    <p class="valor-card" id="ingresos"></p>
                </div>

                <div class="card-option bg-danger">
                    <h2>Egresos</h2>
                    <span class="detalle-card">Total de todos los egresos</span>
                    <p class="valor-card" id="egresos"></p>
                </div>

                <div class="card-option bg-primary">
                    <h2>Total diferencia</h2>
                    <span class="detalle-card">Total de ingresos - Total de egresos</span>
                    <p class="valor-card" id="diferencia"></p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Historial de Movimientos Financieros</h2>
                    <div>
                        <button class="btn btn-primary" onclick="obtenerListadoMovimientos()">Actualizar</button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#formEgreso">Ingresar egreso</button>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered table-hover" id="tablaMovimientosFinancieros">
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
                    <tbody id="tablaMovimientos" class="text-center">
                        <!-- Los movimientos se cargarán aquí mediante JavaScript -->
                    </tbody>
                </table>
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
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control" type="number" name="montoEgreso" id="montoEgreso" placeholder="* Monto" required>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="referencia" id="referencia" placeholder="* Referencia">
                    </div>
                    <div class="col-md-4">
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


<script src="assets/js/movimientosFinancieros.js"></script>