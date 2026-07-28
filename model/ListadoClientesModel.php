<?php 

    require_once('../core/conexion.php');


    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);

    file_put_contents(
        __DIR__ . '/debug.log',
        date('Y-m-d H:i:s') . " Entró al archivo\n",
        FILE_APPEND
    );

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
    
