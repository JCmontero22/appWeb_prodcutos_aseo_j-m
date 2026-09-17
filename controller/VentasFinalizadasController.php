<?php

require_once('../model/VentasFinalizadasModel.php');

class VentasFinalizadasController {
    private $model;

    public function __construct() {
        $this->model = new VentasFinalizadasModel();
    }

    /**
     * Obtener todas las ventas finalizadas y pagadas
     */
    public function obtenerVentas() {
        try {
            $ventas = $this->model->obtenerVentasFinalizadas();
            return ['status' => 'success', 'data' => $ventas];
        } catch (Exception $e) {
            return ['status' => 'error', 'mensaje' => $e->getMessage()];
        }
    }
}
?>
