<?php 

    require_once('../core/conexion.php');

    class EliminarDetallePedidoModel 
    {
        protected function set_eliminarDetallePedido($idDetallePedido, $idPedido) {

            try {
                $db = new Conexion();

                $sql = "UPDATE detalle_pedido SET estado = 0 WHERE id_detalle_pedido = :idDetallePedido";

                $params = [
                    ':idDetallePedido' => $idDetallePedido
                ];

                $respuesta = $db->execute($sql, $params);
                /* $this->recalcularTotales($idPedido); */
                return $respuesta;
                

            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }

            
        }

        /* private function recalcularTotales($idPedido){

            $db = new Conexion();

            $queryTotales = "SELECT 
                        SUM(ped.precio_compra_presentacion * dp.cantidad_detalle_pedido) AS costoTotal,
                        SUM(dp.precio_unitario_detalle_pedido * dp.cantidad_detalle_pedido) AS valorTotal,
                        SUM(ped.precio_venta_jm_presentacion * dp.cantidad_detalle_pedido) AS valorVentaJM
                    FROM detalle_pedido dp
                    INNER JOIN presentacion_producto ped ON dp.id_presentacion = ped.id_presentacion
                    WHERE dp.id_pedido = :idPedido AND dp.estado = 1";
                $result = $db->select($queryTotales, [':idPedido' => $idPedido]);
                $costoTotal = $result[0]['costoTotal'] ?? 0;
                $valorTotal = $result[0]['valorTotal'] ?? 0;
                $valorVentaJM = $result[0]['valorVentaJM'] ?? 0;
                $gananciaTotal = $result[0]['valorTotal'] - $result[0]['valorVentaJM'];

                // 2. Actualizar la tabla pedidos con los nuevos totales
                $update = "UPDATE pedidos 
                        SET costo_total_pedido = :costoTotal, 
                            valor_total_pedido = :valorTotal, 
                            ganancia_total_pedido = :gananciaTotal
                        WHERE id_pedidos = :idPedido";
                $db->execute($update, [
                    ':costoTotal' => $costoTotal,
                    ':valorTotal' => $valorTotal,
                    ':gananciaTotal' => $gananciaTotal,
                    ':idPedido' => $idPedido
                ]);
        } */
    }
    