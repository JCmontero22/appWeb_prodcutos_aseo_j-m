<?php

    require_once('../model/AgregarPoductoAlPedidoModel.php');
    require_once('../controller/RecalcularTotalesController.php');
    require_once('../core/Validador.php');

    class AgregarPoductoAlPedidoController extends AgregarPoductoAlPedidoModel
    {
        private $idPedido;
        private $idPresentacion;
        private $cantidad;
        private $total;
        private $precioVenta;

        public function __construct($idPedido, $idPresentacion, $cantidad, $total, $precioVenta)
        {
            $this->idPedido = $idPedido;
            $this->idPresentacion = $idPresentacion;
            $this->cantidad = $cantidad;
            $this->total = $total;
            $this->precioVenta = $precioVenta;
        }

        public function agregarProducto()
        {
            try {
                Validador::reset();

                // Validaciones
                if (!Validador::validarID($this->idPedido, 'ID Pedido')) {
                    return ['status' => 'error', 'mensaje' => Validador::primerError()];
                }
                if (!Validador::validarID($this->idPresentacion, 'ID Presentación')) {
                    return ['status' => 'error', 'mensaje' => Validador::primerError()];
                }
                if (!Validador::validarCantidad($this->cantidad)) {
                    return ['status' => 'error', 'mensaje' => Validador::primerError()];
                }
                if (!Validador::validarNumero($this->precioVenta, 'Precio', 0)) {
                    return ['status' => 'error', 'mensaje' => Validador::primerError()];
                }

                $sedeId = $_SESSION['sede_id'] ?? 1;

                // Validar stock disponible
                $verificacion = $this->verificarStockProducto($this->idPresentacion, $this->cantidad, $sedeId);
                if (!$verificacion['disponible']) {
                    return ['status' => 'error', 'mensaje' => $verificacion['mensaje']];
                }

                $this->set_agregarProductoPedido($this->idPedido, $this->idPresentacion, $this->cantidad, $this->total, $this->precioVenta);

                // Recalcular totales
                $recalcular = new RecalcularTotalesController($this->idPedido, new ConsultaTotalesModel(), new RecalcularTotalesModel());
                $recalcular->recalcular();

                return $respuesta = ['status' => 'success', 'mensaje' => 'Producto agregado con éxito.'];
            } catch (\Exception $e) {
                return ['status' => 'error', 'mensaje' => $e->getMessage()];
            }
        }
    }
    