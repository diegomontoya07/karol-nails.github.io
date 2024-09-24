<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/reserva.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <title>Reserva tu cita</title>
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
                    <li><a href="Contactanos.html">Contáctanos</a></li>
                    <li><a href="Busca-empleo.php">¿Buscas empleo?</a></li>
                    <li><a href="Admin.html">Admin</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <section class="wrapper">
        <section class="main">
            <h1>Agenda tu cita!</h1>
            <form action="procesar-cita.php" method="post">
                <label for="nombre">Nombre:</label><br>
                <input type="text" placeholder="Nombre" name="nombre" id="nombre" minlength="3" required><br>
            
                <label for="apellidos">Apellidos:</label><br>
                <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" minlength="3" required><br>
            
                <label for="edad">Edad:</label><br>
                <input type="number" placeholder="Edad" name="edad" id="edad" min="14" oninput="validarEdad(this)" required><br>
            
                <label for="telefono">Teléfono:</label><br>
                <input type="tel" placeholder="Teléfono" name="telefono" id="telefono" pattern="^\d{10}$" oninput="validarTelefono(this)" required><br>
            
                <label for="manicurista">Selecciona Manicurista:</label><br>
                <select id="manicurista" name="manicurista" onchange="mostrarDisponibilidad()" required>
                    <option value="">--Selecciona Manicurista--</option>
                    <?php include 'get_manicuristas.php'; ?>
                </select>

                <div id="disponibilidad" style="display: none;">
                    <label for="servicio">Selecciona el Servicio:</label><br>
                    <select id="servicio" name="servicio" onchange="mostrarHorasDisponibles()" required>
                        <option value="">--Selecciona Servicio--</option>
                        <option value="gel">Uñas en Gel (3h)</option>
                        <option value="acrigel">Uñas en Acrigel (3h)</option>
                        <option value="poligel">Uñas en Poligel (3h)</option>
                        <option value="acrilico">Uñas en Acrílico (5h)</option>
                        <option value="pressonn">Uñas Press Onn (3h)</option>
                        <option value="semipermanente">Uñas Semipermanentes (2.5h)</option>
                    </select>
            
                    <label for="fecha">Selecciona Fecha:</label><br>
                    <input type="date" id="fecha" name="fecha" onchange="mostrarHorasDisponibles()" required><br>
            
                    <label for="hora">Selecciona Hora:</label><br>
                    <select id="hora" name="hora" required><br><br>
                        <!-- Aquí se mostrarán las horas disponibles -->
                    </select>
            
                    <div id="hora-salida">
                        <!-- Aquí se mostrará la hora estimada de salida -->
                    </div>
                </div>
            
                <input type="submit" value="Agendar Cita" class="btn"><br>
            </form>

            <?php
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $apellidos = $_GET['apellidos'];
    $edad = $_GET['edad'];
    $telefono = $_GET['telefono'];
    $manicurista = $_GET['manicurista'];
    $servicio = $_GET['servicio'];
    $fecha = $_GET['fecha'];
    $hora = $_GET['hora'];

    echo "
    <div id='notificacion' class='notificacion'>
        <h2>Detalles de tu Cita</h2>
        <p>Nombre: $nombre</p>
        <p>Apellidos: $apellidos</p>
        <p>Edad: $edad</p>
        <p>Teléfono: $telefono</p>
        <p>Manicurista: $manicurista</p>
        <p>Servicio: $servicio</p>
        <p>Fecha: $fecha</p>
        <p>Hora: $hora</p>
        <button onclick='descargarComoImagen()'>Guardar como Imagen</button>
        <button onclick='descargarComoPDF()'>Guardar como PDF</button><br>
        <button onclick='cerrarNotificacion()'>OK</button>
    </div>";
}
?>
        </section>
    </section>
    <script>
        function validarEdad(input) {
            if (input.value < 14) {
                alert("La edad mínima es 14 años.");
                input.value = 14;
            }
        }

        function validarTelefono(input) {
            const pattern = /(.)\1{2,}/;
            if (input.value.length === 10 && pattern.test(input.value)) {
                alert("El número de teléfono no puede contener secuencias de dígitos repetidos.");
                input.value = '';
            }
        }

        document.getElementById('fecha').min = new Date().toISOString().split('T')[0];
    </script>
    <script src="assets/js/reserva.js"></script>
</body>
</html>
