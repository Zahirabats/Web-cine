<?php
session_start();
include 'conexion.php'; 
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email_ingresado = $_POST['email'] ?? '';
    $pass_ingresada = $_POST['pass'] ?? '';
    
    // Buscar usuario por email (asumiendo que es UNIQUE)
    $stmt = $conn->prepare("SELECT id_socio, nombre, apellido, email, pass_hash FROM Socio WHERE email = ?");
    $stmt->bind_param("s", $email_ingresado);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $socio = $result->fetch_assoc();
        $pass_hash_almacenado = $socio['pass_hash'];

        // Verificación de la contraseña hasheada
        if (password_verify($pass_ingresada, $pass_hash_almacenado)) {
            
            // Login Exitoso: Iniciar Sesión PHP
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['id_socio'] = $socio['id_socio'];
            $_SESSION['nombre_socio'] = $socio['nombre'] . " " . $socio['apellido'];
            
            // Determinar si es Admin (simulado si el email coincide con el de admin)
            $role = ($socio['email'] === 'admin@movie.com') ? 'admin' : 'user';

            echo json_encode([
                'success' => true,
                'nombre' => $socio['nombre'],
                'role' => $role
            ]);
            
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
        }
        
    } else {
        echo json_encode(['success' => false, 'message' => 'Email no registrado.']);
    }

    $stmt->close();
    $conn->close();

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>