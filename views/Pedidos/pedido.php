<?php
    $sedeId = $_SESSION['sede'] ?? 1;
?>

<main class="container mt-4">
    <section class="content-header">
        <div class="row w-100 align-items-center">
            <div class="col-12 col-md-9">
                <h1>Realizar Pedidos</h1>
                <p>Aquí puedes registrar pedidos para tus clientes.</p>
            </div>
            <div class="col-12 col-md-3 header-btn mt-2 mt-md-0">
                <a href="#" onclick="logout()"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </div>
    </section>

    <section class="content-body">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end gap-2">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fa-solid fa-user-plus"></i> Registrar Cliente
                </button>
                <button class="btn btn-primary" onclick="redireccionar('home')">
                    <i class="fa-solid fa-arrow-left"></i> Regresar
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form action="" onsubmit="return false;">
                    <div class="row g-3">
                        <div class="col-12 col-md-8">
                            <label for="cliente-select">Seleccione un cliente:</label>
                            <select name="cliente" id="cliente-select" class="form-select">
                                <option value="">Seleccione un cliente</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-5">
                            <label for="producto-select">Producto:</label>
                            <select name="producto" id="producto-select" class="form-select">
                                <option value="">Seleccione un producto</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" min="1" class="form-control" placeholder="Cant." required>
                        </div>
                        <div class="col-12 col-md-4 d-flex flex-column justify-content-end">
                            <label class="d-none d-md-block">&nbsp;</label>
                            <button type="button" class="btn btn-warning w-100" onclick="agregarProducto()">
                                <i class="fa-solid fa-plus"></i> Agregar Producto
                            </button>
                        </div>
                    </div>
                </form>

                <div class="row mt-3 align-items-center g-2">
                    <div class="col-6 col-md-6">
                        <h3 id="total" class="m-0">Total: $0</h3>
                    </div>
                    <div class="col-6 col-md-6 d-flex justify-content-end">
                        <button type="button" class="btn btn-success px-3 w-100" style="max-width: 220px;" onclick="realizarPedido()">
                            <i class="fa-solid fa-check"></i> Realizar Pedido
                        </button>
                    </div>
                </div>

                <div class="col-12 table-responsive mt-3">
                    <table class="table table-striped table-bordered text-center" id="carrito-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <!-- <th>Presentacion</th> -->
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th style="width: 70px;">Acción</th>
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
    <div class="modal-dialog modal-dialog-centered">
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
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarUsuario()">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Pasar sede_id desde PHP a JavaScript
    const SEDE_ID = <?php echo $sedeId; ?>;
</script>

<script src="assets/js/pedido.js"></script>

<script>
// Mover pantalla cuando el teclado aparece para que no se tape el input
document.addEventListener('DOMContentLoaded', function() {
    const focusableElements = document.querySelectorAll('input, select, textarea');

    focusableElements.forEach(element => {
        element.addEventListener('focus', function(e) {
            setTimeout(() => {
                this.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        });
    });
});
</script>