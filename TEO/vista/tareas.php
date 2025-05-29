<?php

require_once __DIR__ . '/../modelo/Conexion.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;

$conexion = new Conexion();
$conn = $conexion->conn;

// Procesar acciones: completar o borrar tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Marcar como completada
    if (isset($_POST['completar_id'])) {
        $id = intval($_POST['completar_id']);
        $stmt = $conn->prepare("UPDATE tareas SET completada = 1 WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id, $usuario_id]);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
    // Borrar tarea
    if (isset($_POST['borrar_id'])) {
        $id = intval($_POST['borrar_id']);
        $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id, $usuario_id]);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
    // Agregar tarea
    if (isset($_POST['descripcion_tarea'])) {
        $desc = trim($_POST['descripcion_tarea']);
        if ($desc !== '' && $usuario_id) {
            try {
                $stmt = $conn->prepare("INSERT INTO tareas (usuario_id, descripcion_tarea, completada, creada_en) VALUES (?, ?, 0, NOW())");
                $stmt->execute([$usuario_id, $desc]);
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } catch (PDOException $e) {
                echo "<p style='color:red'>Error al crear tarea: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } elseif (!$usuario_id) {
            echo "<p style='color:red'>No se encontró el usuario en sesión.</p>";
        }
    }
}

// Obtener tareas del usuario
$tareas = [];
if ($usuario_id) {
    $stmt = $conn->prepare("SELECT id, descripcion_tarea, completada, creada_en FROM tareas WHERE usuario_id = ? ORDER BY creada_en DESC");
    $stmt->execute([$usuario_id]);
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<h3>Tus tareas</h3>
<form method="post" autocomplete="off">
    <input type="text" name="descripcion_tarea" placeholder="Nueva tarea" required>
    <button type="submit">Agregar</button>
</form>
<ul>
    <?php foreach ($tareas as $tarea): ?>
        <li>
            <?php echo htmlspecialchars($tarea['descripcion_tarea']); ?>
            <?php if ($tarea['completada']): ?>
                <span style="color:green;">[Completada]</span>
            <?php endif; ?>
            <small><?php echo htmlspecialchars($tarea['creada_en']); ?></small>
            <form method="post" style="display:inline">
                <input type="hidden" name="completar_id" value="<?php echo $tarea['id']; ?>">
                <button type="submit" class="tarea-btn completar-btn" <?php if ($tarea['completada']) echo 'disabled'; ?>>
                    ✔
                </button>
            </form>
            <form method="post" style="display:inline">
                <input type="hidden" name="borrar_id" value="<?php echo $tarea['id']; ?>">
                <button type="submit" class="tarea-btn borrar-btn" onclick="return confirm('¿Borrar esta tarea?')">
                    🗑
                </button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>