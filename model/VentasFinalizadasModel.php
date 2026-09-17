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
    public function obtenerVentasFinalizadas() {
        $sql = "SELECT
                    ped.id_pedido,
                    sed.nombre_sede,
                    usu.nombre_usuario as vendedor,
                    ped.fecha_pedido,
                    est.descripcion_estado as estado,
                    ped.costo_total_pedido,
                    ped.totalGanancia
                FROM pedidos ped
                INNER JOIN sedes sed ON ped.id_sede = sed.id_sede
                INNER JOIN usuarios usu ON ped.id_usuario = usu.id_usuario
                INNER JOIN estado_pedido est ON ped.id_estado = est.id_estado
                WHERE ped.id_estado IN (6, 7)
                ORDER BY ped.fecha_pedido DESC";

        try {
            $resultado = $this->db->select($sql);
            return $resultado;
        } catch (Exception $e) {
            throw new Exception("Error al obtener ventas finalizadas: " . $e->getMessage());
        }
    }
}
?>
