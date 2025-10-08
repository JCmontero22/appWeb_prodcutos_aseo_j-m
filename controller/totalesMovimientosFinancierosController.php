<?php 

    require_once('../model/TotalesMovimientosFinancierosModel.php');

    class totalesMovimientosFinancierosController extends TotalesMovimientosFinancierosModel
    {
        public function obtenerTotalesMovimientosFinancieros()
        {
            $respuesta = [];

            try {
                $resultadoTotales = $this->get_totalesMovimientosFinancieros();

                for ($i=0; $i < count($resultadoTotales); $i++) { 
                    $data[] = [
                        'total_ingresos' => number_format($resultadoTotales[$i]['total_ingresos'], 0, ',', '.'),
                        'total_egresos' => number_format($resultadoTotales[$i]['total_egresos'], 0, ',', '.'),
                        'total_diferencia' => number_format($resultadoTotales[$i]['total_diferencia'], 0, ',', '.'),
                    ];
                }

                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Totales de movimientos financieros obtenido correctamente',
                    'data' => $data
                ];
            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }
        }
    }
    