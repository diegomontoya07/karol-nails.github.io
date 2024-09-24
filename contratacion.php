<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root"; // Asegúrate de cambiar esto si usas otro usuario
$password = ""; // Asegúrate de cambiar esto si usas una contraseña
$dbname = "karol_nails_studio";// Cambia esto si es necesario

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $salario = $_POST['salario'];
    $contraseña = $_POST['contraseña'];

    // Valida los datos
    if (empty($nombre) || empty($correo) || empty($rol) || empty($salario) || empty($contraseña)) {
        header('Location: contratacion1.php?message=Todos los campos son obligatorios.&type=error');
        exit();
    } else {
        // Inserta los datos en la base de datos
        $stmt = $conn->prepare("INSERT INTO empleados (nombre, correo, rol, salario, contraseña) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $correo, $rol, $salario, $contraseña);

        if ($stmt->execute()) {
            header('Location: contratacion1.php?message=Usuario registrado correctamente.&type=success');
        } else {
            header('Location: contratacion1.php?message=No se pudo registrar el usuario. Intenta de nuevo.&type=error');
        }

        $stmt->close();
    }

    $conn->close();
}
?>
