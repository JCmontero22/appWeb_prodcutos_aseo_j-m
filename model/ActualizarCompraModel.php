<?php 

    require_once('../core/conexion.php');

    class ActualizarCompraModel extends conexion{

        public function update_compra($data) {
            try {
                $db = new Conexion();

                $query = 'UPDATE compras SET
                                id_sede = :idSede,
                                proveedor = :proveedor,
                                id_tipo_de_pago = :tipoPago,
                                numero_factura = :numFactura,
                                total_factura = :totalFactura,
                                observacion = :descripcion
                            WHERE id_compra = :idCompra';
                $params = [
                    ':idCompra' => $data['idCompra'],
                    ':idSede' => $data['idSede'],
                    ':proveedor' => $data['proveedor'],
                    ':tipoPago' => $data['tipoPago'],
                    ':numFactura' => $data['numFactura'],
                    ':totalFactura' => $data['total'],
                    ':descripcion' => $data['descripcion']
                ];

                $resultado = $db->execute($query, $params);
                return true;
            } catch (\Exception $e) {
                error_log('Error en update_compra: ' . $e->getMessage());
                throw $e;
            }
        }

        public function update_detalleCompra($dataCompra) {
            try {
                $db = new Conexion();

                if (isset($dataCompra['detalles']) && is_array($dataCompra['detalles'])) {
                    foreach ($dataCompra['detalles'] as $detalle) {
                        $query = "UPDATE detalle_compra SET
                                    precio_costo_unitario = :precioCosto,
                                    cantidad = :cantidad,
                                    subtotal = :subtotal
                                    WHERE id_detalle_compra = :idDetalle";

                        $params = [
                            ':precioCosto' => $detalle['precio_costo_unitario'],
                            ':cantidad' => $detalle['cantidad'],
                            ':subtotal' => $detalle['subtotal'],
                            ':idDetalle' => $detalle['id_detalle_compra']
                        ];

                        $db->execute($query, $params);
                    }
                }
                return true;
            } catch (\Exception $e) {
                error_log('Error en update_detalleCompra: ' . $e->getMessage());
                throw $e;
            }
        }
    }
    