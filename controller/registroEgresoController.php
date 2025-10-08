<?php 

    require_once('../model/RegistroEgresoModel.php');

    class registroEgresoController extends RegistroEgresoModel 
    {
        
        private $monto;
        private $referencia;
        private $descripcion;

        public function __construct($monto, $referencia, $descripcion) {
            $this->monto = $monto;
            $this->referencia = $referencia;
            $this->descripcion = $descripcion;
        }

        public function registrarEgreso() {
            $respuesta = [];
            try {
                session_start();
                $data = [
                    'monto' => $this->monto,
                    'referencia' => $this->referencia,
                    'descripcion' => $this->descripcion,
                    'idUsuario' => $_SESSION['id']
                ];

                $resultado = $this->set_registroEgreso($data);

                if ($resultado) {
                    return $respuesta = [
                        'status' => 'success',
                        'mensaje' => 'Egreso registrado correctamente'
                    ];
                } else {
                    throw new Exception("Error al registrar el egreso");
                }

            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }
        }

    }
    