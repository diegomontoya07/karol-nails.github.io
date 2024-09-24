<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['tel'];
    $curso = $_POST['curso'];
    $tipo_documento = $_POST['tipo_documento'];
    $documento = $_POST['documento'];
    $genero = $_POST['genero'];
    $ciudad = $_POST['ciudad'];

    $errores = [];

    if (strlen($nombre) < 3) {
        $errores[] = "El nombre debe tener al menos 3 caracteres.";
    }
    if (strlen($apellidos) < 3) {
        $errores[] = "Los apellidos deben tener al menos 3 caracteres.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
        $errores[] = "Debe ingresar un correo electrónico válido de Gmail.";
    }
    if (!preg_match('/^\d{10}$/', $telefono) || preg_match('/(\d)\1{3,}/', $telefono)) {
        $errores[] = "Debe ingresar un número de teléfono válido.";
    }
    if (!preg_match('/^\d{10}$/', $documento)) {
        $errores[] = "Debe ingresar un número de documento válido.";
    }

    if (empty($errores)) {
        $sql = "INSERT INTO inscripciones (nombre, apellidos, email, telefono, curso, tipo_documento, documento, genero, ciudad) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $nombre, $apellidos, $email, $telefono, $curso, $tipo_documento, $documento, $genero, $ciudad);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errores[] = "Error al registrar la inscripción. Por favor, intenta de nuevo.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/inscripcion.css">
    <title>Inscripción</title>
</head>

<body>
    <header>
        <nav>
            <div class="nav-left">
                <ul>
                    <li><img src="assets/img/Logo4-sinfondo.png" alt="Logo de Karol Nail's Studio" height="50"><a href="cursos.html">Atrás</a></li>
                </ul>
            </div>
            <div class="nav-right">
                <ul>
                    <li><a href="Nosotros.html">Nosotros</a></li>
                    <li><a href="Productos-usuario.php">Productos</a></li>
                    <li><a href="Reserva.php">Reserva tu cita</a></li>
                    <li><a href="Contactanos.html">Contáctanos</a></li>
                    <li><a href="Busca-empleo.php">Buscas empleo?</a></li>
                    <li><a href="Admin.html">Admin</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section class="wrapper">
        <section class="main">
            <h1>¡Inscríbete!</h1>

            <!-- Mostrar errores si los hay -->
            <?php if (!empty($errores)): ?>
            <div class="notification error">
                <ul>
                    <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Mostrar mensaje de éxito si el registro fue correcto -->
            <?php if (isset($success)): ?>
            <div class="notification success" id="successNotification">
                <h2>¡Inscripción realizada con éxito!</h2>
                <p>Nombre: <?php echo htmlspecialchars($nombre); ?></p>
                <p>Apellidos: <?php echo htmlspecialchars($apellidos); ?></p>
                <p>Email: <?php echo htmlspecialchars($email); ?></p>
                <p>Teléfono: <?php echo htmlspecialchars($telefono); ?></p>
                <p>Curso: <?php echo htmlspecialchars($curso); ?></p>
                <p>Documento: <?php echo htmlspecialchars($tipo_documento) . " " . htmlspecialchars($documento); ?></p>
                <p>Recuerda que debes ir a pagar tu inscripción en la sede y las clases se van pagando cada clase.</p>
                <button onclick="downloadAsImage()">Descargar como imagen</button>
                <button onclick="downloadAsPDF()">Descargar como PDF</button>
                <button onclick="hideNotification()">OK</button>
            </div>
            <?php endif; ?>

            <form action="inscripcion.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" placeholder="Nombre" id="nombre" name="nombre" required><br><br>
                <label for="apellidos">Apellidos:</label>
                <input type="text" placeholder="Apellidos" id="apellidos" name="apellidos" required><br><br>
                <label for="email">Email:</label>
                <input type="email" placeholder="Email" id="email" name="email" required><br><br>
                <label for="tel">Teléfono:</label>
                <input type="tel" placeholder="Teléfono" id="tel" name="tel" maxlength="10" required><br><br>
                <label for="curso">Tipo de Curso:</label>
                <select name="curso" id="curso" required>
                    <option value="acrilico">Acrílico</option>
                    <option value="semipermanente">Semipermanente</option>
                    <option value="tradicional">Tradicional</option>
                </select><br><br>
                <label for="tipo_documento">Tipo de Documento:</label>
                <select name="tipo_documento" id="tipo_documento" required>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="CC">Cédula Ciudadanía</option>
                    <option value="CE">Cédula de Extranjería</option>
                </select><br><br>
                <label for="documento">Número de Documento:</label>
                <input type="text" placeholder="Documento" id="documento" name="documento" pattern="[0-9]{10}" title="Debe contener 10 dígitos" required><br><br>
                <label for="genero">Género:</label>
                <select name="genero" id="genero" required>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                </select><br><br>
                <label for="ciudad">Ciudad de residencia:</label>
                <select name="ciudad" id="ciudad" required>
                    <option value="cali">Cali</option>
                    <option value="medellin">Medellín</option>
                    <option value="bogota">Bogotá</option>
                </select><br><br>

                <input type="submit" value="Enviar" class="btn">
            </form>
        </section>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="assets/js/inscripcion.js"></script>
</body>

</html>
