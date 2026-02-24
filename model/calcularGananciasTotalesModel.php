<?php 

    require_once('../core/conexion.php');

    class calcularGananciasTotalesModel {
        
        protected function get_gananciasTotales($id_usuario) {

            $db = new Conexion();
            
            $query = "SELECT SUM(ganancia_total_pedido) AS ganancias FROM pedidos WHERE id_usuario = " . $id_usuario . " AND id_estado = 6";

            $respuesta = $db->select($query);
            return $respuesta;
            
        }
    }
    