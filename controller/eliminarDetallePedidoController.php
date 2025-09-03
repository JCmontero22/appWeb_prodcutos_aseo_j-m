<?php 

    require_once('../model/EliminarDetallePedidoModel.php');

    class eliminarDetallePedidoController extends EliminarDetallePedidoModel
    {

        private $idDetallePedido;

        public function __construct($idDetallePedido) {
            $this->idDetallePedido = $idDetallePedido;

        }

        public function  eliminarDetallePedido() {
            try {
                $eliminarDetallePedido = $this->set_eliminarDetallePedido($this->idDetallePedido);

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