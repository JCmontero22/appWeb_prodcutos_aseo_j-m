<?php 

    session_start();

    require_once('../model/CalculoVentasEntregadasModel.php');

    class calculoVentasEntregadasController extends CalculoVentasEntregadasModel
    {
        function calculoVentaEntregada(){
            try {
                $idUsuario = $_SESSION['id'];
                
                $respuesta = $this->get_calculoVentasEntregadas($idUsuario);
                return [
                    'status' => 'success',
                    'mensaje' => 'Datos obtenidos correctamente',
                    'data' => $respuesta
                ];
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'mensaje' => 'Error al obtener los datos',
                    'data' => $e->getMessage()
                ];
            }
        }
    }
    