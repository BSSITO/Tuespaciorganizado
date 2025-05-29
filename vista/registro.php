<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<div class="registro-container">
    <h2>Registro de usuario</h2>
    <form action="../controlador/registrarUsuario.php" method="POST" class="registro-form">
        <label for="nombre">Usuario:</label>
        <input type="text" id="nombre" name="nombre" required value="<?php session_start(); echo isset($_SESSION['registro_nombre']) ? htmlspecialchars($_SESSION['registro_nombre']) : ''; ?>">

        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave" required value="<?php echo isset($_SESSION['registro_clave']) ? htmlspecialchars($_SESSION['registro_clave']) : ''; ?>">

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="tema">Preferencia de tema:</label>
        <select id="tema" name="tema">
            <option value="claro">Claro</option>
            <option value="oscuro">Oscuro</option>
        </select>

        <input type="submit" value="Registrar usuario" class="submit-button">
    </form>
    <?php
    if (isset($_SESSION["errorRegistro"])) {
        echo '<h5 class="error-message">' . $_SESSION["errorRegistro"] . '</h5>';
        unset($_SESSION["errorRegistro"]);
    }
    ?>
</div>
</body>
</html>
