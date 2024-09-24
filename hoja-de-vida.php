<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/hojavida.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <title>Hojas de vida</title>
</head>
<body>
<header>
    <nav>
        <div class="nav-left">
            <ul>
                <li><img src="assets/img/Logo4-sinfondo.png" alt="Logo de Karol Nail's Studio" height="50"><a href="inicio-admin.html">Inicio</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="contratacion1.php">Contratacion</a></li>
                <li><a href="productos-crud.php">Productos</a></li>
                <li><a href="Empleados.php">Empleados</a></li>
                <li><a href="hoja-de-vida.php">Hojas de Vida</a></li>
                <li><a href="index.html">Salir</a></li>
            </ul>
        </div>
    </nav>
</header>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "karol_nails_studio"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la lista de solicitudes de empleo, ordenadas por fecha_envio más reciente
$sql = "SELECT id, nombre, apellidos, correo, fotos_videos, hoja_vida, fecha_envio FROM solicitudes_empleo ORDER BY fecha_envio DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Archivos de Solicitudes de Empleo</h1>";
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Fotos/Videos</th>
                <th>Hoja de Vida</th>
                <th>Acciones</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $fotos_videos = explode(",", $row['fotos_videos']);
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellidos']}</td>
                <td>{$row['correo']}</td>
                <td>";

        foreach ($fotos_videos as $file_path) {
            if (!empty($file_path)) {
                $file_name = basename($file_path);
                echo "<a href='$file_path' target='_blank'>$file_name</a><br>";
            }
        }

        echo "</td>
              <td><a href='{$row['hoja_vida']}' target='_blank'>Ver PDF</a></td>
              <td><a href='download.php?file=" . urlencode($row['hoja_vida']) . "'>Descargar Hoja de Vida</a>";

        foreach ($fotos_videos as $file_path) {
            if (!empty($file_path)) {
                echo "<br><a href='download.php?file=" . urlencode($file_path) . "'>Descargar $file_path</a>";
            }
        }

        echo "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron registros.";
}

$conn->close();
?>
</body>
</html>
