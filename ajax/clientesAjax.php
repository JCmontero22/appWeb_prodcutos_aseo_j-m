<?php 

    require_once('../controller/listadoClientesController.php');

    $listadoClientes = new listadoClientesController();
    echo json_encode($listadoClientes->listarClientes());
