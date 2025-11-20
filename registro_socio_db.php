<?php
include 'conexion.php'; 
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtenemos los datos del formulario de registro
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass_plana = $_POST['pass'] ?? '';

    // Dejamos los campos no requeridos en el registro como vacíos
    $apellido = '';
    $dni = ''; 
    $telefono = ''; 
    
    // Seguridad: Hashear la contraseña antes de guardarla
    $pass_hasheada = password_hash($pass_plana, PASSWORD_DEFAULT);

    // Consulta INSERT INTO Socio, incluyendo la nueva columna 'pass_hash'
    $stmt = $conn->prepare("INSERT INTO Socio (nombre, apellido, dni, email, telefono, pass_hash) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellido, $dni, $email, $telefono, $pass_hasheada);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => '¡Registro exitoso!']);
    } else {
        http_response_code(500); 
        echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} else {
    http_response_code(405); 
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>