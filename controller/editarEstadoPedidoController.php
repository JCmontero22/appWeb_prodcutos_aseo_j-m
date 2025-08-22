<?php 

    require_once('../model/EditarEstadoPedidoModel.php');

    class editarEstadoPedidoController extends EditarEstadoPedidoModel
    {
        private $idPedido;
        private $idEstado;

        public function __construct($idPedido, $idEstado) {
            $this->idPedido = $idPedido;
            $this->idEstado = $idEstado;
        }

        public function actualizarEstadoPedido(){

            try {
                $respuestaActualizar = $this->set_actualizarEstadoPedido($this->idEstado, $this->idPedido);

                return $respuesta = [
                    'status' => 'success',
                    'message' => 'Estado del pedido actualizado correctamente',
                    'data' => $respuestaActualizar
                ];
            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'message' => 'Error al actualizar el estado del pedido',
                    'data' => $e->getMessage()
                ];  
            }

        }
    }
    