<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/contratacion.css">
    <title>Contratacion</title>
</head>
<body>
    <?php
    if (isset($_GET['message']) && isset($_GET['type'])): 
        $message = htmlspecialchars($_GET['message']);
        $messageType = htmlspecialchars($_GET['type']);
    ?>
    <div class="notification <?php echo $messageType; ?>" id="notification">
        <?php if ($messageType == "success"): ?>
            <img src="assets/img/verde.png" alt="Success">
        <?php else: ?>
            <img src="assets/img/rojo.png" alt="Error">
        <?php endif; ?>
        <p><?php echo $message; ?></p>
        <button id="ok-button">OK</button>
    </div>
    <?php endif; ?>

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
                    <li><a href="empleados.php">Empleados</a></li>
                    <li><a href="hoja-de-vida.php">Hojas de Vida</a></li>
                    <li><a href="index.html">Salir</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section class="wrapper">
        <section class="main">
            <form action="contratacion.php" method="post" onsubmit="return validateForm()">
                <label for="nombre">Nombre:</label><br>
                <input type="text" placeholder="Nombre" name="nombre" id="nombre" minlength="7" required><br>

                <label for="correo">Correo:</label><br>
                <input type="email" placeholder="Correo" name="correo" id="correo" required><br>

                <label for="rol">Rol:</label><br>
                <select name="rol" id="rol">
                    <option value="manicurista">Manicurista</option>
                    <option value="gerente">Gerente</option>
                </select><br>

                <label for="salario">Salario:</label><br>
                <input type="text" placeholder="Salario" name="salario" id="salario" onkeypress="return isNumberKey(event)" required><br>

                <label for="contraseña">Contraseña:</label><br>
                <input type="password" placeholder="Contraseña" name="contraseña" id="contraseña" minlength="8" required oninput="checkPasswordStrength()"><br>
                <div id="password-strength"></div><br>

                <input type="submit" value="Enviar" class="btn">
            </form>
        </section>
    </section>

    <footer>
        <p>Karol Nail's Studio 2024</p>
        <br>
        <p>Karolnailsstudio2024@gmail.com</p>
    </footer>

    <script>
        function validateForm() {
            const nombre = document.getElementById('nombre').value;
            const correo = document.getElementById('correo').value;
            const salario = document.getElementById('salario').value;
            const contraseña = document.getElementById('contraseña').value;

            // Validar nombre (mínimo 7 caracteres)
            if (nombre.length < 7) {
                alert("El nombre debe tener al menos 7 caracteres.");
                return false;
            }

            // Validar correo electrónico con expresión regular simple
            const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!correoRegex.test(correo)) {
                alert("Por favor, introduce un correo electrónico válido.");
                return false;
            }

            // Validar salario (solo números)
            if (isNaN(salario)) {
                alert("El salario debe contener solo números.");
                return false;
            }

            // Validar contraseña
            const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
            const sequentialRegex = /(012|123|234|345|456|567|678|789|890|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/i;
            if (!passwordRegex.test(contraseña) || sequentialRegex.test(contraseña)) {
                alert("La contraseña debe tener al menos 8 caracteres, una mayúscula, un número, un símbolo y no debe contener secuencias.");
                return false;
            }

            return true;
        }

        function isNumberKey(evt) {
            const charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function checkPasswordStrength() {
            const strengthBar = document.getElementById('password-strength');
            const password = document.getElementById('contraseña').value;
            let strength = 0;

            if (password.match(/[A-Z]/)) strength += 1; // Tiene una mayúscula
            if (password.match(/[a-z]/)) strength += 1; // Tiene una minúscula
            if (password.match(/\d/)) strength += 1; // Tiene un número
            if (password.match(/[!@#$%^&*]/)) strength += 1; // Tiene un símbolo
            if (password.length >= 8) strength += 1; // Es de al menos 8 caracteres

            if (strength <= 2) {
                strengthBar.style.width = "100%";
                strengthBar.style.backgroundColor = "red";
                strengthBar.textContent = "Muy débil";
            } else if (strength == 3) {
                strengthBar.style.width = "100%";
                strengthBar.style.backgroundColor = "orange";
                strengthBar.textContent = "Aceptable";
            } else if (strength > 3) {
                strengthBar.style.width = "100%";
                strengthBar.style.backgroundColor = "green";
                strengthBar.textContent = "Fuerte";
            }
        }
    </script>
        <script src="assets/js/contratacion.js"></script>
</body>
</html>
