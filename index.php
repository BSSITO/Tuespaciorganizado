
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi aplicación</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script>
    // Aplica el tema oscuro antes de que cargue el body
    if(localStorage.getItem('tema') === 'oscuro') {
        document.documentElement.classList.add('tema-oscuro');
    }
    </script>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: vista/login.php");
    exit();
}
?>
<nav>
    <div class="nav-links">
        <a href="/TEO/index.php?seccion=inicio">Inicio</a>
        <a href="/TEO/vista/login.php">Login</a>
        <a href="/TEO/vista/registro.php">Registro</a>
        <a href="/TEO/controlador/logout.php">Cerrar sesión</a>
    </div>
    <button class="tema-toggle" onclick="toggleTema()">Cambiar tema</button>
</nav>

<div class="container-main">
    <aside class="menu-lateral">
        <a href="?seccion=inicio">Inicio</a>
        <a href="?seccion=tareas">Tareas</a>
        <a href="#">Finanzas</a>
        <a href="#">Registro de Salud</a>
    </aside>
    <main class="contenido-principal">
        <?php
        $seccion = $_GET['seccion'] ?? 'inicio';
        if ($seccion === 'tareas') {
            include 'vista/tareas.php';
        } else {
            echo '<h3>Bienvenido/a ' . htmlspecialchars($_SESSION['usuario']) . '</h3>';
            echo '<p>Este es un espacio para el contenido principal.</p>';
        }
        ?>
    </main>
</div>

<script>
function toggleTema() {
    document.body.classList.toggle('tema-oscuro');
    localStorage.setItem('tema', document.body.classList.contains('tema-oscuro') ? 'oscuro' : 'claro');
}
if(localStorage.getItem('tema') === 'oscuro') {
    document.body.classList.add('tema-oscuro');
}
</script>
</body>
</html>