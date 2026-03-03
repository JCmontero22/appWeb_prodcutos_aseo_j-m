<?php 

    require_once('../model/ListadoProductosModel.php');

    class ListadoProductosController extends ListadoProductosModel
    {
        
        public function listadoProductos($sedId = 0)
        {
            
            $respuesta = [];
            try {
                

                $resultadoProdcutos = $this->get_listadoProdcutos($sedId);
                $totalStock = array_sum(array_column($resultadoProdcutos, 'valorStock'));
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
                        'cantidadMinima' => $resultadoProdcutos[$i]['cantidadMinima'],
                        'valorStock' => $resultadoProdcutos[$i]['valorStock'],
                        'valorTotalStock' => array_sum(array_column($resultadoProdcutos, 'valorStock'))
                    ];
                }

                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Listado de productos obtenido correctamente',
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
    }
     