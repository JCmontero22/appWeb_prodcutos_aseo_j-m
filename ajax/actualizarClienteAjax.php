<?php 

    require_once('../controller/actualizarClienteController.php');
    
    
        $actualizarCliente = new actualizarClienteController($_POST['data']);
        $respuesta = $actualizarCliente->actualizarCliente();
        echo json_encode($respuesta);
    