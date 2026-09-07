<?php

    session_start();
    require_once('../core/conexion.php');


    class ListadoVentasModel 
    {

        public function get_listadoVentas($idUsuario, $idRol, $admin, $filtro, $sedeId){

            try {
                $db = new Conexion();

                $query = "SELECT
                                p.id_pedidos AS idPedido,
                                u.nombre_usuario AS cliente,
                                u.telefono_usuario AS telefono,
                                u.direccion_usuario AS direccion,
                                p.valor_total_pedido AS totalVenta,
                                p.ganancia_total_pedido AS totalGanancia,
                                p.fecha_pedido AS fechaPedido,
                                p.fecha_entrega_pedido AS fechaEntrega,
                                e.nombre_estado AS estado,
                                e.id_estado_pedido AS idEstado,
                                p.valor_total_pedido - p.costo_total_pedido AS gananciaAdmin,
                                ve.nombre_usuario AS vendedor,
                                s.nombre_sede AS sede,
                                tp.nombre_tipo_de_pago AS medioPago
                            FROM pedidos p
                            INNER JOIN usuarios u ON p.id_cliente = u.id_usuario
                            INNER JOIN usuarios ve ON p.id_usuario = ve.id_usuario
                            INNER JOIN estados_pedido e ON p.id_estado = e.id_estado_pedido
                            INNER JOIN sedes s ON ve.id_sede = s.id_sede
                            LEFT JOIN tipos_de_pago tp ON tp.id_tipo_de_pago = p.id_tipo_de_pago
                            WHERE 1=1";

                $params = [];

                if ($idRol == 2 || $admin == 1) {
                    $query .= " AND p.id_usuario = :idUsuario";
                    $params[':idUsuario'] = $idUsuario;
                }

                $query .= ($filtro == 1) ? " AND p.fecha_pedido < '2026-03-06'" : " AND p.fecha_pedido >= '2026-03-06'";

                if ($sedeId != 0) {
                    $query .= " AND s.id_sede = :sede_id";
                    $params[':sede_id'] = (int)$sedeId;
                } else {
                    $query .= " AND s.id_sede = :sede_id";
                    $params[':sede_id'] = (int)$_SESSION['sede'];
                }

                $query .= " ORDER BY p.id_pedidos DESC";

                $respuesta = $db->select($query, $params);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    