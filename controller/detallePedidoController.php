<?php

require_once('../model/DetallePedidoModel.php');

class detallePedidoController extends DetallePedidoModel
{

    private $idPedido;

    public function __construct($idPedido = null)
    {
        $this->idPedido = $idPedido;
    }

    public function detallePedido()
    {

        $respuesta = [];
        try {
            $respuestaDetalle = $this->get_detallePedido($this->idPedido);
            if (empty($respuestaDetalle)) {
                $respuesta = [
                    'status' => 'error',
                    'mensaje' => 'No se encontraron detalles para el pedido especificado.',
                    'data' => []
                ];
            }

            for ($i = 0; $i < count($respuestaDetalle); $i++) {
                $data[] = [
                    'nombreProducto' => $respuestaDetalle[$i]['nombreProducto'],
                    'idPresentacion' => $respuestaDetalle[$i]['idPresentacion'],
                    'presentacion' => $respuestaDetalle[$i]['presentacion'],
                    'cantidad' => $respuestaDetalle[$i]['cantidad'],
                    'subtotal' => $respuestaDetalle[$i]['subtotal'],
                    'idDetallePedido' => $respuestaDetalle[$i]['idDetallePedido'],
                    'estado' => $respuestaDetalle[$i]['estado'],
                    'precioVenta' => $respuestaDetalle[$i]['precioVenta']
                ];
            }

            $respuesta = [
                'status' => 'success',
                'mensaje' => 'Detalles del pedido obtenidos correctamente',
                'data' => $data
            ];

            return $respuesta;
        } catch (\Exception $e) {
            $respuesta = [
                'status' => 'error',
                'mensaje' => 'Error al obtener los detalles del pedido.',
                'data' => $e->getMessage()
            ];

            return $respuesta;
        }
    }
}
