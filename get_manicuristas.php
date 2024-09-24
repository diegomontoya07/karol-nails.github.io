<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si usas otro usuario
$password = ""; // Cambia esto si usas una contraseña
$dbname = "karol_nails_studio"; // Cambia esto si es necesario

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los manicuristas
$sql = "SELECT id, nombre FROM empleados WHERE rol = 'manicurista'";
$result = $conn->query($sql);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Recorre los resultados y genera las opciones
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
    }
} else {
    echo "<option value=''>No hay manicuristas disponibles</option>";
}

$conn->close();
?>
