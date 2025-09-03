<?php 

    require_once('../core/conexion.php');

    class RecalcularTotalesModel 
    {
        public function set_recalcularTotales($idPedido, $totales){
            $db = new Conexion();

            $update = "UPDATE pedidos 
                    SET costo_total_pedido = :costoTotal, 
                        valor_total_pedido = :valorTotal, 
                        ganancia_total_pedido = :gananciaTotal
                    WHERE id_pedidos = :idPedido";
                $db->execute($update, [
                    ':costoTotal' => $totales['costoTotal'],
                    ':valorTotal' => $totales['valorTotal'],
                    ':gananciaTotal' => $totales['gananciaTotal'],
                    ':idPedido' => $idPedido
                ]);
        }
    }
    