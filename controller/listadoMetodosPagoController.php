<?php 
    require_once('../model/ListadoMetodosPagoModel.php');
    
    class listadoMetodosPagoController extends ListadoMetodosPagoModel{
    
        public function listarMetodosPago(){
            try {
                $response = $this->get_listadoMetodosPago();
                return $respuesta = ['status' => 'success', 'mensaje' => 'Listado de métodos de pago', 'data' => $response];
            } catch (\Exception $e) {
                return ['status' => 'error', 'mensaje' => $e->getMessage()];
            }
        }

    }