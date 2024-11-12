<?php
session_start();
include 'conexion.php';

if ($_SESSION['userType'] !== 'paciente') {
    header("Location: conexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];
    $doctor = $_POST['doctor']; // Doctor seleccionado
    $paciente = $_SESSION['username']; // Usamos 'paciente' para referirnos al nombre del usuario

    // Guardar el mensaje en la base de datos (cambiamos 'username' por 'paciente')
    $stmt = $pdo->prepare("INSERT INTO mensajes (paciente, doctor, mensaje) VALUES (?, ?, ?)");
    $stmt->execute([$paciente, $doctor, $comment]);

    echo "Comentario enviado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escribir al Doctor</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <h2>Escribe un mensaje al Doctor</h2>
    <form method="POST">
        <label for="doctor">Selecciona el Doctor:</label>
        <select id="doctor" name="doctor" required>
            <option value="Doctor1">Doctor1</option>
            <option value="Doctor2">Doctor2</option>
        </select>

        <label for="comment">Escribe tu comentario:</label>
        <textarea id="comment" name="comment" required></textarea>
        
        <button type="submit">Enviar</button>
    </form>

    <!-- Botón para regresar al menú principal -->
    <button onclick="location.href='menu.php'">Volver al Menú Principal</button>
</body>
</html>
