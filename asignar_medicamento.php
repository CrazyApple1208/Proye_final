<?php
session_start();
include 'conexion.php';

// Verificar que el usuario sea un doctor
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Verificar si se recibió el nombre del paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente'])) {
    $paciente = $_POST['paciente'];

    // Validar que el paciente exista en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? AND tipo = 'paciente'");
    $stmt->execute([$paciente]);
    $paciente_existente = $stmt->fetch();

    if (!$paciente_existente) {
        echo "Paciente no encontrado.";
        exit();
    }
} else {
    echo "No se ha seleccionado un paciente.";
    exit();
}

// Procesar la asignación de medicamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['medicamento'])) {
    $medicamento_id = $_POST['medicamento'];

    // Verificar que el medicamento exista
    $stmt = $pdo->prepare("SELECT * FROM medicamentos WHERE id = ?");
    $stmt->execute([$medicamento_id]);
    $medicamento_existente = $stmt->fetch();

    if (!$medicamento_existente) {
        echo "Medicamento no encontrado.";
        exit();
    }

    // Insertar la asignación en la base de datos
    $stmt = $pdo->prepare("INSERT INTO asignaciones (paciente_nombre, medicamento_id) VALUES (?, ?)");
    try {
        $stmt->execute([$paciente, $medicamento_id]);

        // Guardar el mensaje de éxito en la sesión
        $_SESSION['mensaje_exito'] = "Medicamento asignado exitosamente a " . htmlspecialchars($paciente) . ".";

        // Redirigir al menú principal
        header("Location: menu.php");  
        exit();  // Asegura que no se ejecute más código después de la redirección
    } catch (PDOException $e) {
        echo "Error al asignar el medicamento: " . $e->getMessage();
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Medicamento a <?php echo htmlspecialchars($paciente); ?></title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <h2>Asignar Medicamento a <?php echo htmlspecialchars($paciente); ?></h2>

    <form method="POST" action="asignar_medicamento.php">
        <input type="hidden" name="paciente" value="<?php echo htmlspecialchars($paciente); ?>">

        <label for="medicamento">Seleccionar Medicamento:</label>
        <select name="medicamento" id="medicamento" required>
            <option value="">--Selecciona un medicamento--</option>
            <?php
            // Obtener los medicamentos desde la base de datos
            $stmt = $pdo->query("SELECT * FROM medicamentos");
            while ($med = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($med['id']) . "'>" . htmlspecialchars($med['nombre']) . "</option>";
            }
            ?>
        </select>

        <button type="submit">Asignar Medicamento</button>
    </form>

    <br>
    <button onclick="location.href='medicamentos.php'">Asignar Otro Medicamento</button>
    <button onclick="location.href='menu.php'">Volver al Menú Principal</button>
</body>
</html>
