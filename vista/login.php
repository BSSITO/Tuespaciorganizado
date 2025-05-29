<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Espacio Organizado - Login</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form action="../controlador/controlAcceso.php" method="POST" class="login-form">
        <label for="nombre">Usuario:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave" required>

        <?php
        session_start();
        if (isset($_SESSION["errorAutenticacion"])) {
            echo '<h5 class="error-message">Error de autenticación</h5>';
            unset($_SESSION["errorAutenticacion"]);
        }
        ?>

        <input type="submit" value="Enviar formulario" class="submit-button">
    </form>
</div>
</body>
</html>
