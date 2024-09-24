<?php
// Asegúrate de tener una conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "karol_nails_studio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados por POST
$manicurista = $_POST['manicurista'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];

// Duración de los servicios en horas (puedes ajustar estos valores)
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
    echo json_encode([]);
    exit;
}

// Duración del servicio seleccionado
$duracionServicio = $duraciones[$servicio];

// Obtener las horas ya ocupadas en la fecha seleccionada para la manicurista
$sql = "SELECT hora FROM citas WHERE manicurista = ? AND fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $manicurista, $fecha);
$stmt->execute();
$result = $stmt->get_result();

$horasOcupadas = [];
while ($row = $result->fetch_assoc()) {
    $horasOcupadas[] = $row['hora'];
}

$stmt->close();

// Generar las horas disponibles según la duración del servicio
$horasDisponibles = [];
$horaInicio = 8; // Hora de inicio del trabajo (por ejemplo, 8:00 AM)
$horaFin = 18; // Hora de fin del trabajo (por ejemplo, 6:00 PM)

// Convertir la duración del servicio a un formato de horas decimales (ej: 2.5 horas)
$duracionDecimal = $duracionServicio;

for ($hora = $horaInicio; $hora <= $horaFin - $duracionDecimal; $hora += 0.5) {
    $horaFormateada = sprintf("%02d:%02d", floor($hora), ($hora - floor($hora)) * 60);
    
    // Verificar si la hora no está ocupada
    if (!in_array($horaFormateada, $horasOcupadas)) {
        $horasDisponibles[] = $horaFormateada;
    }
}

// Devolver las horas disponibles en formato JSON
echo json_encode($horasDisponibles);

$conn->close();
?>
