<?php 
    session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Ganancias</h1>
                <p>Aquí puedes ver todas las ganancias generadas.</p>
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
            <div class="card-option bg-primary" onclick="redireccionar('pedidos')">
                <h2>Ganancias del mes actual</h2>
                <!-- <i class="fa-solid fa-cart-plus card-option-icon"></i> -->
            </div>

            <div class="card-option bg-success" onclick="redireccionar('pedidos')">
                <h2>Ganancias Totales</h2>
                
            </div>
        </div>
    </section>

</main>


<script src="assets/js/listadoPedidos.js"></script>