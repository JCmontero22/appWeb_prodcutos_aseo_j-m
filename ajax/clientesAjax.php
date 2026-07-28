<?php 

    echo "PASO 1<br>";

    require_once('../controller/listadoClientesController.php');

    echo "PASO 2<br>";

    exit;

    $listadoClientes = new listadoClientesController();
    echo json_encode($listadoClientes->listarClientes());
