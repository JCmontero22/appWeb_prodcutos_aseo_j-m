
<?php 
    session_start();
?>



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
            <div class="card-option bg-primary" onclick="redireccionar('listadoProductos')">
                <h2>Stock Productos</h2>
                <i class="fa-solid fa-cart-flatbed card-option-icon"></i>
            </div>

            <div class="card-option bg-secondary" onclick="redireccionar('pedidos')">
                <h2>Realizar Pedido</h2>
                <i class="fa-solid fa-cart-plus card-option-icon"></i>
            </div>

            <div class="card-option bg-info" onclick="redireccionar('misPedidos')">
                <h2>Mis Ventas</h2>
                <i class="fa-solid fa-clipboard-list card-option-icon"></i>
            </div>

            <div class="card-option bg-warning" onclick="redireccionar('clientes')">
                <h2>Clientes</h2>
                <i class="fa-solid fa-clipboard-list card-option-icon"></i>
            </div>
             <?php if ($_SESSION['rol'] == 1) : ?>
            <div class="card-option bg-success" onclick="redireccionar('ganancias')">
                <h2>Ganancias</h2>
                <i class="fa-solid fa-money-check-dollar card-option-icon"></i>
            </div>

            <div class="card-option bg-danger" onclick="redireccionar('movimientosFinancieros')">
                <h2>Movimientos Finanacieros</h2>
                <i class="fa-solid fa-money-bill-transfer card-option-icon"></i>
            </div>
            <?php endif; ?>
            <!-- <div class="card-option bg-success" onclick="redireccionar('ganancias')">
                <h2>Mis Ganancias</h2>
                <i class="fa-solid fa-clipboard-list card-option-icon"></i>
            </div> -->


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