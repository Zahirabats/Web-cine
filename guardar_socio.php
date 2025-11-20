<?php
// Incluye el archivo de conexión
include 'conexion.php'; 

// Verifica que el método de la solicitud sea POST (envío del formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recoge y limpia los datos del formulario (aunque mysqli::prepare ya ofrece seguridad)
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    
    // Prepara la consulta SQL para insertar en la tabla Socio
    // Es CRÍTICO usar prepared statements (?) para prevenir inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO Socio (nombre, apellido, dni, email, telefono) VALUES (?, ?, ?, ?, ?)");
    
    // Vincula los parámetros: "sssss" indica que los 5 valores son strings
    $stmt->bind_param("sssss", $nombre, $apellido, $dni, $email, $telefono);

    // Ejecuta la inserción
    if ($stmt->execute()) {
        echo "<h1>¡Registro de Socio Exitoso!</h1>";
        echo "<p>El socio '$nombre $apellido' ha sido agregado correctamente.</p>";
        echo '<p><a href="ver_socios.php">Ver la lista de socios</a></p>';
    } else {
        echo "<h1>Error al Registrar Socio</h1>";
        // Muestra el error específico, por ejemplo, si el DNI ya existe (UNIQUE)
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Cierra el statement y la conexión
    $stmt->close();
    $conn->close();

} else {
    // Si alguien intenta acceder directamente a este archivo sin enviar el formulario
    header("Location: registro_socio.html");
    exit();
}
?>