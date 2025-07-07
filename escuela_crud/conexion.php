<?php
$host = "localhost";
$usuario = "root"; // Usuario por defecto de XAMPP
$password = "";     // Contraseña por defecto de XAMPP (vacía)
$base_de_datos = "escuela";

// Crear conexión
$conn = new mysqli($host, $usuario, $password, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>