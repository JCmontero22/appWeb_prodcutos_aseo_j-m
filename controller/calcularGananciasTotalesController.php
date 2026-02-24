<?php 

    require_once('../model/calcularGananciasTotalesModel.php');
    session_start();

    class calcularGananciasTotalesController extends calcularGananciasTotalesModel
    {
        function calcularGanancias()  {
            try {
                $resultadoGanancias = $this->get_gananciasTotales($_SESSION['id']);
                
                if (empty($resultadoGanancias)) {
                    return [
                        'status' => 'error',
                        'mensaje' => 'No se encontraron pedidos.',
                        'data' => []
                    ];
                }

                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Ganancias obtenidas correctamente',
                    'data' => $resultadoGanancias
                ];
            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => $e->getMessage(),
                    'data' => []
                ];
            }
        }
    }
    