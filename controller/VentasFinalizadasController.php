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
    public function obtenerVentas($mes = '') {
        try {
            $ventas = $this->model->obtenerVentasFinalizadas($mes);
            return ['status' => 'success', 'data' => $ventas];
        } catch (Exception $e) {
            return ['status' => 'error', 'mensaje' => $e->getMessage()];
        }
    }

    /**
     * Actualizar separado (0 o 1)
     */
    public function marcarSeparado($idPedido, $valor = 1) {
        try {
            $result = $this->model->actualizarSeparado($idPedido, $valor);
            if ($result) {
                $msg = $valor == 1 ? 'Pedido marcado como separado' : 'Pedido desmarcado como separado';
                return ['status' => 'success', 'mensaje' => $msg];
            }
            return ['status' => 'error', 'mensaje' => 'No se pudo actualizar el pedido'];
        } catch (Exception $e) {
            return ['status' => 'error', 'mensaje' => $e->getMessage()];
        }
    }
}
?>
