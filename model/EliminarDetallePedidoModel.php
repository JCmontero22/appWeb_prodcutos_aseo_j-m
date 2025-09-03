<?php 

    require_once('../core/conexion.php');

    class EliminarDetallePedidoModel 
    {
        protected function set_eliminarDetallePedido($idDetallePedido) {

            try {
                $db = new Conexion();

                $sql = "UPDATE detalle_pedido SET estado = 0 WHERE id_detalle_pedido = :idDetallePedido";

                $params = [
                    ':idDetallePedido' => $idDetallePedido
                ];

                $respuesta = $db->execute($sql, $params);
                return $respuesta;

            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }

            
        }
    }
    