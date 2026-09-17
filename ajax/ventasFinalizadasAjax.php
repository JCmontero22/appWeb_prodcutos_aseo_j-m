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

    default:
        echo json_encode(['status' => 'error', 'mensaje' => 'Acción no válida']);
        break;
}
?>
