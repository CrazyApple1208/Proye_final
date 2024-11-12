<?php
// medicamentos.php
session_start();
include 'conexion.php';

// Verificar que el usuario sea un doctor
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'doctor') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Paciente</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <h2>Seleccionar Paciente</h2>

    <form method="POST" action="asignar_medicamento.php">
        <label for="paciente">Seleccionar Paciente:</label>
        <select name="paciente" id="paciente" required>
            <option value="">--Selecciona un paciente--</option>
            <?php
            // Obtener la lista de pacientes desde la base de datos
            $stmt = $pdo->prepare("SELECT username FROM usuarios WHERE tipo = 'paciente'");
            $stmt->execute();
            $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($pacientes as $paciente) {
                echo "<option value='" . htmlspecialchars($paciente['username']) . "'>" . htmlspecialchars($paciente['username']) . "</option>";
            }
            ?>
        </select>

        <button type="submit">Asignar Medicamento</button>
    </form>

    <br>
    <button onclick="location.href='menu.php'">Volver al Menú Principal</button>
</body>
</html>
