<?php 
    
    session_start();
    require_once('../core/conexion.php');
    class ListadoProductosModel
    {
        
        protected function get_listadoProdcutos($sedId = 0)
        {
            try {
                $db = new Conexion();

                // Usar prepared statement para evitar inyección SQL
                $sql = "SELECT
                            pr.id_producto AS id,
                            pr.nombre_produto AS nombre,
                            ps.tamano_presentacion AS presentacion,
                            ssp.cantidad_stock_presentacion_sede AS cantidad,
                            ps.precio_venta_cliente_presentacion AS presioVenta,
                            ps.id_presentacion AS idPresentacion,
                            ps.precio_compra_presentacion AS precioCompra,
                            ps.precio_venta_jm_presentacion AS precioVentaJM,
                            ssp.stock_minimo_stock_presentacion_sede cantidadMinima,
                            (ps.precio_compra_presentacion * ssp.cantidad_stock_presentacion_sede) AS valorStock

                        FROM productos pr
                        INNER JOIN presentacion_producto ps on ps.id_producto = pr.id_producto
                        INNER JOIN stock_sede_presentacion ssp on ssp.id_presentacion = ps.id_presentacion
                        WHERE ssp.id_sede = :sede_id AND ps.estado = 1
                        ORDER BY pr.id_producto ASC";

                $sedeId = ($sedId != 0) ? (int)$sedId : (int)$_SESSION['sede'];

                $params = [':sede_id' => $sedeId];
                $respuesta = $db->select($sql, $params);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }   