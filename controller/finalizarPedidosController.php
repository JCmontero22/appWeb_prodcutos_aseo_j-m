<?php 

    require_once('../model/FinalizarPedidosModel.php');

    class finalizarPedidosController extends FinalizarPedidosModel
    {
        public function finalizarPedido(){

            try {
                $idUsuario = $_SESSION['id'];
                $respuesta = $this->set_finalizarPedidos($idUsuario);

                if ($respuesta > 0) {
                    return [
                        'status' => 'success',
                        'message' => 'Pedido finalizado correctamente'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'No hay pedidos para finalizar'
                    ];
                }    
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error al finalizar el pedido: ',
                    'data' => $e->getMessage()
                ];
            }

            

        }
    }
    