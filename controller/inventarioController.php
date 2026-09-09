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
            if (!Validador::validarID($idSede)) {
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
            if (!Validador::validarID($idSede)) {
                return ['status' => 'error', 'mensaje' => 'Sede inválida'];
            }
            if (!Validador::validarID($idPresentacion)) {
                return ['status' => 'error', 'mensaje' => 'Presentación inválida'];
            }
            if (!Validador::validarCantidad($cantidad)) {
                return ['status' => 'error', 'mensaje' => 'Cantidad inválida'];
            }
            if (!Validador::validarPrecio($costoUnitario)) {
                return ['status' => 'error', 'mensaje' => 'Costo unitario inválido'];
            }

            $result = $this->model->actualizarStock($idSede, $idPresentacion, $cantidad, $costoUnitario);

            // $result devuelve rowCount (0 o más)
            if ($result !== false) {
                return ['status' => 'success', 'mensaje' => 'Stock actualizado correctamente'];
            } else {
                return ['status' => 'error', 'mensaje' => 'No se pudo actualizar el stock'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'mensaje' => $e->getMessage()];
        }
    }
}
?>
