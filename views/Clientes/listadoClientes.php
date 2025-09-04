<?php 
    session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Clientes</h1>
                <p>Aquí puedes ver todos los clientes registrados.</p>
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
                <table class="table mt-5 table-bordered table-hover" id="tabla-clientes">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se agregarán las filas de productos -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</main>


<!-- Modal Detalle-->
<div class="modal fade" id="modalUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detalle Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="" id="formActualizarCliente">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" id="nombre" name="nombre" class="form-control mb-3" placeholder="Nombre completo">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="telefono" name="telefono" class="form-control mb-3" placeholder="Teléfono">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="direccion" name="direccion" class="form-control mb-3" placeholder="Dirección">
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="actualizarCliente()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/clientes.js"></script>