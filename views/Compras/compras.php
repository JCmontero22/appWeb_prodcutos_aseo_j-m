<?php
session_start();
?>

<main class="container mt-5">
    <section class="content-header">
        <div class="row">
            <div class="col-md-10">
                <h1>Compra de productos</h1>
                <p>Aquí se registran todas las compras realizadas de los productos disponibles.</p>
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
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Historial de Compras</h2>
                    <div>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formCompra" onclick="cargarDatos()">Registrar compra</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive mt-4">
                    <table class="table table-striped table-bordered table-hover" id="tabla_compras">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Proveedor</th>
                                <th>Fecha</th>
                                <th>Num Factura</th>
                                <th>Total</th>
                                <th>Tipo Pago</th>
                                <th>Sede</th>
                                <th>Observacion</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_compras" class="text-center">
                            <!-- Los movimientos se cargarán aquí mediante JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>


<!-- Modal -->
<div class="modal fade" id="formCompra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Registro Compra</h3>
                <button type="button" id="cerrarModalRegistro" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="row g-3">
                        <h4 class="mb-3">Compra</h4>

                        <div class="col-md-3">
                            <input class="form-control" type="text" name="proveedor" id="proveedor" placeholder="* Proveedor" required>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="numFactura" id="numFactura" placeholder="* Numero Factura" required>
                        </div>
                        <div class="col-md-3">
                            <select name="idSede" id="idSede" class="form-select">

                            </select>
                        </div>
                         <div class="col-md-3">
                            <select name="tipoPago" id="tipoPago" class="form-select"></select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="* Descripción" required></textarea>
                        </div>
                    </div>

                    <div class="row mt-5 g-4">
                        <h4 class="mb-3">Detalle Compra</h4>
                        <div class="col-md-5"> 
                            <select name="idProducto" id="idProducto" class="form-select"></select>
                        </div>

                        <div class="col-md-3"> 
                            <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="* Cantidad" required>
                        </div>

                        <div class="col-md-3"> 
                            <input type="number" class="form-control" name="precio" id="precio" placeholder="* Precio" required>
                        </div>
                        
                        <div class="col-md-1 d-flex justify-content-end"> 
                            <button class="btn btn-warning" onclick="agregarDetalleCompra()"><i class="fa-solid fa-square-plus icon2"></i></button>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="detalleCompraTable">
                                <thead class="table-dark">
                                    <tr class="">
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Valor JM</th>
                                        <th>Valor Cliente</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleCompraBody">
                                    <!-- Aquí se agregarán los detalles de la compra -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-end">
                        <h4><span id="totalCompra">0</span></h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarFormularioCompra()">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="registrarCompra()">Registrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalDetalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetalleLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalDetalleLabel">Detalle compra</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="detalleCompraTable">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Presentacion</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="detalleCompraModalBody"></tbody>
                    <!-- Aquí se cargarán los detalles de la compra -->
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div> -->
    </div>
  </div>
</div>

<script src="assets/js/compras.js"></script>
