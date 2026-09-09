<?php
session_start();
require_once '../config/configDB.php';
require_once '../config/Database.php';
require_once '../core/Validador.php';
require_once '../model/InventarioPorSedeModel.php';

$accion = $_REQUEST['accion'] ?? null;
$inventarioModel = new InventarioPorSedeModel();

switch ($accion) {
    case 'listadoSedes':
        $sedes = $inventarioModel->obtenerSedes();
        echo json_encode(['status' => 'success', 'data' => $sedes]);
        break;

    case 'inventarioPorSede':
        $idSede = Validador::validarID($_POST['idSede'] ?? 0);

        if (!$idSede) {
            echo json_encode(['status' => 'error', 'mensaje' => 'Sede inválida']);
            break;
        }

        $inventario = $inventarioModel->obtenerInventarioPorSede($idSede);
        echo json_encode(['status' => 'success', 'data' => $inventario]);
        break;

    case 'actualizarStock':
        $idSede = Validador::validarID($_POST['idSede'] ?? 0);
        $idPresentacion = Validador::validarID($_POST['idPresentacion'] ?? 0);
        $cantidad = Validador::validarCantidad($_POST['cantidad'] ?? 0);
        $costoUnitario = Validador::validarPrecio($_POST['costoUnitario'] ?? 0);

        if (!$idSede || !$idPresentacion || $cantidad === false || $costoUnitario === false) {
            echo json_encode(['status' => 'error', 'mensaje' => 'Datos inválidos']);
            break;
        }

        $result = $inventarioModel->actualizarStock($idSede, $idPresentacion, $cantidad, $costoUnitario);

        if ($result) {
            echo json_encode(['status' => 'success', 'mensaje' => 'Stock actualizado correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'mensaje' => 'Error al actualizar el stock']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'mensaje' => 'Acción no válida']);
        break;
}
?>
