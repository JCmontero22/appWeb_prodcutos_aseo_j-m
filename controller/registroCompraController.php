<?php 

    session_start();
    require_once('../model/registroComprasModel.php');

    class RegistroCompraController extends registroComprasModel
    {

        private $proveedor;
        private $numFactura;
        private $idSede;
        private $tipoPago;
        private $descripcion;
        private $total;
        private $detalles;

        public function __construct($proveedor = null, $numFactura = null, $idSede = null, $tipoPago = null, $descripcion = null, $total = null, $detalles = null) {
            $this->proveedor = $proveedor;
            $this->numFactura = $numFactura;
            $this->idSede = $idSede;
            $this->tipoPago = $tipoPago;
            $this->descripcion = $descripcion;
            $this->total = $total;
            $this->detalles = $detalles;
        }

        public function registrarCompra(){
            try {
                
                $data = [
                    'proveedor' => $this->proveedor,
                    'numFactura' => $this->numFactura,
                    'idSede' => $this->idSede,
                    'tipoPago' => $this->tipoPago,
                    'descripcion' => $this->descripcion,
                    'total' => $this->total,
                ];
                

                $respuestaPedido = $this->set_compra($data);
                if ($respuestaPedido) {
                    $respuestaDetalle = $this->registroDetallePedido($respuestaPedido);
                    if ($respuestaDetalle) {
                        return ['status' => 'success', 'mensaje' => 'Compra registrada con éxito.'];
                    } else {
                        return ['status' => 'error', 'mensaje' => 'Error al registrar el detalle de la compra.'];
                    }
                }
                
            } catch (\Exception $e) {
                echo ['status' => 'error', 'mensaje' => $e->getMessage()];
            }
        }

        private function registroDetallePedido($idCompra){
            try {
                for ($i=0; $i < count($this->detalles); $i++) { 
                    $data = [
                        'idCompra' => $idCompra,
                        'idPresentacion' => $this->detalles[$i]['idProducto'],
                        'cantidad' => $this->detalles[$i]['cantidad'],
                        'precioCompra' => $this->detalles[$i]['precioCompra'],
                        'subtotal' => $this->detalles[$i]['subtotal']
                    ];                  

                    $respuesta = $this->set_registro_detalle_compra($data);
                    if (!$respuesta) {
                        return false;
                    }
                }
                return true;
            } catch (\Exception $e) {
                return  $e->getMessage();
            }
        }
    }
    