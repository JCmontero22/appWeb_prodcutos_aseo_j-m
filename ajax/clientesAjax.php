<?php

require_once('../controller/listadoClientesController.php');

$listadoClientes = new listadoClientesController();

$resultado = $listadoClientes->listarClientes();

foreach ($resultado as $campo => $valor) {

    $json = json_encode($valor);

    if ($json === false) {

        echo "Campo con error: $campo<br>";
        echo "Valor:<br>";

        var_dump($valor);

        echo "<br>";
        echo json_last_error_msg();

        exit;
    }

}
