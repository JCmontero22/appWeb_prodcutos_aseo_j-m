<?php 

    require_once('../model/ActualizarClienteModel.php');

    class actualizarClienteController extends ActualizarClienteModel
    {
        private $dataCliente;

        public function __construct($dataCliente) {
            $this->dataCliente = $dataCliente;
        }

        public function actualizarCliente() {
            try {
                $actualizar = $this->set_actualizarDataCliente($this->dataCliente);
                
                if ($actualizar) {
                    return $respuesta = [
                        'status' => 'success',
                        'mensaje' => 'Cliente actualizado correctamente'
                    ];
                }
            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => 'Error al actualizar el cliente',
                    'error' => $e->getMessage()
                ];
            }
        }
    }
    