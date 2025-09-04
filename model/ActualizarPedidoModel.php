<?php 

    require_once('../core/conexion.php');

    class ActualizarPedidoModel 
    {
        protected function set_actualizarPedido($cantidad, $idDetallePedido, $precioVenta) {

            try {
                $db = new Conexion();

                $sql = "UPDATE detalle_pedido SET cantidad_detalle_pedido = :cantidad, subtotal_unitario_detalle_pedido = :precioVenta WHERE id_detalle_pedido = :idDetallePedido";

                $params = [
                    ':cantidad' => $cantidad,
                    ':idDetallePedido' => $idDetallePedido,
                    ':precioVenta' => $precioVenta * $cantidad
                ];

                $respuesta = $db->execute($sql, $params);
                return $respuesta;

            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    