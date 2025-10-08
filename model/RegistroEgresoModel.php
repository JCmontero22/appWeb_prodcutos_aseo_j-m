<?php 

    require_once('../core/conexion.php');

    class RegistroEgresoModel
    {
        protected function set_registroEgreso($data){

            try {
                $db = new Conexion();

                $query = "INSERT INTO movimientos_financieros (
                                categoria_financiera,
                                descripcion_movimiento_financiero, 
                                monto_movimiento_financiero, 
                                fecha_registro_movimiento_financiero, 
                                referencia_movimiento_financiero, 
                                id_usuario
                            ) VALUES (
                                2,
                                :descripcion,
                                :monto,
                                NOW(),
                                :referencia,
                                :idUsuario
                            )";
                $parametros = array(
                    ':descripcion' => $data['descripcion'],
                    ':monto' => $data['monto'],
                    ':referencia' => $data['referencia'],
                    ':idUsuario' => $data['idUsuario']
                );

                $respuesta = $db->execute($query, $parametros);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
            
        }
    }
    