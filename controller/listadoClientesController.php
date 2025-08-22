<?php 

    require_once('../model/listadoClientesModel.php');

    class listadoClientesController extends listadoClientesModel
    {
        public function listarClientes()
        {
            try {
                $clientes = $this->get_listarClientes();
                
                if (!$clientes) {
                    return [
                        'status' => 'error',
                        'mensaje' => 'No se encontraron clientes'
                    ];
                }
                
                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Listado de clientes obtenido correctamente',
                    'data' => $clientes
                ];

            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => 'Error al obtener el listado de clientes',
                    'error' => $e->getMessage()
                ];
            }
            
            
        }
    }
