
<?php // seleccionar.php
session_start();
include 'conexion.php';

if ($_SESSION['userType'] !== 'doctor') {
    header("Location: menu.php");
    exit();
}

// Lista de usuarios a los que se puede asignar medicamentos
$pacientes = ['Diego', 'Laura', 'Fernando'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Paciente</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <h2>Selecciona un Paciente</h2>
    <form method="POST" action="medicamentos.php">
        <label for="paciente">Paciente:</label>
        <select id="paciente" name="paciente" required>
            <?php foreach ($pacientes as $paciente): ?>
                <option value="<?= htmlspecialchars($paciente) ?>"><?= htmlspecialchars($paciente) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Continuar</button>
    </form>
    <button onclick="location.href='menu.php'">Volver al Menú Principal</button>
</body>
</html>
