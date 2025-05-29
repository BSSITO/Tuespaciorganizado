<?php
session_start();
if (empty($_POST['nombre']) || empty($_POST['clave']) || empty($_POST['correo'])) {
    $_SESSION["errorRegistro"] = "Todos los campos son obligatorios.";
    header("Location: ../vista/registro.php");
    exit();
}

require_once "../modelo/Conexion.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$correo = $_POST['correo'];
$tema = isset($_POST['tema']) ? $_POST['tema'] : 'claro';
$hash = password_hash($clave, PASSWORD_DEFAULT);

try {
    $conexion = new Conexion();
    $conn = $conexion->conn;

    // Verifica si el usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario");
    $stmt->execute([':nombre_usuario' => $nombre]);
    if ($stmt->fetch()) {
        $_SESSION["errorRegistro"] = "El usuario ya existe.";
        header("Location: ../vista/registro.php");
        exit();
    }

    // Inserta el nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, contrasena_hash, correo_electronico, preferencia_tema, creado_en) VALUES (:nombre, :hash, :correo, :tema, NOW())");
    $stmt->execute([
        ':nombre' => $nombre,
        ':hash' => $hash,
        ':correo' => $correo,
        ':tema' => $tema
    ]);

    // Registro exitoso, inicia sesión automáticamente
    $_SESSION["usuario"] = $nombre;
    unset($_SESSION["registro_nombre"]);
    unset($_SESSION["registro_clave"]);
    header("Location: ../index.php");
    exit();

} catch (PDOException $e) {
    $_SESSION["errorRegistro"] = "Error en el registro: " . $e->getMessage();
    header("Location: ../vista/registro.php");
    exit();
}
?>