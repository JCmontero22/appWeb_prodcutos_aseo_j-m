<?php 

    require_once('../model/EliminarDetallePedidoModel.php');
    require_once('../controller/RecalcularTotalesController.php');

    class eliminarDetallePedidoController extends EliminarDetallePedidoModel
    {

        private $idDetallePedido;
        private $idPedido;
        private $recalcular;

        public function __construct($idDetallePedido, $idPedido, RecalcularTotalesController $recalcular) {
            $this->idDetallePedido = $idDetallePedido;
            $this->idPedido = $idPedido;
            $this->recalcular = $recalcular;

        }

        public function  eliminarDetallePedido() {
            try {
                $eliminarDetallePedido = $this->set_eliminarDetallePedido($this->idDetallePedido, $this->idPedido);
                
                $recalculo = $this->recalcular->recalcular($this->idPedido);

                return $respuesta = [
                    'status' => 'success',
                    'message' => 'Producto eliminado correctamente',
                    'data' => $this->idDetallePedido
                ];

            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'failed',
                    'message' => 'Error al eliminar el producto',
                    'data' => $e->getMessage()
                ];
            }
        }
    }