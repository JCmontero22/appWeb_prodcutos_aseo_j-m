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
            try {
                $sql = $this->db->prepare($query);
                if (!$sql) {
                    $errors = $this->db->errorInfo();
                    file_put_contents('/tmp/debug_compra.txt', "Error en prepare: " . json_encode($errors) . "\n", FILE_APPEND);
                    throw new Exception("Error en prepare: " . $errors[2]);
                }

                $resultado = $sql->execute($params);
                if (!$resultado) {
                    $errors = $sql->errorInfo();
                    file_put_contents('/tmp/debug_compra.txt', "Error en execute: " . json_encode($errors) . "\n", FILE_APPEND);
                    throw new Exception("Error en execute: " . $errors[2]);
                }

                // Si es un INSERT, devuelve el último ID
                if (stripos($query, 'insert') === 0) {
                    return $this->db->lastInsertId();
                }

                // Para UPDATE o DELETE devuelve filas afectadas
                return $sql->rowCount();
            } catch (\Exception $e) {
                file_put_contents('/tmp/debug_compra.txt', "Excepción en execute: " . $e->getMessage() . "\n", FILE_APPEND);
                throw $e;
            }
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

