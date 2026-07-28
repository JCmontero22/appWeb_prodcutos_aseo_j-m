<?php

require_once('../controller/listadoClientesController.php');

$listadoClientes = new listadoClientesController();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($listadoClientes->listarClientes());