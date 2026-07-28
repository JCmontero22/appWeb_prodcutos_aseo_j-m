<?php

require_once('../controller/listadoClientesController.php');

$listadoClientes = new listadoClientesController();

$resultado = $listadoClientes->listarClientes();

foreach ($resultado['data'] as $i => $cliente) {

    $json = json_encode($cliente);

    if ($json === false) {

        echo "Registro: ".$i."<br>";
        echo json_last_error_msg()."<br><br>";

        echo "<pre>";
        var_dump($cliente);
        echo "</pre>";

        exit;
    }

}

echo "Todos los registros son válidos";

exit;
