<?php 

        require_once('../core/conexion.php');

        class ConsultaTotalesModel 
        {
            public function get_totales($idPedido) {
                $db = new Conexion();

                $query = "SELECT 
                            SUM(ped.precio_compra_presentacion * dp.cantidad_detalle_pedido) AS costoTotal,
                            SUM(dp.precio_unitario_detalle_pedido * dp.cantidad_detalle_pedido) AS valorTotal,
                            SUM(ped.precio_venta_jm_presentacion * dp.cantidad_detalle_pedido) AS valorVentaJM
                        FROM 
                            detalle_pedido dp
                            INNER JOIN presentacion_producto ped ON dp.id_presentacion = ped.id_presentacion
                        WHERE 
                            dp.id_pedido = :idPedido AND dp.estado = 1";

                $resultado = $db->select($query, [':idPedido' => $idPedido]);

                $respuesta = [
                    'costoTotal' => $resultado[0]['costoTotal'] ?? 0,
                    'valorTotal' => $resultado[0]['valorTotal'] ?? 0,
                    'valorVentaJM' => $resultado[0]['valorVentaJM'] ?? 0,
                    'gananciaTotal' => $resultado[0]['valorTotal'] - $resultado[0]['valorVentaJM']
                ];

                return $respuesta;

            }
        }
