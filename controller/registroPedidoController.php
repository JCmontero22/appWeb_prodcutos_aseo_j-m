<?php 

    session_start();
    require_once('../model/registroPedidoModel.php');

    class RegistroPedidoController extends registroPedidoModel
    {

        private $cliente;
        private $producto;
        private $totalPedido;

        public function __construct($cliente = null, $producto = null, $totalPedido = null) {
            $this->cliente = $cliente;
            $this->producto = $producto;
            $this->totalPedido = $totalPedido;
        }

        public function registrarPedido(){
            try {
                
                $valorTotalDeCompra = 0;
                $totalGanancia = 0;
                for ($i=0; $i < count($this->producto); $i++) { 
                    $valorTotalDeCompra += $this->producto[$i]['precioCompraTotal'];
                    $totalGanancia +=  $this->producto[$i]['total'] - $this->producto[$i]['precioVentaJMTotal'];
                }

                $data = [
                    'usuario' => $_SESSION['id'],
                    'cliente' => $this->cliente,
                    'estado' => 1,
                    'fechaPedido' => date('Y-m-d H:i:s'),
                    'costoTotal' => $valorTotalDeCompra,
                    'valorTotalPedido' => $this->totalPedido,
                    'totalGanancia' => $totalGanancia
                ];
                

                $respuestaPedido = $this->set_registroPedido($data);

                if ($respuestaPedido) {
                    $respuestaDetalle = $this->registroDetallePedido($respuestaPedido);
                    if ($respuestaDetalle) {
                        return ['status' => 'success', 'mensaje' => 'Pedido registrado con éxito.'];
                    } else {
                        return ['status' => 'error', 'mensaje' => 'Error al registrar el detalle del pedido.'];
                    }
                }
                
            } catch (\Exception $e) {
                echo ['status' => 'error', 'mensaje' => $e->getMessage()];
            }
        }

        private function registroDetallePedido($idPedido){
            try {
                for ($i=0; $i < count($this->producto); $i++) { 
                    $data = [
                        'id_pedido' => $idPedido,
                        'id_presentacion' => $this->producto[$i]['idPresentacion'],
                        'cantidad' => $this->producto[$i]['cantidad'],
                        'precioVenta' => $this->producto[$i]['precioVenta'],
                        'subtotal' => $this->producto[$i]['total']
                    ];


                    $respuesta = $this->set_registroDetallePedido($data);
                    
                    if (!$respuesta) {
                        return ['status' => 'error', 'mensaje' => 'Error al registrar el detalle del pedido.'];
                    }
                }
                return true;
            } catch (\Exception $e) {
                return  $e->getMessage();
            }
        }
    }
    