<?php 
    
    session_start();

    // Autoload básico (para que no tengas que hacer require_once por todo lado)
  /*   spl_autoload_register(function ($class) {
        $paths = ['../controller/', '../model/', '../ajax/', '../core/', '../config/'];
        foreach ($paths as $path) {
            $file = __DIR__ . "/$path$class.php";
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }); */


    // Definir rutas
    $routes = [
        'login' => 'Auth/loginView.php',
        'home' => 'Home/homeView.php',
        'listadoProductos' => 'Productos/listadoProductosView.php',
        'pedidos' => 'Pedidos/pedido.php',
        'misPedidos' => 'Pedidos/misPedidos.php',
        'clientes' => 'Clientes/listadoClientes.php'
    ];

    $uri = $_SERVER['REQUEST_URI']; 
    $uri = strtok($uri, '?');
    $segments = explode('/', trim($uri, '/'));
    $page = end($segments);

    if (empty($_SESSION) && $page !== 'login') {
        include_once('../views/Auth/loginView.php');
    } elseif (in_array($page, array_keys($routes))) {
        include_once('../views/' . $routes[$page]);
    } else {
        include_once('../views/404.php');
    }


    
    /* if (empty($_SESSION) && $page === 'login') {
        include_once('../views/Auth/login.php');

    }elseif (empty($_SESSION) && $page !== 'login') {

        include_once('../views/Auth/login.php');
    }elseif (in_array($page, array_keys($routes))) {

        include_once('../views/' . $routes[$page]);
    }else {
        // Página no encontrada
        include_once('../views/404.php');
        
    } */