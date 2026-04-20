<?php 

    require_once('../core/conexion.php');

    class registroComprasModel extends conexion{
     
        public function set_compra($data) {
            try {
                $db = new Conexion();

                $query = 'INSERT INTO compras (
                                id_sede, 
                                proveedor, 
                                id_tipo_de_pago, 
                                numero_factura, 
                                total_factura,
                                observacion
                            )
                            VALUES (
                                :idSede, 
                                :proveedor, 
                                :tipoPago, 
                                :numFactura, 
                                :totalFactura, 
                                :descripcion
                            )';
                $params = [
                    ':idSede' => $data['idSede'],
                    ':proveedor' => $data['proveedor'],
                    ':tipoPago' => $data['tipoPago'],
                    ':numFactura' => $data['numFactura'],
                    ':totalFactura' => $data['total'],
                    ':descripcion' => $data['descripcion']
                ];

                return $respuesta = $db->execute($query, $params);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        public function set_registro_detalle_compra($data) {
            try {
                $db = new Conexion();

                $query = 'INSERT INTO detalle_compra (
                                id_compra, 
                                id_presentacion, 
                                cantidad, 
                                precio_costo_unitario, 
                                subtotal
                            ) 
                            VALUES (
                                :idCompra, 
                                :idPresentacion, 
                                :cantidad, 
                                :precioCompra, 
                                :subtotal
                            )';
                $params = [
                    ':idCompra' => $data['idCompra'],
                    ':idPresentacion' => $data['idPresentacion'],
                    ':cantidad' => $data['cantidad'],
                    ':precioCompra' => $data['precioCompra'],
                    ':subtotal' => $data['subtotal']
                ];

                return $respuesta = $db->execute($query, $params);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            
        }
    }
    