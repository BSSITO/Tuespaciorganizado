<?php 
session_start();

if (empty($_POST)) {
    header("Location: ../vista/login.php");
    exit();
} else {
    include "../modelo/Usuario.php";
    include "../controlador/Controlador.php";

    $controlador = new Controlador();
    $usuario = new Usuario($_POST['nombre']);
    $usuario->setClave($_POST['clave']);

    $autenticado = $controlador->autenticarUsuario($usuario);

    if (!$autenticado) {
        // Redirige al formulario de registro y pasa el nombre de usuario
        $_SESSION["registro_nombre"] = $_POST['nombre'];
        $_SESSION["registro_clave"] = $_POST['clave'];
        header("Location: ../vista/registro.php");
        exit();
    } else {
        unset($_SESSION["errorAutenticacion"]);
        $usuario->cargar();
        $_SESSION["usuario"] = $usuario->getNombre();
        $_SESSION["usuario_id"] = $usuario->getId(); // <-- Añadido para tareas
        header("Location: ../index.php");
        exit();
    }
}
?>