



<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Bienvenido panel vendedor</h1>
                <p>Contenido protegido. Solo usuarios autenticados pueden ver esto.</p>
            </div>
            <div class="col-md-2 header-btn">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a>
            </div>
        </div>
    </section>

    <section class="content-body">

        <div class="content-option">
            <div class="card-option stock" onclick="redireccionar('listadoProductos')">
                <h2>Stock Productos</h2>
                <i class="fa-solid fa-cart-flatbed card-option-icon"></i>
            </div>

            <div class="card-option pedidos" onclick="redireccionar('pedidos')">
                <h2>Realizar Pedidos</h2>
                <i class="fa-solid fa-cart-plus card-option-icon"></i>
            </div>

            <div class="card-option listaPedidos" onclick="redireccionar('misPedidos')">
                <h2>Mis Pedidos</h2>
                <i class="fa-solid fa-clipboard-list card-option-icon"></i>
            </div>

            <!-- <div class="card-option listaPedidos" onclick="redireccionar('clientes')">
                <h2>Clientes</h2>
                <i class="fa-solid fa-users-line card-option-icon"></i>
            </div> -->
        </div>

        
    </section>

</main>

<script src="assets/js/app.js"></script>



<?php 
  /*   $password = 'maron';
    $hash = password_hash($password, PASSWORD_DEFAULT); 
    var_dump($hash); */
?>