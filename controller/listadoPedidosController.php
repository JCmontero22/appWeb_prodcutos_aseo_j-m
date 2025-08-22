 <?php 

    require_once('../model/listadoPedidosModel.php');

    session_start();

    class listadoPedidosController extends listadoPedidosModel
    {
        public function listarMisPedidos(){
            $respuesta = [];

            try {

                $resultadoPedidos = $this->get_listadoPedidos($_SESSION['id'], $_SESSION['rol']);

                if (empty($resultadoPedidos)) {
                    return [
                        'status' => 'error',
                        'mensaje' => 'No se encontraron pedidos.',
                        'data' => []
                    ];
                }

                for ($i=0; $i < count($resultadoPedidos) ; $i++) { 
                    $data[] = [
                        'idPedido' => $resultadoPedidos[$i]['idPedido'],
                        'cliente' => $resultadoPedidos[$i]['cliente'],
                        'totalVenta' => $resultadoPedidos[$i]['totalVenta'],
                        'totalGanancia' => $resultadoPedidos[$i]['totalGanancia'],
                        'fechaPedido' => $resultadoPedidos[$i]['fechaPedido'],
                        'fechaEntrega' => $resultadoPedidos[$i]['fechaEntrega'],
                        'estado' => $resultadoPedidos[$i]['estado']
                        
                    ];
                }

                return $respuesta = [
                    'status' => 'success',
                    'mensaje' => 'Pedidos obtenidos correctamente',
                    'data' => $data
                ];
            } catch (\Exception $e) {
                return $respuesta = [
                    'status' => 'error',
                    'mensaje' => $e->getMessage(),
                    'data' => []
                ];
            }
        }
    }
    