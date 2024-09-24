<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "karol_nails_studio";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$edad = $_POST['edad'];
$telefono = $_POST['telefono'];
$manicurista = $_POST['manicurista'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

// Duraciones de los servicios en horas
$duraciones = [
    'gel' => 3,
    'acrigel' => 3,
    'poligel' => 3,
    'acrilico' => 5,
    'pressonn' => 3,
    'semipermanente' => 2.5
];

// Validar que el servicio exista en el array de duraciones
if (!isset($duraciones[$servicio])) {
    die("Servicio inválido.");
}

// Duración del servicio seleccionado
$duracionServicio = $duraciones[$servicio];

// Calcular la hora de salida
$horaSalida = date('H:i', strtotime($hora) + ($duracionServicio * 3600));

// Verificar si hay conflictos de horario para la manicurista seleccionada
$sql = "SELECT * FROM citas WHERE manicurista = ? AND fecha = ? AND (
    (hora <= ? AND DATE_ADD(STR_TO_DATE(CONCAT(fecha, ' ', hora), '%Y-%m-%d %H:%i'), INTERVAL ? HOUR) > ?) OR
    (hora <= ? AND DATE_ADD(STR_TO_DATE(CONCAT(fecha, ' ', hora), '%Y-%m-%d %H:%i'), INTERVAL ? HOUR) > ?)
)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiiiis", $manicurista, $fecha, $hora, $duracionServicio, $hora, $hora, $duracionServicio, $horaSalida);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si hay citas que se solapan, no se puede agregar la nueva cita
    echo "La hora seleccionada no está disponible.";
} else {
    // Insertar los datos en la tabla citas
    $sql = "INSERT INTO citas (nombre, apellidos, edad, telefono, manicurista, servicio, fecha, hora) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $nombre, $apellidos, $edad, $telefono, $manicurista, $servicio, $fecha, $hora);

    if ($stmt->execute()) {
        // Redirigir de nuevo a la página de reservas con los datos de la cita en la URL
        header("Location: reserva.php?nombre=$nombre&apellidos=$apellidos&edad=$edad&telefono=$telefono&manicurista=$manicurista&servicio=$servicio&fecha=$fecha&hora=$hora");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
