<?php 

    require_once('../core/conexion.php');

    class FinalizarPedidosModel 
    {
        protected function set_finalizarPedidos($idUsuario){

            try {
                $db = new Conexion();

                $query = "UPDATE pedidos SET id_estado = 6 WHERE id_usuario = :idUsuario AND id_estado = 4";

                $respuesta = $db->execute($query, [':idUsuario' => $idUsuario]);

                return $respuesta;

            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }

            
        }
    }
    