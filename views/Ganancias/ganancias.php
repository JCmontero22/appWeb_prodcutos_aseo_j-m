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

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active tituloTab" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Ganancias</button>
                <?php if ($_SESSION['rol'] == 1) : ?>
                    <button class="nav-link tituloTab" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Historial</button>
                <?php endif; ?>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row mt-5 content-option">
                    <div class="card-option bg-primary" onclick="redireccionar('gananciasDelMes', '1')">
                        <h2>Ganancias del mes actual</h2>
                        <!-- <i class="fa-solid fa-cart-plus card-option-icon"></i> -->
                    </div>

                    <div class="card-option bg-success" onclick="redireccionar('ganaciasTotales', '1')">
                        <h2>Ganancias Totales</h2>
                        
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row mt-5 content-option">
                    <div class="card-option bg-success" onclick="redireccionar('ganaciasTotales', '2')">
                        <h2>Ganancias Totales</h2>
                        
                    </div>
                </div>
            </div>
        </div>

        
    </section>

</main>


