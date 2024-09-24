<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <title>Registro</title>
    <link rel="stylesheet" href="assets/css/registro.css">
</head>
<body>
    <header>
    <nav>
            <div class="nav-left">
                <ul>
                    <li><img src="assets/img/Logo4-sinfondo.png" alt="Logo de Karol Nail's Studio" height="50"><a href="index.html">Inicio</a></li>
                </ul>
            </div>
            <div class="nav-right">
                <ul>
                    <li><a href="Nosotros.html">Nosotros</a></li>
                    <li><a href="registro.php">Productos</a></li>
                    <li><a href="Reserva.php">Reserva tu cita</a></li>
                    <li><a href="Contactanos.html">Contactanos</a></li>
                    <li><a href="Busca-empleo.php">Buscas empleo?</a></li>
                    <li><a href="Admin.html">Admin</a></li>
                </ul>
            </div>
        </nav>
    </header>

<section class="wrapper">
    <section class="main">
    <h1>Registro de Usuario</h1>
        <form action="registro.php" method="post">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required><br>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email"><br>

            <input type="submit" name="register" value="Registrar">
        </form>

        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>

    </section>
</section>


    <?php
    if (isset($_POST['register'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "karol_nails_studio";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $user = $_POST['username'];
        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar la contraseña
        $email = $_POST['email'];

        $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$user', '$pass', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
