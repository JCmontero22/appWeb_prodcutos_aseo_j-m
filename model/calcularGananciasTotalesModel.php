<?php 

    require_once('../core/conexion.php');

    class calcularGananciasTotalesModel {
        
        protected function get_gananciasTotales($id_usuario) {

            $db = new Conexion();
            
            $query = "SELECT 
                        SUM(
                            CASE 
                                WHEN id_usuario = IN (6, 11) THEN (valor_total_pedido - costo_total_pedido)
                                ELSE ganancia_total_pedido 
                            END
                        ) AS ganancia_total_global
                    FROM pedidos 
                    WHERE id_estado = 6 and id_usuario= $id_usuario;";

            $respuesta = $db->select($query);
            return $respuesta;
            
        }
    }
    