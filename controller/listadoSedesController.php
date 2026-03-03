<?php 
    require_once('../model/ListadoSedesModel.php');
    
    class listadoSedesController extends ListadoSedesModel{
    
        public function listarSedes(){
            try {
                $response = $this->get_listadoSedes();
                return $respuesta = ['status' => 'success', 'mensaje' => 'Listado de sedes', 'data' => $response];
            } catch (\Exception $e) {
                return ['status' => 'error', 'mensaje' => $e->getMessage()];
            }
        }

    }