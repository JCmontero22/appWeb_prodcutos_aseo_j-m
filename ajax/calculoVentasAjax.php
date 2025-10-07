<?php 
    
    require_once('../controller/calculosVentasMensualController.php');
    require_once('../controller/calculosVentasTotalesController.php');


    $pantalla =  $_GET['pantalla'];
    
    if ($pantalla == 1) {
        $calculosVentasMensual = new calculosVentasMensualController();
        $respuesta = $calculosVentasMensual->calculoVentasMensuales();
        echo json_encode($respuesta);
    }else{
        $calculosVentasTotales = new calculosVentasTotalesController();
        $respuesta = $calculosVentasTotales->calculoVentasTotales();
        echo json_encode($respuesta);
    }

    

    

    

    