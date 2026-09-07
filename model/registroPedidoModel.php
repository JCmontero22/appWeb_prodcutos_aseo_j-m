<?php

    require_once('../core/conexion.php');

    class registroPedidoModel
    {
        protected function verificarStockDisponible($productos, $sedeId = 1){
            try {
                $db = new Conexion();

                foreach ($productos as $producto) {
                    $query = 'SELECT cantidad_stock_presentacion_sede
                              FROM stock_sede_presentacion
                              WHERE id_presentacion = :id_presentacion
                              AND id_sede = :id_sede';
                    $params = [
                        ':id_presentacion' => $producto['idPresentacion'],
                        ':id_sede' => $sedeId
                    ];

                    $resultado = $db->select($query, $params);

                    if (empty($resultado)) {
                        return [
                            'disponible' => false,
                            'mensaje' => 'Producto con ID ' . $producto['idPresentacion'] . ' no encontrado en la sede ' . $sedeId
                        ];
                    }

                    $stockActual = $resultado[0]['cantidad_stock_presentacion_sede'];

                    if ($stockActual < $producto['cantidad']) {
                        return [
                            'disponible' => false,
                            'mensaje' => 'Stock insuficiente para el producto ' . $producto['nombre'] .
                                       '. Disponible: ' . $stockActual . ', Solicitado: ' . $producto['cantidad']
                        ];
                    }
                }

                return ['disponible' => true];
            } catch (\Exception $e) {
                return ['disponible' => false, 'mensaje' => 'Error al verificar stock: ' . $e->getMessage()];
            }
        }

        protected function descontarStockSede($productos, $sedeId = 1){
            try {
                $db = new Conexion();

                foreach ($productos as $producto) {
                    $query = 'UPDATE stock_sede_presentacion
                              SET cantidad_stock_presentacion_sede = cantidad_stock_presentacion_sede - :cantidad
                              WHERE id_presentacion = :id_presentacion
                              AND id_sede = :id_sede';
                    $params = [
                        ':cantidad' => $producto['cantidad'],
                        ':id_presentacion' => $producto['idPresentacion'],
                        ':id_sede' => $sedeId
                    ];

                    $db->execute($query, $params);
                }

                return true;
            } catch (\Exception $e) {
                throw new \Exception('Error al descontar stock: ' . $e->getMessage());
            }
        }

        protected function set_registroPedido($data){

            try {
                $db = new Conexion();

                $query = 'INSERT INTO pedidos (
                                id_usuario, id_cliente,
                                id_estado,
                                fecha_pedido,
                                costo_total_pedido,
                                valor_total_pedido,
                                ganancia_total_pedido
                            )
                            VALUES (
                                :usuario,
                                :cliente,
                                :estado,
                                :fechaPedido,
                                :costoTotal,
                                :valorTotalPedido,
                                :totalGanancia)';
                $params = [
                    ':usuario' => $data['usuario'],
                    ':cliente' => $data['cliente'],
                    ':estado' => $data['estado'],
                    ':fechaPedido' => $data['fechaPedido'],
                    ':costoTotal' => $data['costoTotal'],
                    ':valorTotalPedido' => $data['valorTotalPedido'],
                    ':totalGanancia' => $data['totalGanancia']
                ];

                return $respuesta = $db->execute($query, $params);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        protected function set_registroDetallePedido($data){

            try {
                $db = new Conexion();

                $query = 'INSERT INTO detalle_pedido (
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
                            )';
                $params = [
                    ':id_pedido' => $data['id_pedido'],
                    ':id_presentacion' => $data['id_presentacion'],
                    ':cantidad' => $data['cantidad'],
                    ':precioVenta' => $data['precioVenta'],
                    ':subtotal' => $data['subtotal']
                ];

                return $respuesta = $db->execute($query, $params);
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

    }
    