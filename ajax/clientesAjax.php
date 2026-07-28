<?php

echo "INICIO";

require_once('../controller/listadoClientesController.php');

echo " - CONTROLLER";

$listadoClientes = new listadoClientesController();

echo " - OBJETO";

$resultado = $listadoClientes->listarClientes();

echo " - RESULTADO";

exit;