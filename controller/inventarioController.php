<?php

require_once '../model/InventarioPorSedeModel.php';
require_once '../core/Validador.php';

class inventarioController {
    private $model;

    public function __construct() {
        $this->model = new InventarioPorSedeModel();
    }

    public function listarSedes() {
        try {
            $sedes = $this->model->obtenerSedes();
            return ['status' => 'success', 'data' => $sedes];
        } catch (Exception $e) {
            return ['status' => 'error', 'mensaje' => $e->getMessage()];
        }
    }

    public function obtenerInventario($idSede) {
        try {
            $idSede = Validador::validarID($idSede);
            if (!$idSede) {
                return ['status' => 'error', 'mensaje' => 'Sede inválida'];
            }

            $inventario = $this->model->obtenerInventarioPorSede($idSede);
            return ['status' => 'success', 'data' => $inventario];
        } catch (Exception $e) {
            return ['status' => 'error', 'mensaje' => $e->getMessage()];
        }
    }

    public function actualizarStock($idSede, $idPresentacion, $cantidad, $costoUnitario) {
        try {
            $idSede = Validador::validarID($idSede);
            $idPresentacion = Validador::validarID($idPresentacion);
            $cantidad = Validador::validarCantidad($cantidad);
            $costoUnitario = Validador::validarPrecio($costoUnitario);

            if (!$idSede || !$idPresentacion || $cantidad === false || $costoUnitario === false) {
                return ['status' => 'error', 'mensaje' => 'Datos inválidos'];
            }

            $result = $this->model->actualizarStock($idSede, $idPresentacion, $cantidad, $costoUnitario);

            if ($result) {
                return ['status' => 'success', 'mensaje' => 'Stock actualizado correctamente'];
            } else {
                return ['status' => 'error', 'mensaje' => 'Error al actualizar el stock'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'mensaje' => $e->getMessage()];
        }
    }
}
?>
