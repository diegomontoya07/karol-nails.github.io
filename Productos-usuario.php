<?php
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

// Obtener los productos de la base de datos
$sql = "SELECT id, nombre, imagen, valor, descripcion FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <title>Productos</title>
    <link rel="stylesheet" href="assets/css/productos-usuario.css">
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
                    <li><a href="Productos-usuario.php">Productos</a></li>
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
            <h1>Productos</h1>
            <div class="productos-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Generar el enlace de WhatsApp con la imagen del producto y un mensaje predefinido
                        $mensaje = urlencode("Me interesaría saber más acerca de este producto: " . $row['nombre']);
                        $whatsappLink = "https://wa.me/573170974399?text=$mensaje";
                        ?>
                        <div class="producto-card">
                            <img src='assets/img/<?php echo $row['imagen']; ?>' alt='Imagen del producto'>
                            <h3><?php echo $row['nombre']; ?></h3>
                            <p><strong>Valor:</strong> $<?php echo $row['valor']; ?></p>
                            <p><strong>Descripción:</strong> <?php echo $row['descripcion']; ?></p>
                            <div class="btn">
                                <a href="<?php echo $whatsappLink; ?>" class="whatsapp-btn" target="_blank">Preguntar sobre producto</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No se encontraron productos.</p>";
                }
                $conn->close();
                ?>
            </div>
        </section>
    </section>
</body>
</html>
