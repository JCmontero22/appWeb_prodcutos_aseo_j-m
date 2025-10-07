<?php 

    require_once('../core/conexion.php');

    class calculosVentasMensualModel 
    {
        protected function get_calculosVentasMensual(){
            try {
                $db = new Conexion();
                $query = "SELECT
                            -- Ganancias de J&M (usuario 6)
                            SUM(CASE WHEN p.id_usuario = 6 AND p.id_estado = 6
                                    THEN (valor_total_pedido - costo_total_pedido)
                                    ELSE 0 END) AS gananciasPorJM,

                            -- Ganancias de ventas (otros usuarios)
                            SUM(CASE WHEN p.id_usuario != 6 AND p.id_estado = 6
                                    THEN (valor_total_pedido - costo_total_pedido - p.ganancia_total_pedido)
                                    ELSE 0 END) AS gananciasDeVentas,

                            -- Total vendido (de todos)
                            SUM(CASE WHEN p.id_estado = 6
                                    THEN (valor_total_pedido - p.ganancia_total_pedido)
                                    ELSE 0 END) AS totalVendido,

                            -- Costo total vendido
                            SUM(CASE WHEN p.id_estado = 6
                                    THEN costo_total_pedido
                                    ELSE 0 END) AS totalCostoVendido

                            FROM pedidos p
                            WHERE YEAR(p.fecha_pedido) = YEAR(CURDATE())
                            AND MONTH(p.fecha_pedido) = MONTH(CURDATE())";
                
                $respuesta = $db->select($query);
                
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    