<?php

    session_start();
    require_once('../model/registroPedidoModel.php');
    require_once('../core/Validador.php');

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
                Validador::reset();

                // Validar cliente
                if (!Validador::validarID($this->cliente, 'Cliente')) {
                    return ['status' => 'error', 'mensaje' => Validador::primerError()];
                }

                // Validar productos
                if (empty($this->producto)) {
                    return ['status' => 'error', 'mensaje' => 'El pedido debe contener al menos un producto'];
                }

                foreach ($this->producto as $prod) {
                    if (!Validador::validarID($prod['idPresentacion'], 'ID Presentación')) {
                        return ['status' => 'error', 'mensaje' => Validador::primerError()];
                    }
                    if (!Validador::validarCantidad($prod['cantidad'])) {
                        return ['status' => 'error', 'mensaje' => Validador::primerError()];
                    }
                    if (!Validador::validarNumero($prod['precioVenta'], 'Precio', 0)) {
                        return ['status' => 'error', 'mensaje' => Validador::primerError()];
                    }
                }

                $sedeId = $_SESSION['sede'] ?? 1;

                // VALIDACIÓN CRÍTICA: Verificar stock disponible por sede
                $verificacion = $this->verificarStockDisponible($this->producto, $sedeId);
                if (!$verificacion['disponible']) {
                    return ['status' => 'error', 'mensaje' => $verificacion['mensaje']];
                }

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
                    // El trigger de BD maneja el descuento de stock automáticamente
                    $respuestaDetalle = $this->registroDetallePedido($respuestaPedido);
                    if ($respuestaDetalle) {
                        return ['status' => 'success', 'mensaje' => 'Pedido registrado con éxito.'];
                    } else {
                        return ['status' => 'error', 'mensaje' => 'Error al registrar el detalle del pedido.'];
                    }
                }

            } catch (\Exception $e) {
                return ['status' => 'error', 'mensaje' => $e->getMessage()];
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
    