<?php 

    require_once('../model/LoginModel.php');

    class LoginController extends LoginModel
    {

        private $usuario;
        private $password;

        public function __construct($user = null, $pass = null) {
            $this->usuario = $user;
            $this->password = $pass;
        }

        public function login(){
            try {
                $respuesta = $this->loginModel($this->usuario, $this->password);

                if ($respuesta) {

                    $this->iniciarSesion($respuesta[0]);

                    return [
                        'status' => 'success',
                        'message' => 'Bienvenido ' . $this->usuario,
                        'data' => $respuesta
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'message' => 'Credenciales incorrectas',
                    'error' => $e->getMessage()
                ];
            }
            
            
        }

        private function iniciarSesion($dataUsuario){
            
            session_start();
            $_SESSION['id'] = $dataUsuario['id_usuario'];
            $_SESSION['user'] = $dataUsuario['user_usuario'];
            $_SESSION['nombre'] = $dataUsuario['nombre_usuario'];
            $_SESSION['rol'] = $dataUsuario['id_rol'];
        }
    }
