<?php 

    require_once('../core/conexion.php');

    class registroClienteModel 
    {
        protected function set_registrarUsuario($data){
            try {
                $db = new conexion();

                $query = "INSERT INTO usuarios (
                                nombre_usuario, 
                                telefono_usuario, 
                                direccion_usuario,
                                id_rol
                            ) 
                            VALUES (
                                :nombre, 
                                :telefono, 
                                :direccion,
                                :idRol
                            )";

                $params = array(
                    ':nombre' => $data['nombre'],
                    ':telefono' => $data['telefono'],
                    ':direccion' => $data['direccion'],
                    ':idRol' => 3
                );

                $respuesta = $db->execute($query, $params);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
                
            }

            
        }
    }
    