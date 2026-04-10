<?php 

    require_once('../model/ListadoComprasModel.php');

    class ListadoComprasController extends ListadoComprasModel
    {
        
        public function listadoCompras($sedId = 0)
        {
            
            $respuesta = [];
            try {
                

                $resultadoCompras = $this->get_listadoCompras($sedId);
                $totalStock = array_sum(array_column($resultadoCompras, 'valorStock'));
                for ($i=0; $i < count($resultadoCompras); $i++) { 
                    $data[] = [
                        'id' => $resultadoCompras[$i]['id_compra'],
                        'proveedor' => $resultadoCompras[$i]['proveedor'],
                        'numero_factura' => $resultadoCompras[$i]['numero_factura'],
                        'fecha_compra' => $resultadoCompras[$i]['fecha_compra'],
                        'total_factura' => $resultadoCompras[$i]['total_factura'],
                        'tipo_pago' => $resultadoCompras[$i]['nombre_tipo_de_pago'],
                        'sedes' => $resultadoCompras[$i]['nombre_sede'],
                        'observacion' => $resultadoCompras[$i]['observacion'],
                        'estado' => $resultadoCompras[$i]['estado'],
                    ];
                }

                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Listado de compras obtenido correctamente',
                    'valorTotalStock' => $totalStock,
                    'data' => $data     
                ];

            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }
        }

        public function detalleCompra($idCompra) {
            try {
               $resultadoDetalle = $this->get_detalleCompra($idCompra);
               return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Detalle de compra obtenido correctamente',
                    'data' => $resultadoDetalle
               ];
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }
        }
    }
     