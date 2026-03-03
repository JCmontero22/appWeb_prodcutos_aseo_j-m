<?php 

    require_once('../core/conexion.php');

    class TotalesMovimientosFinancierosModel 
    {
        public function get_totalesMovimientosFinancieros(){
            try {
                $bd = new Conexion();

                $filtro = "";
                $filtro = " AND fecha_registro_movimiento_financiero > '2026-03-02'  ";    
                

                $query = "SELECT 
                            (SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 1 $filtro) AS total_ingresos,
                            (SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 2 $filtro) AS total_egresos,
                            ((SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 1 $filtro) - 
                            (SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 2 $filtro)) AS total_diferencia
                        ";
                $respuesta = $bd->select($query);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
            

        }
    }
    