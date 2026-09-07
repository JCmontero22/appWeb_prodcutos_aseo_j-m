
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
            <div class="card-option stock" onclick="redireccionar('listadoProductos')">
                <i class="fa-solid fa-boxes-stacked card-option-icon"></i>
                <h2>Stock</h2>
            </div>

            <div class="card-option pedidos" onclick="redireccionar('pedidos')">
                <i class="fa-solid fa-cart-plus card-option-icon"></i>
                <h2>Realizar Pedido</h2>
            </div>

            <div class="card-option listaPedidos" onclick="redireccionar('misPedidos')">
                <i class="fa-solid fa-receipt card-option-icon"></i>
                <h2>Mis Ventas</h2>
            </div>

            <div class="card-option clientes" onclick="redireccionar('clientes')">
                <i class="fa-solid fa-users card-option-icon"></i>
                <h2>Clientes</h2>
            </div>
             <?php if ($_SESSION['rol'] == 1) : ?>
            <div class="card-option ganancias" onclick="redireccionar('ganancias')">
                <i class="fa-solid fa-chart-line card-option-icon"></i>
                <h2>Ganancias</h2>
            </div>

            <div class="card-option movimientos" onclick="redireccionar('movimientosFinancieros')">
                <i class="fa-solid fa-money-bill-wave card-option-icon"></i>
                <h2>Movimientos</h2>
            </div>

            <div class="card-option pedidos" onclick="redireccionar('compras')">
                <i class="fa-solid fa-bag-shopping card-option-icon"></i>
                <h2>Compras</h2>
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