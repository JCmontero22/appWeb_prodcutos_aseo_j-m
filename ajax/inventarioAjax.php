<?php
session_start();
require_once '../controller/inventarioController.php';

$accion = $_REQUEST['accion'] ?? null;
$inventarioCtrl = new inventarioController();

switch ($accion) {
    case 'listadoSedes':
        $respuesta = $inventarioCtrl->listarSedes();
        echo json_encode($respuesta);
        break;

    case 'inventarioPorSede':
        $idSede = $_POST['idSede'] ?? 0;
        $respuesta = $inventarioCtrl->obtenerInventario($idSede);
        echo json_encode($respuesta);
        break;

    case 'actualizarStock':
        $idSede = $_POST['idSede'] ?? 0;
        $idPresentacion = $_POST['idPresentacion'] ?? 0;
        $cantidad = $_POST['cantidad'] ?? 0;
        $costoUnitario = $_POST['costoUnitario'] ?? 0;

        $respuesta = $inventarioCtrl->actualizarStock($idSede, $idPresentacion, $cantidad, $costoUnitario);
        echo json_encode($respuesta);
        break;

    default:
        echo json_encode(['status' => 'error', 'mensaje' => 'Acción no válida']);
        break;
}
?>
