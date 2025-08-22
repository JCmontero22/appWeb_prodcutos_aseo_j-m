<?php

    require_once('../controller/registroClientesController.php');

    if (isset($_POST['nombre']) && isset($_POST['telefono']) && isset($_POST['direccion'])) {
        
        $registroCliente = new registroClientesController($_POST['nombre'], $_POST['telefono'], $_POST['direccion']);
        $respuesta = $registroCliente->registrarCliente();
        echo json_encode($respuesta);
    }