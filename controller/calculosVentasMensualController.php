<?php 

    require_once('../model/calculosVentasMensualModel.php');

    class calculosVentasMensualController extends calculosVentasMensualModel
    {
        public function calculoVentasMensuales(){
            try {
                $calculos = $this->get_calculosVentasMensual();
                return $respuesta = ['status' => 'success', 'mensaje' => 'Calculos realizados', 'data' => $calculos];
            } catch (\Exception $e) {
                return ['status' => 'error', 'mensaje' => $e->getMessage()];
            }
        }
    }
    