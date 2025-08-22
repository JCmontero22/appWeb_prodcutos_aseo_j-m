<?php 

    require_once('../controller/loginController.php');
    
    if(isset($_POST['user']) && isset($_POST['pass'])){
        $usuario = $_POST['user'];
        $contrasena = $_POST['pass'];

        $login = new LoginController($usuario, $contrasena);
        $respuesta = $login->login();
        
        echo json_encode($respuesta);
    }

?>