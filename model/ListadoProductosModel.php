<?php 

    require_once('../core/conexion.php');

    class ListadoProductosModel
    {
        
        protected function get_listadoProdcutos()
        {
            $db = new Conexion();

            $sql = "SELECT 
                        pr.id_producto AS id, 
                        pr.nombre_produto AS nombre, 
                        ps.tamano_presentacion AS presentacion, 
                        ps.stock_disponible_presentacion AS cantidad, 
                        ps.precio_venta_cliente_presentacion AS presioVenta,
                        ps.id_presentacion AS idPresentacion,
                        ps.precio_compra_presentacion AS precioCompra,
                        ps.precio_venta_jm_presentacion AS precioVentaJM

                    FROM productos pr 
                    INNER JOIN presentacion_producto ps on ps.id_producto  = pr.id_producto
                    ORDER BY pr.id_producto ASC";

            $respuesta = $db->select($sql);

            if ($respuesta) {
                return $respuesta;
            } else {
                throw new Exception("No se encontraron productos");
            }
        }
    }