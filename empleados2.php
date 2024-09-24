<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/empleados.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <title>Empleados</title>
</head>
<body>
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

// Eliminar empleado
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql_delete = "DELETE FROM empleados WHERE id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<p>Empleado eliminado con éxito.</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Editar empleado
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = "SELECT * FROM empleados WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $empleado = $result->fetch_assoc();
    } else {
        echo "Empleado no encontrado.";
    }
}

// Actualizar empleado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $salario = $_POST['salario'];
    $contraseña = $_POST['contraseña'];

    $sql_update = "UPDATE empleados SET nombre='$nombre', correo='$correo', rol='$rol', salario='$salario', contraseña='$contraseña' WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<p>Empleado actualizado con éxito.</p>";
        // Redirigir para evitar el reenvío del formulario
        header("Location: empleados2.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener la lista de empleados
$sql = "SELECT id, nombre, correo, rol, salario, contraseña FROM empleados";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Lista de Empleados</h1>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Salario</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['correo']}</td>
                <td>{$row['rol']}</td>
                <td>{$row['salario']}</td>
                <td>{$row['contraseña']}</td>
                <td>
                    <a href='empleados2.php?edit=" . $row['id'] . "'>Editar</a>
                    <a href='empleados2.php?delete=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este empleado?\")'>Eliminar</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron registros.";
}

$conn->close();
?>

<?php if (isset($empleado)): ?>
<section class="wrapper">
<section class="main">

<form method="post" action="">
<h2>Editar Empleado</h2>
    <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo $empleado['nombre']; ?>" required><br>
    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo" value="<?php echo $empleado['correo']; ?>" required><br>
    <label for="rol">Rol:</label>
    <input type="text" name="rol" id="rol" value="<?php echo $empleado['rol']; ?>" required><br>
    <label for="salario">Salario:</label>
    <input type="number" name="salario" id="salario" value="<?php echo $empleado['salario']; ?>" required><br>
    <label for="contrasena">Contraseña:</label>
    <input type="text" name="contraseña" id="contraseña" value="<?php echo $empleado['contraseña']; ?>" required><br>
    <input type="submit" name="update" value="Actualizar">
</form>
</section>
</section>   
<?php endif; ?>
</body>
</html>
