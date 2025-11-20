<?php
// Incluye la conexión
include 'conexion.php'; 

// Consulta para seleccionar todos los datos relevantes de la tabla Socio
$sql = "SELECT id_socio, nombre, apellido, dni, email, telefono FROM Socio";
$result = $conn->query($sql); // Ejecuta la consulta

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Socios</title>
</head>
<body>

    <h1>Socios Registrados en Proyecto Cine</h1>
    <p><a href="registro_socio.html">Registrar un nuevo Socio</a></p>
    <hr>

    <?php
    // Verifica si se encontraron filas (socios)
    if ($result->num_rows > 0) {
        // Estructura básica de la tabla HTML
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<thead><tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Teléfono</th>
              </tr></thead>";
        echo "<tbody>";
        
        // Itera sobre cada fila (socio) encontrada y la muestra en una fila de tabla
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_socio"]. "</td>";
            echo "<td>" . $row["nombre"]. "</td>";
            echo "<td>" . $row["apellido"]. "</td>";
            echo "<td>" . $row["dni"]. "</td>";
            echo "<td>" . $row["email"]. "</td>";
            echo "<td>" . $row["telefono"]. "</td>";
            echo "</tr>";
        }
        
        echo "</tbody></table>";
    } else {
        echo "<p>No hay socios registrados en la base de datos.</p>";
    }
    
    // Cierra la conexión a la base de datos
    $conn->close();
    ?>

</body>
</html>