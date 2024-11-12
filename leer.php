
<?php // leer.php
session_start();
include 'conexion.php';

if ($_SESSION['userType'] !== 'doctor') {
    header("Location: menu.php");
    exit();
}

// Eliminar el mensaje si se ha solicitado borrar
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM mensajes WHERE id = ?");
    $stmt->execute([$deleteId]);
    echo "Mensaje eliminado exitosamente.";
}

// Obtener todos los mensajes enviados al doctor
$doctor = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT id, paciente, mensaje, fecha FROM mensajes WHERE doctor = ? ORDER BY fecha DESC");
$stmt->execute([$doctor]);
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comentarios de Pacientes</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <h2>Comentarios de Pacientes</h2>
    <?php if (count($messages) > 0): ?>
        <table>
            <tr>
                <th>Paciente</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= htmlspecialchars($msg['paciente']) ?></td>
                    <td><?= htmlspecialchars($msg['mensaje']) ?></td>
                    <td><?= htmlspecialchars($msg['fecha']) ?></td>
                    <td>
                        <a href="leer.php?delete_id=<?= $msg['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este mensaje?');">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay comentarios de pacientes.</p>
    <?php endif; ?>

    <!-- Botón para regresar al menú principal -->
    <button onclick="location.href='menu.php'">Volver al Menú Principal</button>
</body>
</html>
