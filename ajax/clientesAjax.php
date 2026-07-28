<?php

require_once('../controller/listadoClientesController.php');

$listadoClientes = new listadoClientesController();

$resultado = $listadoClientes->listarClientes();

foreach ($resultado['data'] as $indice => $cliente) {

    if (json_encode($cliente) === false) {

        echo "Cliente con error: $indice <br>";
        echo "ID: ".$cliente['id_usuario']."<br>";
        echo "Nombre: ".$cliente['nombre_usuario']."<br>";
        echo json_last_error_msg();

        exit;
    }

}

echo "Todos los clientes son válidos";