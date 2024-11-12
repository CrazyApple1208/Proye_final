
<?php
$host = 'localhost';
$db = 'control_medicamentos';
$user = 'root'; // default user for XAMPP
$pass = ''; // default password for XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>