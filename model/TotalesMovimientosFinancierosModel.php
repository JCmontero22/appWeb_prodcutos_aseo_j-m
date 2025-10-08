<?php 

    require_once('../core/conexion.php');

    class TotalesMovimientosFinancierosModel 
    {
        public function get_totalesMovimientosFinancieros(){
            try {
                $bd = new Conexion();

                $query = "SELECT 
                            (SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 1) AS total_ingresos,
                            (SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 2) AS total_egresos,
                            ((SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 1) - 
                             (SELECT IFNULL(SUM(monto_movimiento_financiero), 0) FROM movimientos_financieros WHERE categoria_financiera = 2)) AS total_diferencia
                        ";
                $respuesta = $bd->select($query);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
            

        }
    }
    