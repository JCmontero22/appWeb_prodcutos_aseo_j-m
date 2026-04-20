<?php 

    require_once('../model/ActualizarCompraModel.php');

    class actualizarCompraController extends ActualizarCompraModel
    {
        public function actualizarCompra($dataCompra)
        {
            try {
                $this->update_compra($dataCompra);
                $this->update_detalleCompra($dataCompra);

                $detallesActualizados = $this->get_detalleCompraActualizado($dataCompra['idCompra']);

                return [
                    'status' => 'success',
                    'mensaje' => 'Compra actualizada con éxito.',
                    'detalles' => $detallesActualizados
                ];
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'mensaje' => 'Error al actualizar la compra: ' . $e->getMessage(),
                ];
            }
        }
    }
     