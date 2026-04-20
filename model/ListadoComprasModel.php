<?php

    require_once('../core/conexion.php');

    class ListadoComprasModel extends conexion{

        public function get_listadoCompras($sedId = 0){
            
            try {
                $db = new Conexion();
            
                $query = "SELECT * FROM compras AS c
                            INNER JOIN tipos_de_pago AS tdp ON c.id_tipo_de_pago = tdp.id_tipo_de_pago
                            INNER JOIN sedes AS s ON c.id_sede = s.id_sede";
                            
                if ($sedId > 0) {
                    $query .= " WHERE c.id_sede = :id_sede";
                }

                $params = [];
                if ($sedId > 0) {
                    $params['id_sede'] = $sedId;
                }

                $respuesta = $db->select($query, $params);

                return $respuesta;   
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function get_detalleCompra($idCompra) {
            try {
                $db = new Conexion();

                $query = "SELECT dc.*, p.nombre_produto, c.tamano_presentacion, c.precio_venta_jm_presentacion, c.precio_venta_cliente_presentacion FROM detalle_compra AS dc
                            INNER JOIN presentacion_producto AS c ON dc.id_presentacion = c.id_presentacion
                            INNER JOIN productos AS p ON c.id_producto = p.id_producto
                            WHERE dc.id_compra = :id_compra";

                $params = ['id_compra' => $idCompra];

                $respuesta = $db->select($query, $params);

                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function get_obtenerCompra($idCompra) {
            try {
                $db = new Conexion();

                $query = "SELECT * FROM compras AS c
                            INNER JOIN detalle_compra AS dc ON c.id_compra = dc.id_compra
                            INNER JOIN tipos_de_pago AS tdp ON c.id_tipo_de_pago = tdp.id_tipo_de_pago
                            INNER JOIN sedes AS s ON c.id_sede = s.id_sede
                            INNER JOIN presentacion_producto AS pp ON dc.id_presentacion = pp.id_presentacion
                            INNER JOIN productos AS pr ON pp.id_producto = pr.id_producto
                            WHERE c.id_compra = :id_compra";

                $params = ['id_compra' => $idCompra];

                $respuesta = $db->select($query, $params);

                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    