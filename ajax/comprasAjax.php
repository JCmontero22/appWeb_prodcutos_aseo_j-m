<?php 

    session_start();
    require_once('../controller/registroCompraController.php');
    require_once('../controller/listadoComprasController.php');

    $accion = isset($_GET['accion']) ? $_GET['accion'] :  $_POST['accion'];

    switch ($accion) {
        case 'registrarCompra':
            $registroCompra = new RegistroCompraController($_POST['proveedor'], $_POST['numFactura'], $_POST['idSede'], $_POST['tipoPago'], $_POST['descripcion'], $_POST['total'], $_POST['detalles']);
            $respuesta = $registroCompra->registrarCompra();
            echo json_encode($respuesta);
            break;
        
        case 'listadoCompras':
            $listadoCompras = new ListadoComprasController();
            $respuesta = $listadoCompras->listadoCompras();
            echo json_encode($respuesta);
            break;

        case 'detalleCompra':
            $listadoCompras = new ListadoComprasController();
            $respuesta = $listadoCompras->detalleCompra($_GET['idCompra']);
            echo json_encode($respuesta);
            break;
        
        default:
            echo json_encode(['status' => 'error', 'mensaje' => 'Acción no válida.']);
            break;
    }