<?php

require_once('../core/conexion.php');

class VentasFinalizadasModel {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    /**
     * Obtener ventas finalizadas y pagadas
     */
    public function obtenerVentasFinalizadas($mes = '') {
        $sql = "SELECT
                    ped.id_pedidos,
                    sed.nombre_sede,
                    usu.nombre_usuario as vendedor,
                    ped.fecha_pedido,
                    ped.id_estado,
                    ped.costo_total_pedido,
                    ped.valor_total_pedido,
                    ped.ganancia_total_pedido,
                    ped.id_usuario
                FROM pedidos ped
                INNER JOIN usuarios usu ON ped.id_usuario = usu.id_usuario
                INNER JOIN sedes sed ON usu.id_sede = sed.id_sede
                WHERE ped.id_estado IN (6, 7)";

        if (!empty($mes)) {
            $sql .= " AND MONTH(ped.fecha_pedido) = :mes AND YEAR(ped.fecha_pedido) = YEAR(NOW())";
        }

        $sql .= " ORDER BY ped.fecha_pedido DESC";

        try {
            if (!empty($mes)) {
                $params = [':mes' => $mes];
                $resultado = $this->db->select($sql, $params);
            } else {
                $resultado = $this->db->select($sql);
            }
            return $resultado;
        } catch (Exception $e) {
            throw new Exception("Error al obtener ventas finalizadas: " . $e->getMessage());
        }
    }
}
?>
