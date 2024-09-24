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

// Verificar si la carpeta uploads/ existe, si no, crearla
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellidos = $conn->real_escape_string($_POST['apellidos']);
    $cedula = $conn->real_escape_string($_POST['cedula']);
    $correo = $conn->real_escape_string($_POST['correo']);
    
    // Manejo de la subida de archivos (fotos y videos)
    $fotos_videos = array();
    if (isset($_FILES['fotos_videos'])) {
        foreach ($_FILES['fotos_videos']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['fotos_videos']['name'][$key]);
            $file_tmp = $_FILES['fotos_videos']['tmp_name'][$key];
            $file_path = "uploads/" . uniqid() . "_" . $file_name; 

            if (move_uploaded_file($file_tmp, $file_path)) {
                $fotos_videos[] = $file_path;
            } else {
                die("Error subiendo archivo: " . $_FILES['fotos_videos']['name'][$key]);
            }
        }
    }
    $fotos_videos_serializado = implode(",", $fotos_videos);

    // Manejo del archivo PDF (hoja de vida)
    $hoja_vida = "";
    if (isset($_FILES['hoja_vida'])) {
        $file_name = basename($_FILES['hoja_vida']['name']);
        $file_tmp = $_FILES['hoja_vida']['tmp_name'];
        $hoja_vida = "uploads/" . uniqid() . "_" . $file_name;

        if (!move_uploaded_file($file_tmp, $hoja_vida)) {
            die("Error subiendo la hoja de vida.");
        }
    }

    // Inserción de los datos en la base de datos
    $sql = "INSERT INTO solicitudes_empleo (nombre, apellidos, cedula, correo, fotos_videos, hoja_vida)
            VALUES ('$nombre', '$apellidos', '$cedula', '$correo', '$fotos_videos_serializado', '$hoja_vida')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Muchas gracias por querer hacer parte de nosotros, pronto enviaremos una respuesta al correo electrónico.";
        header("Location: Busca-empleo.php?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        die("Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
}
?>
