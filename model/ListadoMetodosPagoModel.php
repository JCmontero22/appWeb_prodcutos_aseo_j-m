<?php

    require_once('../core/conexion.php');

    class ListadoMetodosPagoModel extends conexion{

        public function get_listadoMetodosPago(){
            
            try {
                $db = new Conexion();
            
                $query = "SELECT * FROM tipos_de_pago";

                $respuesta = $db->select($query);

                return $respuesta;   
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    