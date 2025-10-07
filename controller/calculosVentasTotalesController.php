<?php 

    require_once('../model/calculosVentasTotalesModel.php');

    class calculosVentasTotalesController extends calculosVentasTotalesModel
    {
        public function calculoVentasTotales(){
            try {
                $calculos = $this->get_calculosVentasTotales();
                return $respuesta = ['status' => 'success', 'mensaje' => 'Calculos realizados', 'data' => $calculos];
            } catch (\Exception $e) {
                return ['status' => 'error', 'mensaje' => $e->getMessage()];
            }
        }
    }
    