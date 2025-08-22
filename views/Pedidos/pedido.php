<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Realizar pedidos</h1>
                <p>Aquí puedes realizar tus pedidos.</p>
            </div>
            <div class="col-md-2 header-btn">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row"></div>
        <div class="col-md-12 d-flex justify-content-end">
            <button class="btn btn-success" style="margin-right: 1rem;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Registrar Usuario</button>
            <button class="btn btn-danger" onclick="redireccionar('home')">Regresar</button>
        </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="cliente-select">Seleccione un cliente:</label>
                            <select name="cliente" id="cliente-select" class="form-select">
                                <option value="">Seleccione un cliente</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2 g-5">
                        <div class="col-md-4">
                            <label for="producto">Producto:</label>
                            <select name="producto" id="producto-select" class="form-select">
                                <option value="">Seleccione un producto</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-warning" onclick="agregarProducto()">Agregar</button>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-success" onclick="realizarPedido()">Realizar Pedido</button>
                        </div>
                    </div>
                </form>

                <div class="row mt-5"></div>
                <h3 id="total"></h3>
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered text-center" id="carrito-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <!-- <th>Presentacion</th> -->
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Op</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se agregarán las filas del carrito -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Registrar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formRegistrarUsuario">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarUsuario()">Registrar</button>
                </div>
            </form>
    </div>
</div>

<script src="assets/js/pedido.js"></script>