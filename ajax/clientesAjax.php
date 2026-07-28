<?php

echo "PASO 1<br>";

require_once('../controller/listadoClientesController.php');

echo "PASO 2<br>";

$listadoClientes = new listadoClientesController();

echo "PASO 3<br>";

exit;