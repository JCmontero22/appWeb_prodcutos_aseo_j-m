<?php 

    require_once('../core/conexion.php');

    class ActualizarPedidoModel 
    {
        protected function set_actualizarPedido($cantidad, $idDetallePedido) {

            try {
                $db = new Conexion();

                $sql = "UPDATE detalle_pedido SET cantidad_detalle_pedido = :cantidad WHERE id_detalle_pedido 
                        = :idDetallePedido";

                $params = [
                    ':cantidad' => $cantidad,
                    ':idDetallePedido' => $idDetallePedido
                ];

                $respuesta = $db->execute($sql, $params);
                return $respuesta;

            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }

            
        }
    }
    