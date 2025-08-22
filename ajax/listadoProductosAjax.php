<?php

    require_once('../controller/listadoProductosController.php');

    
    $listadoProductos = new listadoProductosController();

    $resultado = $listadoProductos->listadoProductos();

    echo json_encode($resultado);