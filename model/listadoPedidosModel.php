<?php

    require_once('../core/conexion.php');

    class listadoPedidosModel 
    {
        public function get_listadoPedidos($idUsuario, $idRol)
        {
            $db = new Conexion();
            $where = $idRol == 2 ? "AND p.id_usuario = :idUsuario" : "";
            $query = "SELECT 
                            p.id_pedidos AS idPedido, 
                            u.nombre_usuario AS cliente, 
                            u.telefono_usuario AS telefono,
                            u.direccion_usuario AS direccion,
                            p.valor_total_pedido AS totalVenta,  
                            p.ganancia_total_pedido AS totalGanancia,
                            p.fecha_pedido AS fechaPedido,
                            p.fecha_entrega_pedido AS fechaEntrega,
                            e.nombre_estado AS estado
                        FROM 
                            pedidos p
                        INNER JOIN usuarios u ON p.id_cliente = u.id_usuario
                        INNER JOIN estados_pedido e ON p.id_estado = e.id_estado_pedido
                        WHERE 1=1 $where
                        ORDER BY p.id_pedidos DESC";

            
            if ($idRol == 2) {
                 $params = [':idUsuario' => $idUsuario];
                 $respuesta = $db->select($query, $params);
            }else{
                $respuesta = $db->select($query);
            }

            return $respuesta;
        }
    }
    