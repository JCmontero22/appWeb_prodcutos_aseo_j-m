<?php 

    require_once('../core/conexion.php');

    class AgregarPoductoAlPedidoModel 
    {
        protected function set_agregarProductoPedido($idPedido, $idPresentacion, $cantidad, $total, $precioVenta){
            try {
                $db = new Conexion();
                $query = "INSERT INTO detalle_pedido (
                                id_pedido, 
                                id_presentacion, 
                                cantidad_detalle_pedido, 
                                precio_unitario_detalle_pedido, 
                                subtotal_unitario_detalle_pedido
                            ) 
                        VALUES (
                            :id_pedido, 
                            :id_presentacion, 
                            :cantidad, 
                            :precioVenta, 
                            :subtotal
                        )";
                $params = [
                    ':id_pedido' => $idPedido,
                    ':id_presentacion' => $idPresentacion,
                    ':cantidad' => $cantidad,
                    ':precioVenta' => $precioVenta,
                    ':subtotal' => $total
                ];
                $respuesta = $db->execute($query, $params);

                
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    