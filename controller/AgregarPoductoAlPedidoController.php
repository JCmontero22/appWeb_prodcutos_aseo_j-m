<?php 

    require_once('../model/AgregarPoductoAlPedidoModel.php');
    require_once('../controller/RecalcularTotalesController.php');

    class AgregarPoductoAlPedidoController extends AgregarPoductoAlPedidoModel
    {
        private $idPedido;
        private $idPresentacion;
        private $cantidad;
        private $total;
        private $precioVenta;

        public function __construct($idPedido, $idPresentacion, $cantidad, $total, $precioVenta)
        {
            $this->idPedido = $idPedido;
            $this->idPresentacion = $idPresentacion;
            $this->cantidad = $cantidad;
            $this->total = $total;
            $this->precioVenta = $precioVenta;
        }

        public function agregarProducto()
        {
            try {
                $respuesta = $this->set_agregarProductoPedido( $this->idPedido,$this->idPresentacion,$this->cantidad,$this->total,$this->precioVenta);   

                // Recalcular totales
                $recalcular = new RecalcularTotalesController($this->idPedido, new ConsultaTotalesModel(), new RecalcularTotalesModel());
                $recalcular->recalcular();

                return $respuesta = ['status' => 'success', 'mensaje' => 'Producto agregado con éxito.'];
            } catch (\Exception $e) {
                return ['status' => 'error', 'mensaje' => $e->getMessage()];
            }             
        }
    }
    