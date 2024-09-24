<?php
// Datos predeterminados para el administrador
$adminEmail = 'adminkarolnailsstudio@gmail.com';
$adminPassword = 'KarolN4ils5tudi0';

// Conexión a la base de datos (ajusta estos valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "karol_nails_studio";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Verificar si es el administrador
if ($correo === $adminEmail) {
    if ($contraseña === $adminPassword) {
        // Redirigir al panel de administración
        header("Location: inicio-admin.html");
        exit;
    } else {
        // Contraseña incorrecta para el administrador
        echo "Contraseña incorrecta para el administrador.";
        exit;
    }
}

// Si no es el administrador, verificar en la tabla de empleados
$sql = "SELECT rol, contraseña FROM empleados WHERE correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $rol = $row['rol'];
    $contraseñaBD = $row['contraseña'];

    // Verificar la contraseña
    if ($contraseña === $contraseñaBD) {
        // Redirigir según el rol
        if ($rol === 'manicurista') {
            header("Location: manicurista.html");
        } elseif ($rol === 'gerente') {
            header("Location: gerente.html");
        } else {
            echo "Rol desconocido.";
        }
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta.";
    }
} else {
    // Correo no encontrado
    echo "El correo ingresado no está registrado.";
}

// Cerrar la conexión
$conn->close();
?>
