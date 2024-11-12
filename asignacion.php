<?php
// asignacion.php
session_start();
include 'conexion.php';

// Verificar que el usuario sea un paciente
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'paciente') {
    header("Location: login.php");
    exit();
}

// Obtener los medicamentos asignados al paciente
$paciente = $_SESSION['username'];  // Suponemos que el nombre del paciente es el username

$stmt = $pdo->prepare("SELECT m.nombre, m.descripcion, m.tiempo 
                       FROM asignaciones a
                       JOIN medicamentos m ON a.medicamento_id = m.id
                       WHERE a.paciente_nombre = ?");
$stmt->execute([$paciente]);
$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Medicamentos Asignados</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <h2>Medicamentos Recetados</h2>

    <?php if ($medicamentos): ?>
        <?php foreach ($medicamentos as $med): ?>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($med['nombre']) ?></p>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($med['descripcion']) ?></p>
            <p><strong>Tiempo:</strong> <?= htmlspecialchars($med['tiempo']) ?></p>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No se han asignado medicamentos aún.</p>
    <?php endif; ?>

    <br>
    <button onclick="location.href='menu.php'">Volver al Menú Principal</button>
</body>
</html>
