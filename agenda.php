<?php
include 'conexion.php';

// Obtener todas las citas
$sql = "SELECT * FROM citas ORDER BY fecha, hora";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Citas</title>
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/agenda.css"> <!-- Asegúrate de tener un archivo CSS para estilos -->
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <ul>
                    <li><img src="assets/img/Logo4-sinfondo.png" alt="Logo de Karol Nail's Studio" height="50"><a href="manicurista.html">Inicio</a></li>
                </ul>
            </div>
            <div class="nav-right">
                <ul>
                    <li><a href="agenda.php">Agenda</a></li>
                    <li><a href="index.html">Salir</a></li>
                </ul>
            </div>
        </nav>
    </header>

<main>
    <h1>Agenda de Citas</h1>
    
    <?php
    $currentDate = '';
    $citasByDate = [];
    
    // Organizar citas por fecha
    while ($cita = $result->fetch_assoc()) {
        $date = $cita['fecha'];
        if (!isset($citasByDate[$date])) {
            $citasByDate[$date] = [];
        }
        $citasByDate[$date][] = $cita;
    }
    
    // Mostrar citas agrupadas por fecha
    foreach ($citasByDate as $date => $citas) {
        echo "<h2>Fecha: " . htmlspecialchars($date) . "</h2>";
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Apellidos</th><th>Edad</th><th>Teléfono</th><th>Manicurista</th><th>Servicio</th><th>Hora</th></tr>";
        
        foreach ($citas as $cita) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($cita['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($cita['apellidos']) . "</td>";
            echo "<td>" . htmlspecialchars($cita['edad']) . "</td>";
            echo "<td>" . htmlspecialchars($cita['telefono']) . "</td>";
            echo "<td>" . htmlspecialchars($cita['manicurista']) . "</td>";
            echo "<td>" . htmlspecialchars($cita['servicio']) . "</td>";
            echo "<td>" . htmlspecialchars($cita['hora']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
    ?>
</main>
</body>
</html>

<?php
$conn->close();
?>
