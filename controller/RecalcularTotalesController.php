<?php 

    require_once('../model/RecalcularTotalesModel.php');
    require_once('../model/ConsultaTotalesModel.php');

    class RecalcularTotalesController 
    {
        private $idPedido;
        private $consultaTotales;
        private $recalcular;

        public function __construct($idPedido, ConsultaTotalesModel $consultaTotales, RecalcularTotalesModel $recalcular) {
            $this->idPedido = $idPedido;
            $this->consultaTotales = $consultaTotales;
            $this->recalcular = $recalcular;
        }

        public function recalcular() {
            $consultaTotales = $this->consultaTotales->get_totales($this->idPedido);

            if ($consultaTotales) {
                $recalculo = $this->recalcular->set_recalcularTotales($this->idPedido, $consultaTotales);
            }
            
        }
    }
    