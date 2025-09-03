<?php 

    require_once('../core/conexion.php');

    class CalculoVentasEntregadasModel 
    {
        protected function get_calculoVentasEntregadas($idUsuario) {

            try {
                $db = new conexion();

                $query = "SELECT 
                                (SUM(p.valor_total_pedido ) - SUM(p.ganancia_total_pedido )) AS enviar, 
                                SUM(p.ganancia_total_pedido ) AS ganancia
                            FROM  
                                pedidos p 
                            WHERE 
                                p.id_usuario = :idUsuario AND p.id_estado = 4   ORDER BY p.id_pedidos  desc";

                $resultado = $db->select($query, [':idUsuario' => $idUsuario]);    
                return $resultado;

            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }

            
        }
    }
    