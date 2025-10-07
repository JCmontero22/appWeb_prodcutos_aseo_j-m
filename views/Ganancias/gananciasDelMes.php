<?php 
    session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Ganancias Del Mes</h1>
                <p>Aquí puedes ver todas las ganancias generadas en el mes.</p>
            </div>
            <div class="col-md-2 header-btn">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-primary" onclick="redireccionar('ganancias')">Regresar</button>
            </div>
        </div>

        <div class="row mt-5">
             <div class="content-option">
                <div class="card-option bg-primary">
                    <h2>Ganancias Netas</h2>
                    <span class="detalle-card">Suma J&M + Vendedores</span>
                    <p class="valor-card" id="gananciasNetas"></p>
                </div>

                <div class="card-option bg-secondary">
                    <h2>Total Ventas</h2>
                    <span class="detalle-card">Total ventas sin restar ganancias</span>
                    <p class="valor-card" id="totalVendido"></p>
                </div>

                <div class="card-option bg-info">
                    <h2>Total Costo Vendido</h2>
                    <span class="detalle-card">Costo total de lo vendido</span>
                    <p class="valor-card" id="costoVendido"></p>
                </div>
            </div>
        </div>
    </section>

</main>

<script>var pantalla =1;</script>
<script src="assets/js/calculosGanancias.js"></script>

