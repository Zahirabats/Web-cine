<?php
// Configuración de la conexión a la base de datos (XAMPP por defecto)
$servername = "localhost";
$username = "root";      
$password = "";          
$dbname = "proyecto_cine"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    // Detiene la ejecución y muestra el error si la conexión falla
    die("Conexión fallida: " . $conn->connect_error);
}
?>