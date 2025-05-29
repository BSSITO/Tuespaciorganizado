<?php
require_once "Conexion.php";

class Usuario {
    private $id;
    private $nombre_usuario;
    private $contrasena;
    private $conn;

    public function __construct($nombre_usuario) {
        $this->nombre_usuario = $nombre_usuario;
        $conexion = new Conexion();
        $this->conn = $conexion->conn;
    }

    public function setClave($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getNombre() {
        return $this->nombre_usuario;
    }

    public function getId() {
        return $this->id;
    }

    // Carga el id del usuario desde la base de datos
    public function cargar() {
        $sql = "SELECT id FROM usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre_usuario' => $this->nombre_usuario
        ]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            $this->id = $usuario['id'];
        }
    }

    // Comprueba si el usuario existe y la contraseña es correcta
    public function autenticar() {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre_usuario' => $this->nombre_usuario
        ]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            // Si la contraseña está hasheada, usa password_verify
            if (password_verify($this->contrasena, $usuario['contrasena_hash'])) {
                return true;
            }
            // Si usas contraseñas en texto plano (solo para pruebas, NO recomendado):
            // if ($this->contrasena === $usuario['contrasena_hash']) return true;
        }
        return false;
    }
}
?>