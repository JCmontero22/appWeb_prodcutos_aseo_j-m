<?php

    require_once('../core/conexion.php');

    class AgregarPoductoAlPedidoModel
    {
        protected function verificarStockProducto($idPresentacion, $cantidad, $sedeId = 1){
            try {
                $db = new Conexion();
                $query = "SELECT cantidad_stock_presentacion_sede
                          FROM stock_sede_presentacion
                          WHERE id_presentacion = :id_presentacion
                          AND id_sede = :id_sede";
                $params = [
                    ':id_presentacion' => $idPresentacion,
                    ':id_sede' => $sedeId
                ];

                $resultado = $db->select($query, $params);

                if (empty($resultado)) {
                    return ['disponible' => false, 'mensaje' => 'Producto no encontrado en la sede'];
                }

                $stockActual = $resultado[0]['cantidad_stock_presentacion_sede'];

                if ($stockActual < $cantidad) {
                    return [
                        'disponible' => false,
                        'mensaje' => 'Stock insuficiente. Disponible: ' . $stockActual . ', Solicitado: ' . $cantidad
                    ];
                }

                return ['disponible' => true];
            } catch (\Exception $e) {
                return ['disponible' => false, 'mensaje' => 'Error al verificar stock: ' . $e->getMessage()];
            }
        }

        protected function set_agregarProductoPedido($idPedido, $idPresentacion, $cantidad, $total, $precioVenta){
            try {
                $db = new Conexion();
                $query = "INSERT INTO detalle_pedido (
                                id_pedidos,
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
    