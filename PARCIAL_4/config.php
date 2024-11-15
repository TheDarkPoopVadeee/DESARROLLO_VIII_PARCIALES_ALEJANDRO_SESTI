<?php
session_start();

$clientID = '';
$clientSecret = '';
$redirectUri = 'http://localhost/ParcialBiblioteca/login.php';
$tockenRevocationUrl = "https://oauth2.googleapis.com/revoke";

$host = 'localhost';
$dbname = 'parcial_biblioteca';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
