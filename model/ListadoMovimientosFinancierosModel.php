<?php 

    require_once('../core/conexion.php');

    class ListadoMovimientosFinancierosModel 
    {
        /* READ - listado completo */
        protected function get_listadoMovimientosFinancieros($data) {
            try {
                $db = new Conexion();
                
                $filtro = "";
                $data == 1 ? $filtro = " WHERE mf.fecha_registro_movimiento_financiero <= '2026-03-03'  " : $filtro = " WHERE mf.fecha_registro_movimiento_financiero > '2026-03-03'  ";

                $sql = "SELECT 
                            mf.id_movimiento_financiero AS id,
                            mf.fecha_registro_movimiento_financiero AS fecha,
                            cf.nombre_categoria_financiera AS tipo,
                            mf.descripcion_movimiento_financiero AS descripcion,
                            mf.monto_movimiento_financiero AS monto,
                            mf.referencia_movimiento_financiero AS refencia,
                            u.nombre_usuario AS usuario,
                            s.nombre_sede AS sede
                        FROM movimientos_financieros mf
                        INNER JOIN categorias_financieras cf ON mf.categoria_financiera = cf.id_categoria_financiera
                        INNER JOIN usuarios u ON mf.id_usuario = u.id_usuario
                        INNER JOIN sedes s ON s.id_sede = u.id_sede
                        $filtro
                        ORDER BY mf.id_movimiento_financiero ASC";
                
                $respuesta = $db->select($sql);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    