<?php
require_once "config.php";

class Conexion {
    public $conn;

    function __construct() {
        $this->crearConexion();
    }

    private function crearConexion() {
        $strConexion = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";charset=utf8";
        try {
            $this->conn = new PDO($strConexion, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>