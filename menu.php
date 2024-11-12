
<?php // menu.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['mensaje_exito'])) {
    // Mostrar el mensaje
    echo "<p style='color: green;'>" . $_SESSION['mensaje_exito'] . "</p>";
    
    // Eliminar el mensaje de la sesión para que no se muestre nuevamente
    unset($_SESSION['mensaje_exito']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Control de Medicamentos</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

    <?php if ($_SESSION['userType'] === 'paciente'): ?>
        <button onclick="location.href='asignacion.php'">Ver Medicamentos</button>
        <button onclick="location.href='mensaje.php'">Escribir al Doctor</button>
    <?php else: ?>
        <button onclick="location.href='medicamentos.php'">Asignar Medicamentos</button>
        <button onclick="location.href='leer.php'">Ver Comentarios de Pacientes</button>
    <?php endif; ?>

    <button onclick="location.href='logout.php'">Cerrar Sesión</button> 

</body>
</html>
