<?php 

    require_once('../model/ActualizarPedidoModel.php');

    class actualizarPedidoController extends ActualizarPedidoModel
    {

        private $cantidad;
        private $idDetallePedido;
        private $idPedido;
        private $precioVenta;

        public function __construct($cantidad, $idDetallePedido, $idPedido, $precioVenta) {
            $this->cantidad = $cantidad;
            $this->idDetallePedido = $idDetallePedido;
            $this->idPedido = $idPedido;
            $this->precioVenta = $precioVenta;

        }

        public function  actualizarPedido() {
            try {
                $actualizarPedido = $this->set_actualizarPedido($this->cantidad, $this->idDetallePedido, $this->precioVenta);

                // Recalcular totales
                $recalcular = new RecalcularTotalesController($this->idPedido, new ConsultaTotalesModel(), new RecalcularTotalesModel());
                $recalcular->recalcular();

                return $respuesta = [
                    'status' => 'success',
                    'message' => 'Pedido actualizado correctamente',
                    'data' => $this->idPedido
                ];

            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'failed',
                    'message' => 'Error al actualizar el pedido',
                    'data' => $e->getMessage()
                ];
            }
        }
    }
    