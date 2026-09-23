<?php
session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Ventas Finalizadas</h1>
                <p>Registro de todas las ventas en estados Pagada y Finalizada.</p>
            </div>
            <div class="col-md-2 header-btn">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row">
            <div class="col-md-3">
                <label for="filtroMes" class="form-label">Filtrar por Mes:</label>
                <select id="filtroMes" class="form-select" onchange="cargarVentasFinalizadas()">
                    <option value="">-- Todos los meses --</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
            <div class="col-md-9 d-flex align-items-end justify-content-end mb-3">
                <button class="btn btn-primary" onclick="redireccionar('home')">Regresar</button>
            </div>
        </div>

        <!-- Tabla de Ventas Finalizadas -->
        <div class="row mt-4">
            <div class="col-12 table-responsive">
                <table class="table table-bordered table-hover" id="tablaVentasFinalizadas">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Pedido</th>
                            <th>Sede</th>
                            <th>Vendedor</th>
                            <th>Rol</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Costo Total</th>
                            <th>Ganancia J&M</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<script src="assets/js/ventasFinalizadas.js?v=<?= time() ?>"></script>
