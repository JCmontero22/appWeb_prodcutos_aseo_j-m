<?php 

    require_once('../core/conexion.php');

    class EditarEstadoPedidoModel
    {
        protected function set_actualizarEstadoPedido($idEstado, $idPedido, $medioPago){

            try {
                $db = new Conexion();

                $pago = $medioPago ? ", id_tipo_de_pago = :medioPago" : "";

                $query = "UPDATE pedidos SET id_estado = :idEstado $pago WHERE id_pedidos = :idPedido";

                $parametros = [
                    ':idEstado' => $idEstado,
                    ':idPedido' => $idPedido
                ];
                if ($medioPago) {
                    $parametros[':medioPago'] = $medioPago;
                }
                $respuesta = $db->execute($query, $parametros);
                return $respuesta;
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
            
        }        
    }           

    