<?php

require_once('../controller/listadoClientesController.php');

$listadoClientes = new listadoClientesController();

$resultado = $listadoClientes->listarClientes();

echo "<pre>";
var_dump(json_encode($resultado));
echo "</pre>";

echo "<br><br>";

echo json_last_error();
echo "<br>";
echo json_last_error_msg();

exit;
