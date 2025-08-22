<?php 

    require_once('../core/conexion.php');

    class LogoutModel
    {
        protected function logoutModel()
        {
            session_start();
            session_unset();
            session_destroy();

            return true;
        }
    }
