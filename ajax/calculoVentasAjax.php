<?php 
    
    require_once('../controller/calculosVentasMensualController.php');
    require_once('../controller/calculosVentasTotalesController.php');


    $pantalla =  $_GET['pantalla'];
    $tipoConsulta = $_GET['tipoConsulta'];
    
    if ($pantalla == 1) {
        $calculosVentasMensual = new calculosVentasMensualController();
        $respuesta = $calculosVentasMensual->calculoVentasMensuales($tipoConsulta);
        echo json_encode($respuesta);
    }else{
        $calculosVentasTotales = new calculosVentasTotalesController($tipoConsulta);
        $respuesta = $calculosVentasTotales->calculoVentasTotales($tipoConsulta);
        echo json_encode($respuesta);
    }

    

    

    

    