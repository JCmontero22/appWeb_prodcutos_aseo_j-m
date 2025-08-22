<?php 

    require_once('../core/conexion.php');


    class LoginModel{

        protected function loginModel($user, $pass){
            $db = new conexion();
            $query = "SELECT * FROM usuarios WHERE user_usuario = :user";
            $params = [':user' => $user];
            $respuesta = $db->select($query, $params);

            if ($respuesta && password_verify($pass, $respuesta[0]['password_usuario'])) {
                return $respuesta;
            } else {
                throw new Exception("Las credenciales son incorrectas");
            }
        }
    }
    


?>