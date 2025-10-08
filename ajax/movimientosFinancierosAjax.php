<?php 

    require_once('../controller/listadoMovimientosController.php');
    require_once('../controller/registroEgresoController.php');
    require_once('../controller/totalesMovimientosFinancierosController.php');

    $accion = isset($_POST['accion']) ? $_POST['accion'] : (isset($_GET['accion']) ? $_GET['accion'] : 'listadoMovimientos');

    switch ($accion) {
        case 'listadoMovimientos':
            $listadoMovimientos = new listadoMovimientosController();
            $respuesta = $listadoMovimientos->obtenerListadoMovimientos();
            echo json_encode($respuesta);
            break;
        case 'registrarEgreso':
            // Código para registrar un egreso
            // Por ejemplo:
            // $monto = $_POST['monto'];
            // $referencia = $_POST['referencia'];
            // $descripcion = $_POST['descripcion'];
            // Aquí iría la lógica para guardar el egreso en la base de datos
            // Luego devolver una respuesta JSON

            if (!isset($_POST['monto']) || !isset($_POST['referencia']) || !isset($_POST['descripcion'])) {
                echo json_encode([
                    'status' => 'error',
                    'mensaje' => 'Todos los campos son obligatorios'
                ]);
                exit;
            }

            $registro = new registroEgresoController(
                $_POST['monto'],
                $_POST['referencia'],
                $_POST['descripcion']
            );
            $respuesta = $registro->registrarEgreso();
            echo json_encode($respuesta);

            break;
        case 'totales':
            $totalMovimientos = new totalesMovimientosFinancierosController();
            $respuesta = $totalMovimientos->obtenerTotalesMovimientosFinancieros();
            echo json_encode($respuesta);
            break;
        
        default:
            # code...
            break;
    }