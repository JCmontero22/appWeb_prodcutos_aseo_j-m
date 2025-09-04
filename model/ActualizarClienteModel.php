<?php 

    require_once('../core/conexion.php');

    class ActualizarClienteModel 
    {
        protected function set_actualizarDataCliente($data) {
            try {
                $db = new Conexion();

                $update = "UPDATE usuarios 
                            SET nombre_usuario = :nombre, 
                                telefono_usuario = :telefono, 
                                direccion_usuario = :direccion
                            WHERE id_usuario = :id_usuario";
                $respuesta = $db->execute($update, [
                    ':nombre' => $data['nombre'],
                    ':telefono' => $data['telefono'],
                    ':direccion' => $data['direccion'],
                    ':id_usuario' => $data['id_usuario']
                ]);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    