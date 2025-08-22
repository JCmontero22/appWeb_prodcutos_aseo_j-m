<?php 

    require_once('../core/conexion.php');

    class registroPedidoModel 
    {
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
                return $e->getMessage();    
            }
        }

    }
    