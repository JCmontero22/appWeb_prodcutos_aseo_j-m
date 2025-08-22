<?php 

    require_once('../core/conexion.php');

    class EditarEstadoPedidoModel
    {
        protected function set_actualizarEstadoPedido($idEstado, $idPedido) {

            try {
                $db = new Conexion();

                $query = "UPDATE pedidos SET id_estado = :idEstado WHERE id_pedidos = :idPedido";

                $parametros = [
                    ':idEstado' => $idEstado,
                    ':idPedido' => $idPedido
                ];

                $respuesta = $db->execute($query, $parametros);
                return $respuesta;
            } catch (\Exception $e) {
                throw $e;
            }
            
        }        
    }
    