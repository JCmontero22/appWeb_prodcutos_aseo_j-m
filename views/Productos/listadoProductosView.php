<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Listado de Productos</h1>
                <p>Aquí puedes ver todos los productos disponibles.</p>
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

        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table mt-5 table-bordered table-hover" id="tablaProductos">
                    <thead class="table-dark">
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Nombre</th>
                            <th>Presentacion</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se agregarán las filas de productos -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="card-option stock" onclick="redireccionar('listadoProductos')">
            <h2>Stock Productos</h2>
            <i class="fa-solid fa-cart-flatbed card-option-icon"></i>
        </div>

        <div class="card-option pedidos" onclick="redireccionar('misPedidos')">
            <h2>Mis Pedidos</h2>
            <i class="fa-solid fa-clipboard-list card-option-icon"></i>
        </div>

        <div class="card-option listaPedidos" onclick="redireccionar('realizarPedidos')">
            <h2>Realizar Pedidos</h2>
            <i class="fa-solid fa-cart-plus card-option-icon"></i>
        </div> -->
    </section>

</main>

<script src="assets/js/listadoProductos.js"></script>

