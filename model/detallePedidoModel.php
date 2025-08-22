<?php 

    require_once('../core/conexion.php');

    class detallePedidoModel 
    {
        protected function get_detallePedido($idPedido){
            try {
                $db = new Conexion();
                $query = "SELECT 
                                p.nombre_produto AS nombreProducto, 
                                ped.tamano_presentacion  AS presentacion,
                                dp.cantidad_detalle_pedido AS cantidad, 
                                dp.subtotal_unitario_detalle_pedido AS subtotal
                            FROM detalle_pedido dp
                            INNER JOIN presentacion_producto ped ON dp.id_presentacion = ped.id_presentacion
                            INNER JOIN productos p ON ped.id_producto = p.id_producto
                            WHERE id_pedido = :idPedido";

                $params = [':idPedido' => $idPedido];
                $respuesta = $db->select($query, $params);
                return $respuesta;
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
    