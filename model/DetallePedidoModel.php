<?php 

    require_once('../core/conexion.php');

    class DetallePedidoModel 
    {
        protected function get_detallePedido($idPedido){
            try {
                $db = new Conexion();
                $query = "SELECT 
                                p.nombre_produto AS nombreProducto, 
                                ped.id_presentacion AS idPresentacion,
                                ped.tamano_presentacion  AS presentacion,
                                dp.cantidad_detalle_pedido AS cantidad, 
                                dp.subtotal_unitario_detalle_pedido AS subtotal,
                                dp.id_detalle_pedido AS idDetallePedido,
                                pe.id_estado AS estado,
                                ped.precio_venta_cliente_presentacion AS precioVenta
                            FROM detalle_pedido dp
                            INNER JOIN presentacion_producto ped ON dp.id_presentacion = ped.id_presentacion
                            INNER JOIN productos p ON ped.id_producto = p.id_producto
                            INNER JOIN pedidos pe ON dp.id_pedido = pe.id_pedidos
                            WHERE dp.id_pedido = :idPedido AND dp.estado = 1";

                $params = [':idPedido' => $idPedido];
                $respuesta = $db->select($query, $params);
                return $respuesta;
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
    