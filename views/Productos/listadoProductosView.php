<main class="container mt-4">
    <section class="content-header">
        <div class="row w-100 align-items-center">
            <div class="col-12 col-md-9">
                <h1>Listado de Productos</h1>
                <p>Aquí puedes ver todos los productos disponibles y el inventario.</p>
            </div>
            <div class="col-12 col-md-3 header-btn mt-2 mt-md-0">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-primary" onclick="redireccionar('home')">
                    <i class="fa-solid fa-arrow-left"></i> Regresar
                </button>
            </div>
        </div>

        <?php if ($_SESSION['rol'] == 1) : ?>
            <div class="row align-items-end mb-3 g-2">
                <div class="col-12 col-md-6">
                    <div class="select-sede-container">
                        <label for="sedes" class="form-label">Filtrar por sede:</label>
                        <select name="sedes" id="sedes" class="form-select">
                            <option value="">-- Todas las sedes --</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                    <span id="valorTotalStock" class="content-ganancias"></span>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered table-hover tablaProductos" id="tablaProductos">
                    <thead class="table-dark">
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Nombre</th>
                            <th>Presentacion</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <?php if ($_SESSION['rol'] == 1) { 
                                echo '<th>Valor Stock</th>';
                            } ?>
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

<script>
    let idRol = <?php echo $_SESSION['rol']; ?>;
    console.log(idRol);
    
</script>

<script src="assets/js/listadoProductos.js"></script>

