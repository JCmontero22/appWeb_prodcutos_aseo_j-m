<?php

    require_once('../controller/listadoProductosController.php');

    
    $listadoProductos = new listadoProductosController();

    $redId = isset($_GET['sedeId']) ? $_GET['sedeId'] : 0;
    $resultado = $listadoProductos->listadoProductos($redId);

    echo json_encode($resultado);