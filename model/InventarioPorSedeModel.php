<?php

require_once('../core/conexion.php');

class InventarioPorSedeModel {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    /**
     * Obtener todas las sedes
     */
    public function obtenerSedes() {
        $sql = "SELECT id_sede, nombre_sede FROM sedes WHERE estado = 1 ORDER BY nombre_sede";
        return $this->db->select($sql);
    }

    /**
     * Obtener inventario de una sede específica
     */
    public function obtenerInventarioPorSede($idSede) {
        $sql = "SELECT
                    ssp.id_stock_sede_presentacion,
                    ssp.id_presentacion,
                    ssp.id_sede,
                    ssp.cantidad_stock_presentacion_sede,
                    pp.id_producto,
                    pp.precio_compra_presentacion,
                    pp.precio_venta_jm_presentacion,
                    pp.precio_venta_cliente_presentacion,
                    pr.nombre_producto,
                    pp.tamano_presentacion
                FROM stock_sede_presentacion ssp
                INNER JOIN presentacion_producto pp ON ssp.id_presentacion = pp.id_presentacion
                INNER JOIN productos pr ON pp.id_producto = pr.id_producto
                WHERE ssp.id_sede = :id_sede AND pp.estado = 1
                ORDER BY pr.nombre_producto, pp.tamano_presentacion";

        $params = [':id_sede' => $idSede];
        return $this->db->select($sql, $params);
    }

    /**
     * Actualizar stock de una presentación en una sede
     */
    public function actualizarStock($idSede, $idPresentacion, $cantidad, $costoUnitario) {
        $sql = "UPDATE stock_sede_presentacion
                SET cantidad_stock_presentacion_sede = :cantidad
                WHERE id_sede = :id_sede AND id_presentacion = :id_presentacion";

        $params = [
            ':cantidad' => $cantidad,
            ':id_sede' => $idSede,
            ':id_presentacion' => $idPresentacion
        ];

        $result = $this->db->execute($sql, $params);

        // Actualizar costo unitario en presentacion_producto (solo costo, no precios)
        if ($result) {
            $sqlCosto = "UPDATE presentacion_producto
                        SET precio_compra_presentacion = :costo
                        WHERE id_presentacion = :id_presentacion";

            $paramsCosto = [
                ':costo' => $costoUnitario,
                ':id_presentacion' => $idPresentacion
            ];

            $this->db->execute($sqlCosto, $paramsCosto);
        }

        return $result;
    }

    /**
     * Obtener detalles de una presentación
     */
    public function obtenerPresentacion($idPresentacion) {
        $sql = "SELECT * FROM presentacion_producto WHERE id_presentacion = :id_presentacion";
        $params = [':id_presentacion' => $idPresentacion];
        $result = $this->db->select($sql, $params);
        return !empty($result) ? $result[0] : null;
    }
}
?>
