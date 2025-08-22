<?php 

    require_once('../controller/logoutController.php');


    $logout = new LogoutController();
    echo $response = $logout->logout();

    
