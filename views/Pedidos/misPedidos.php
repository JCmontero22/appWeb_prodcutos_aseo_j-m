<?php 
    session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Mis Ventas</h1>
                <p>Aquí puedes ver todos las ventas realizadas.</p>
            </div>
            <div class="col-md-2 header-btn">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end mb-5">
                <button class="btn btn-success" style="margin-right: 10px;" onclick="realizarCalculo('home')">Calcular cuenta</button>
                <button class="btn btn-primary" onclick="redireccionar('home')">Regresar</button>
                
            </div>
        </div>

        <!--*************** tabs ***************-->
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active tituloTab" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" >Listado Ventas</button>
                <?php if ($_SESSION['rol'] == 1) : ?>
                    <button class="nav-link tituloTab" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"  onclick="listadoVentas(1)">Mis Ventas</button>
                <?php endif; ?>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table mt-5 table-bordered table-hover tableVentas" id="tabla_pedidos">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Total</th>
                                    <th>Ganancia</th>
                                    <th>Fecha Pedido</th>
                                    <th>Fecha Entrega</th>
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
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table mt-5 table-bordered table-hover tableVentas" id="tabla_ventas_admin">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Total</th>
                                    <th>Ganancia</th>
                                    <th>Fecha Pedido</th>
                                    <th>Fecha Entrega</th>
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
            </div>
            
        </div>
    </section>

</main>


<!-- Modal Detalle-->
<div class="modal fade" id="modalDetalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detalle Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detalleContenido" class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Presentación</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="detallePedidoBody">
                            <!-- Aquí se agregarán las filas de detalles del pedido -->
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <button id="btnAgregarProducto" type="button" class="btn btn-primary" style="margin-right: 1rem;" onclick="agregarProducto()">Agregar Producto</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar estado-->
<div class="modal fade" id="modalEditarEstado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editar Estado del Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select name="estado" id="estado" class="form-select">
                    <option value="">Seleccione Estado</option>
                    <?php 
                        if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '2') {
                            echo    '<option id="estado-2" value="2">Confirmado</option>
                                    <option id="estado-3" value="3">Alistado</option>
                                    <option id="estado-5" value="5">Cancelado</option>
                                    <option id="estado-4" value="4">Entregado</option>
                                    <option id="estado-6" value="6">Finalizado</option>';
                                    
                        }elseif ($_SESSION['rol'] == '4') {
                            echo '<option value="4">Entregado</option> ';
                                    
                        }
                    
                    ?>
                    
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="actualizarEstado()">Actualizar Estado</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Calculo-->
<div class="modal fade" id="modalCalculo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Calculo de los pedidos entregados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body calculo">
                <h3 id="entregar" class="bg-warning">Total a enviar: <span id="valorEnviar"></span></h3>
                <h3 id="entregar" class="bg-success">Total Ganancias: <span id="valorGanancias"></span></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="finalizarPedidos()">Finalizar Pedidos</button>
            </div>
        </div>
    </div>
</div>


<script src="assets/js/listadoVentas.js"></script>
