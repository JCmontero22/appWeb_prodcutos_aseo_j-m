<?php

require_once('../controller/listadoClientesController.php');

$listadoClientes = new listadoClientesController();

$resultado = $listadoClientes->listarClientes();

echo "<pre>";
var_dump($resultado);
echo "</pre>";

exit;