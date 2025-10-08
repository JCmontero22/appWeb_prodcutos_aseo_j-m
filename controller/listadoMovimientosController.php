<?php 

    require_once('../model/ListadoMovimientosFinancierosModel.php');

    class listadoMovimientosController extends ListadoMovimientosFinancierosModel
    {

        public function obtenerListadoMovimientos() {
            $respuesta = [];

            try {
                $resultadoMovimientos = $this->get_listadoMovimientosFinancieros();
                for ($i=0; $i < count($resultadoMovimientos); $i++) { 
                    $data[] = [
                        'id' => $resultadoMovimientos[$i]['id'],
                        'fecha' => $resultadoMovimientos[$i]['fecha'],
                        'tipo' => $resultadoMovimientos[$i]['tipo'],
                        'descripcion' => $resultadoMovimientos[$i]['descripcion'],
                        'monto' => number_format($resultadoMovimientos[$i]['monto'], 0, ',', '.'),
                        'refencia' => $resultadoMovimientos[$i]['refencia'],
                        'usuario' => $resultadoMovimientos[$i]['usuario'],
                    ];
                }

                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Listado de movimientos financieros obtenido correctamente',
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
    