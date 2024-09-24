<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/empleo.css">
    <title>Karol Nail's Studio</title>
    <script>
        function validarFormulario() {
            // Validar Nombre
            var nombre = document.getElementById("nombre").value;
            if (nombre.length < 3) {
                alert("El nombre debe tener al menos 3 caracteres.");
                return false;
            }

            // Validar Apellidos
            var apellidos = document.getElementById("apellidos").value;
            if (apellidos.length < 3) {
                alert("Los apellidos deben tener al menos 3 caracteres.");
                return false;
            }

            // Validar Cédula (solo números y sin secuencias)
            var cedula = document.getElementById("cedula").value;
            if (!/^\d+$/.test(cedula) || /(012|123|234|345|456|567|678|789|890|987|876|765|654|543|432|321|210)/.test(cedula)) {
                alert("La cédula debe contener solo números y no puede ser una secuencia.");
                return false;
            }

            // Validar Correo Electrónico (existencia y formato)
            var correo = document.getElementById("correo").value;
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!re.test(correo)) {
                alert("Por favor, introduce un correo electrónico válido.");
                return false;
            }

            // Si todas las validaciones pasan
            return true;
        }
    </script>
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
            <div class="color-rosaclaro">
                <h1>¿Quieres hacer parte de nosotros?</h1>
                <p>
                    En Karol Nail's Studio, estamos en constante crecimiento y siempre en la búsqueda de nuevos talentos que deseen unirse a nuestro equipo. Si estás interesado en formar parte de un ambiente de trabajo dinámico y profesional, y cumples con los siguientes requisitos, ¡nos encantaría conocerte!
                </p>
                <h2>Requisitos:</h2>
                <ul>
                    <li>Edad: Debes ser mayor de 18 años.</li>
                    <li>Certificaciones: Es indispensable contar con los siguientes certificados:
                        <ul>
                            <li>Curso de Uñas Acrílicas</li>
                            <li>Curso de Uñas Semipermanentes</li>
                            <li>Curso de Uñas Tradicionales</li>
                        </ul>
                    </li>
                    <li>Experiencia Laboral: Se requiere un mínimo de 2 años de experiencia en el sector de la manicura y pedicura.</li>
                </ul>
                <p>
                    En Karol Nail's Studio, valoramos el compromiso, la dedicación y la habilidad para ofrecer servicios de alta calidad. Si cumples con estos requisitos y estás listo para crecer con nosotros, no dudes en enviar tu solicitud. ¡Estamos ansiosos por conocerte y ver cómo puedes contribuir a nuestro equipo!
                </p>
            </div>
            <div class="color-blanco">
                <form action="empleos.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" placeholder="Nombre" name="nombre" id="nombre" required><br>

                    <label for="apellidos">Apellidos:</label><br>
                    <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" required><br>

                    <label for="cedula">Cédula:</label><br>
                    <input type="number" placeholder="Cédula" name="cedula" id="cedula" required><br>

                    <label for="correo">Correo electrónico:</label><br>
                    <input type="email" placeholder="Correo" name="correo" id="correo" required><br>

                   <label for="fotos">Sube fotos y videos de tus trabajos:</label><br>
                   <input type="file" name="fotos_videos[]" id="fotos_videos" accept="image/*, video/*" multiple><br><br>

                   <label for="hoja_vida">Sube tu hoja de vida (PDF):</label><br>
                   <input type="file" name="hoja_vida" id="hoja_vida" accept=".pdf" required><br><br>

                   <input type="submit" value="Enviar solicitud" class="btn"><br>
                </form>
            </div>
        </section>
        <?php if (isset($_GET['mensaje'])): ?>
        <div class="notificacion">
            <img src="assets/img/cara_feliz.png" alt="Cara Feliz">
            <p><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
            <button onclick="document.querySelector('.notificacion').style.display='none';">OK</button>
        </div>
        <?php endif; ?>
    </section>
    <br>
    <footer>
        <p>Karol Nail's Studio 2024</p>
        <br>
        <p>Karolnailsstudio2024@gmail.com</p>
    </footer>
</body>
</html>
