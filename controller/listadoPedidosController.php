 <?php 

    require_once('../model/ListadoVentasModel.php');

    session_start();

    class listadoVentasController extends ListadoVentasModel
    {
        public function listarVentas($admin){
            $respuesta = [];

            try {

                $resultadoPedidos = $this->get_listadoVentas($_SESSION['id'], $_SESSION['rol'], $admin);

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
                        'telefono' => $resultadoPedidos[$i]['telefono'],
                        'direccion' => $resultadoPedidos[$i]['direccion'],
                        'totalVenta' => $resultadoPedidos[$i]['totalVenta'],
                        'totalGanancia' => $resultadoPedidos[$i]['totalGanancia'],
                        'fechaPedido' => $resultadoPedidos[$i]['fechaPedido'],
                        'fechaEntrega' => $resultadoPedidos[$i]['fechaEntrega'],
                        'estado' => $resultadoPedidos[$i]['estado'],
                        'idEstado' => $resultadoPedidos[$i]['idEstado'],
                        'gananciaAdmin' => $resultadoPedidos[$i]['gananciaAdmin'],
                        'vendedor' => $resultadoPedidos[$i]['vendedor']
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
    