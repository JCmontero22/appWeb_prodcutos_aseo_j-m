<?php 

    require_once('../controller/registroPedidoController.php');
    require_once('../controller/listadoPedidosController.php');
    require_once('../controller/detallePedidoController.php');
    require_once('../controller/editarEstadoPedidoController.php');
    require_once('../controller/actualizarPedidoController.php');
    require_once('../controller/eliminarDetallePedidoController.php');
    require_once('../controller/calculoVentasEntregadasController.php');
    require_once('../controller/finalizarPedidosController.php');
    require_once('../controller/AgregarPoductoAlPedidoController.php');

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

        case 'actualizarPedido':
            $actualizarPedido = new actualizarPedidoController($_POST['cantidad'], $_POST['idDetallePedido'], $_POST['idPedido']);
            $respuesta = $actualizarPedido->actualizarPedido();
            echo json_encode($respuesta);
            break;

        case 'eliminarProducto':
            $eliminarProducto = new eliminarDetallePedidoController($_POST['idDetallePedido']);
            $respuesta = $eliminarProducto->eliminarDetallePedido();
            echo json_encode($respuesta);
            break;

        case 'calculoVentas':
            $eliminarProducto = new calculoVentasEntregadasController();
            $respuesta = $eliminarProducto->calculoVentaEntregada();
            echo json_encode($respuesta);
            break;

        case 'finalizarPedidos':
            $finalizarPedidos = new finalizarPedidosController();
            $respuesta = $finalizarPedidos->finalizarPedido();
            echo json_encode($respuesta);
            break;

        case 'agregarProducto':
            $finalizarPedidos = new AgregarPoductoAlPedidoController($_POST['idPedido'], $_POST['idPresentacion'], $_POST['cantidad'], $_POST['total'], $_POST['precioVenta']);
            $respuesta = $finalizarPedidos->agregarProducto();
            echo json_encode($respuesta);
            break;

            

        default:
            echo json_encode(['error' => 'Acción no válida']);
    }