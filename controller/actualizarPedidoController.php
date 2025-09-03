<?php 

    require_once('../model/ActualizarPedidoModel.php');

    class actualizarPedidoController extends ActualizarPedidoModel
    {

        private $cantidad;
        private $idDetallePedido;
        private $idPedido;

        public function __construct($cantidad, $idDetallePedido, $idPedido) {
            $this->cantidad = $cantidad;
            $this->idDetallePedido = $idDetallePedido;
            $this->idPedido = $idPedido;

        }

        public function  actualizarPedido() {
            try {
                $actualizarPedido = $this->set_actualizarPedido($this->cantidad, $this->idDetallePedido);

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
    