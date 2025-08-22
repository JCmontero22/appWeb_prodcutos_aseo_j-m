<?php 


    require_once('../model/logoutModel.php');

    class LogoutController extends LogoutModel
    {
        public function logout()
        {
            try {
                return $this->logoutModel();
            } catch (\Exception $e) {
                return false;
            }
        }
    }
