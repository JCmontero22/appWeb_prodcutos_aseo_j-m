<?php

require_once('../controller/listadoClientesController.php');

$listadoClientes = new listadoClientesController();

$resultado = $listadoClientes->listarClientes();

$cliente = $resultado['data'][1];

foreach ($cliente as $campo => $valor) {

    echo "<hr>";
    echo "<strong>$campo</strong><br>";

    var_dump($valor);

    if (is_string($valor)) {

        echo "HEX: ".bin2hex($valor)."<br>";

        if (json_encode($valor) === false) {
            echo "<span style='color:red'>ERROR EN ESTE CAMPO</span><br>";
            echo json_last_error_msg();
            exit;
        }

    }

}
echo "Todos los clientes son válidos";