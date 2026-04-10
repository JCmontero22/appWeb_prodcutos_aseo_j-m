<?php

    require_once('../controller/listadoMetodosPagoController.php');

    
    $listadoMetodosPago = new listadoMetodosPagoController();

    $redId = isset($_GET['sedeId']) ? $_GET['sedeId'] : 0;
    $resultado = $listadoMetodosPago->listarMetodosPago($redId);

    echo json_encode($resultado);