<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Citas Agendadas</title>
    <link rel="stylesheet" href="assets/css/servicios-tabla.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
</head>
<body>
    <!-- Header con Navbar -->
    <header>
        <nav>
            <div class="nav-left">
                <ul>
                    <li><img src="assets/img/Logo4-sinfondo.png" alt="Logo de Karol Nail's Studio" height="50"><a href="gerente.html">Inicio</a></li>
                </ul>
            </div>
            <div class="nav-right">
                <ul>
                    <li><a href="servicios-tabla.php">Servicios(agenda)</a></li>
                    <li><a href="contratacion2.php">Contratacion</a></li>
                    <li><a href="productos-crud2.php">Productos</a></li>
                    <li><a href="Empleados2.php">Empleados</a></li>
                    <li><a href="hojas-de-vida2.php">Hojas de Vida</a></li>
                    <li><a href="index.html">Salir</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Tabla de Citas -->
    <div class="content">
        <h1>Citas Agendadas</h1>
        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "karol_nails_studio";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta SQL para obtener todas las citas
        $sql = "SELECT id, nombre, apellidos, edad, telefono, manicurista, servicio, fecha FROM citas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='citas-tabla'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>Edad</th><th>Teléfono</th><th>Manicurista</th><th>Servicio</th><th>Fecha</th></tr>";

            // Mostrar los datos en la tabla
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["nombre"] . "</td>
                        <td>" . $row["apellidos"] . "</td>
                        <td>" . $row["edad"] . "</td>
                        <td>" . $row["telefono"] . "</td>
                        <td>" . $row["manicurista"] . "</td>
                        <td>" . $row["servicio"] . "</td>
                        <td>" . $row["fecha"] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay citas agendadas.</p>";
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
