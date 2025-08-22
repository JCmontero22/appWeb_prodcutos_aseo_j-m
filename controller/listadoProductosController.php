<?php 

    require_once('../model/ListadoProductosModel.php');

    class ListadoProductosController extends ListadoProductosModel
    {
        
        public function listadoProductos()
        {
            
            $respuesta = [];
            try {
                

                $resultadoProdcutos = $this->get_listadoProdcutos();

                for ($i=0; $i < count($resultadoProdcutos); $i++) { 
                    $data[] = [
                        'id' => $resultadoProdcutos[$i]['id'],
                        'nombre' => $resultadoProdcutos[$i]['nombre'],
                        'presentacion' => $resultadoProdcutos[$i]['presentacion'],
                        'cantidad' => $resultadoProdcutos[$i]['cantidad'],
                        'precio' => $resultadoProdcutos[$i]['presioVenta'],
                        'idPresentacion' => $resultadoProdcutos[$i]['idPresentacion'],
                        'precioCompra' => $resultadoProdcutos[$i]['precioCompra'],
                        'precioVentaJM' => $resultadoProdcutos[$i]['precioVentaJM'],
                    ];
                }

                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Listado de productos obtenido correctamente',
                    'data' => $data
                ];

            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => $e->getMessage()
                ];
            }
        }
    }
     