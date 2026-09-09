<?php 
    session_start();
?>

<main class="container mt-4">
    <section class="content-header">
        <div class="row w-100 align-items-center">
            <div class="col-12 col-md-9">
                <h1>Ganancias Totales</h1>
                <p>Aquí puedes ver todas las ganancias acumuladas del negocio.</p>
            </div>
            <div class="col-12 col-md-3 header-btn mt-2 mt-md-0">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-primary" onclick="redireccionar('ganancias')">
                    <i class="fa-solid fa-arrow-left"></i> Regresar
                </button>
            </div>
        </div>

        <div class="row">
             <div class="content-option">
                <div class="card-option bg-primary">
                    <i class="fa-solid fa-money-bill-trend-up card-option-icon"></i>
                    <h2>Ganancias Netas</h2>
                    <span class="detalle-card">Suma J&M + Vendedores</span>
                    <p class="valor-card" id="gananciasNetas"></p>
                </div>

                <div class="card-option bg-secondary">
                    <i class="fa-solid fa-chart-pie card-option-icon"></i>
                    <h2>Total Ventas</h2>
                    <span class="detalle-card">Total ventas sin restar ganancias</span>
                    <p class="valor-card" id="totalVendido"></p>
                </div>

                <div class="card-option bg-info">
                    <i class="fa-solid fa-calculator card-option-icon"></i>
                    <h2>Total Costo Vendido</h2>
                    <span class="detalle-card">Costo total de lo vendido</span>
                    <p class="valor-card" id="costoVendido"></p>
                </div>

                <div class="card-option bg-success">
                    <i class="fa-solid fa-sack-dollar card-option-icon"></i>
                    <h2>Dinero Recaudado</h2>
                    <span class="detalle-card">Total del dinero en la cuenta</span>
                    <p class="valor-card" id="dineroRecaudado"></p>
                </div>
            </div>
        </div>
    </section>

</main>

<script>var pantalla =2;</script>
<script src="assets/js/calculosGanancias.js"></script>