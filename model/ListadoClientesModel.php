<?php 

    require_once('../core/conexion.php');

    class ListadoClientesModel 
    {
        protected function get_listarClientes() {      
            
            try {
                $db = new Conexion();
                $sql = "SELECT * FROM usuarios WHERE estado = 1 AND id_rol = 3";
                $respuesta = $db->select($sql);
                return $respuesta;                
            } catch (\Exception $e) {
                    throw new Exception($e->getMessage());
            }
            
            
        }
    }
    
