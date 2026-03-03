<?php

    require_once('../core/conexion.php');

    class ListadoSedesModel 
    {

        public function get_listadoSedes(){
            
            try {
                $db = new Conexion();
            
                $query = "SELECT * FROM sedes";

                $respuesta = $db->select($query);

                return $respuesta;   
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    