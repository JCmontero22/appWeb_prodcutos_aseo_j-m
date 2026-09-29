<?php
session_start();
require_once '../controller/VentasFinalizadasController.php';

$accion = $_REQUEST['accion'] ?? null;
$mes = $_REQUEST['mes'] ?? '';
$ventasCtrl = new VentasFinalizadasController();

switch ($accion) {
    case 'obtenerVentas':
        $respuesta = $ventasCtrl->obtenerVentas($mes);
        echo json_encode($respuesta);
        break;

    case 'marcarSeparado':
        $idPedido = $_REQUEST['id_pedidos'] ?? null;
        $valor = isset($_REQUEST['valor']) ? intval($_REQUEST['valor']) : 1;
        if (!$idPedido) {
            echo json_encode(['status' => 'error', 'mensaje' => 'ID de pedido faltante']);
            break;
        }
        $respuesta = $ventasCtrl->marcarSeparado($idPedido, $valor);
        echo json_encode($respuesta);
        break;

    default:
        echo json_encode(['status' => 'error', 'mensaje' => 'Acción no válida']);
        break;
}
?>
