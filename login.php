
<?php // login.php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['tipoUsuario'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ? AND tipo = ?");
    $stmt->execute([$username, $password, $userType]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['username'] = $username;
        $_SESSION['userType'] = $userType;
        header("Location: menu.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Medicamentos - Login</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>
    <form method="POST" action="login.php">
        <h2>Iniciar Sesión</h2>
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="tipoUsuario">Tipo de usuario:</label>
        <select name="tipoUsuario">
            <option value="paciente">Paciente</option>
            <option value="doctor">Doctor</option>
        </select>

        <button type="submit">Ingresar</button>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>
