<?php 

    require_once('../core/conexion.php');

    class calculosVentasTotalesModel 
    {
        protected function get_calculosVentasTotales(){
            try {
                $db = new Conexion();
                $query = "SELECT
                            -- Ganancias de J&M (usuario 1)
                            SUM(CASE WHEN p.id_usuario = 1 AND p.id_estado = 6
                                    THEN (valor_total_pedido - costo_total_pedido)
                                    ELSE 0 END) AS gananciasPorJM,

                            -- Ganancias de ventas (otros usuarios)
                            SUM(CASE WHEN p.id_usuario != 1 AND p.id_estado = 6
                                    THEN (valor_total_pedido - costo_total_pedido - p.ganancia_total_pedido)
                                    ELSE 0 END) AS gananciasDeVentas,

                            -- Total vendido (de todos los usuarios)
                            SUM(CASE WHEN p.id_estado = 6
                                    THEN (valor_total_pedido)
                                    ELSE 0 END) AS totalVendido,

                            -- Costo total vendido (de todos los usuarios)
                            SUM(CASE WHEN p.id_estado = 6
                                    THEN costo_total_pedido
                                    ELSE 0 END) AS totalCostoVendido,

                            -- Total dinero en cuenta.
                            SUM(CASE
                                    WHEN p.id_usuario != 1 AND p.id_estado = 6
                                        THEN (valor_total_pedido - p.ganancia_total_pedido)
                                    WHEN p.id_usuario = 1 AND p.id_estado = 6
                                        THEN (valor_total_pedido)
                                    ELSE 0
                                END
                            ) AS total

                            FROM pedidos p";

                $respuesta = $db->select($query);
                
                return $respuesta;

            }catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    

    /*  -- Total vendido (solo resta ganancia_total_pedido si id_usuario != 6)
  SUM(CASE 
        WHEN p.id_estado = 6 AND p.id_usuario = 6 THEN valor_total_pedido
        WHEN p.id_estado = 6 AND p.id_usuario != 6 THEN (valor_total_pedido - p.ganancia_total_pedido)
        ELSE 0
      END) AS totalVendido, */