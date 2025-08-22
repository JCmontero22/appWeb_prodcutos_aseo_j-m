<?php 

    require_once('../model/registroClienteModel.php');

    class registroClientesController extends registroClienteModel
    {

        private $nombre;
        private $telefono;
        private $direccion;

        public function __construct($nombre = "", $telefono = "", $direccion = "") {
            $this->nombre = $nombre;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
        }

        public function registrarCliente(){

            try {
                $data = array(
                    'nombre' => $this->nombre,
                    'telefono' => $this->telefono,
                    'direccion' => $this->direccion
                );

                $registroCliente = $this->set_registrarUsuario($data);
                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Usuario registrado exitosamente',
                    'data' => $registroCliente
                ];

                
            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => 'Error al registrar usuario',
                    'error' => $e->getMessage()
                ];
                
            }
        }
    }
    