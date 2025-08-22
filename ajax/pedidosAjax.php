<?php 

    require_once('../controller/registroPedidoController.php');
    require_once('../controller/listadoPedidosController.php');
    require_once('../controller/detallePedidoController.php');
    require_once('../controller/editarEstadoPedidoController.php');

    $accion = isset($_GET['accion']) ? $_GET['accion'] :  $_POST['accion'];
    
    switch ($accion) {
        case 'realizarPedido':
            $registroProducto = new RegistroPedidoController($_POST['cliente'], $_POST['productos'], $_POST['totalVenta']);
            $respuesta = $registroProducto->registrarPedido();
            echo json_encode($respuesta);
            break;
        case 'listadoPedidos':
            $listadoPedidos = new ListadoPedidosController();
            echo json_encode($listadoPedidos->listarMisPedidos());
            break;
        
        case 'detallePedido':
            $registroProducto = new detallePedidoController($_GET['idPedido']);
            $respuestaDetalle = $registroProducto->detallePedido();
            echo json_encode($respuestaDetalle);
            break;


        case 'actualizarEstado':
            $actualizarEstadoPedido = new editarEstadoPedidoController($_POST['idPedido'], $_POST['estado']);
            $respuestaDetalle = $actualizarEstadoPedido->actualizarEstadoPedido();
            echo json_encode($respuestaDetalle);
            break;

        

        default:
            echo json_encode(['error' => 'Acción no válida']);
    }