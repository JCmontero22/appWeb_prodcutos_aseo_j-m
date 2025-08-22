<?php 

    require_once('../config/configDB.php');

    class conexion 
    {
        protected $db;

        public function __construct() {
            $this->db = $this->conect();
        }

        private function conect(){
            try {
                $conectar = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
                return $conectar;
            } catch (\Exception $e) {
                throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        public function execute($query, $params = []){
            $sql = $this->db->prepare($query);
            $sql->execute($params);

            // Si es un INSERT, devuelve el último ID
            if (stripos($query, 'insert') === 0) {
                return $this->db->lastInsertId();
            }

            // Para UPDATE o DELETE devuelve filas afectadas
            return $sql->rowCount();
        }

        public function select($query, $params = []){
            try {
                $sql = $this->db->prepare($query);
                $sql->execute($params);
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Exception $e) {
                throw new Exception("Error al ejecutar la consulta de selección: " . $e->getMessage());
            }
        }
    }

