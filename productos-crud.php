<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/productos-crud.css">
    <title>Gestión de Productos</title>
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

    <section class="wrapper">
        <section class="main">
            <h1>Gestión de Productos</h1>

            <!-- Formulario para añadir productos -->
            <h2>Añadir Nuevo Producto</h2>
            <form action="productos-crud.php" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" name="nombre" id="nombre" required><br>

                <label for="imagen">Imagen del Producto:</label>
                <input type="file" name="imagen" id="imagen" required><br>

                <label for="valor">Valor del Producto:</label>
                <input type="number" name="valor" id="valor" required><br>

                <label for="descripcion">Descripción del Producto:</label>
                <textarea name="descripcion" id="descripcion" rows="4" required></textarea><br>

                <input type="submit" name="add" value="Añadir Producto">
            </form>

            <!-- Barra de búsqueda -->
            <h2>Buscar Productos</h2>
            <form action="productos-crud.php" method="get">
                <input type="text" name="search" placeholder="Buscar por nombre del producto" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <input type="submit" value="Buscar">
            </form>

            <!-- Mostrar productos en formato de tarjetas -->
            <h2>Lista de Productos</h2>
            <div class="productos-container">
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

                // Añadir producto
                if (isset($_POST['add'])) {
                    $nombre = $_POST['nombre'];
                    $valor = $_POST['valor'];
                    $descripcion = $_POST['descripcion'];

                    // Subir imagen
                    $imagen = $_FILES['imagen']['name'];
                    $target = "assets/img/" . basename($imagen);
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $target);

                    // Insertar producto en la base de datos
                    $sql = "INSERT INTO productos (nombre, imagen, valor, descripcion) VALUES ('$nombre', '$imagen', '$valor', '$descripcion')";

                    if ($conn->query($sql) === TRUE) {
                        

                        header("Location: productos-crud.php");
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }

                // Eliminar producto
                if (isset($_GET['delete'])) {
                    $id = intval($_GET['delete']);
                    $sql_delete = "DELETE FROM productos WHERE id = $id";
                    if ($conn->query($sql_delete) === TRUE) {
                        
                        header("Location: productos-crud.php");
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }

                // Editar producto
                if (isset($_GET['edit'])) {
                    $id = intval($_GET['edit']);
                    $sql = "SELECT * FROM productos WHERE id = $id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $producto = $result->fetch_assoc();
                        ?>
                        <h2>Editar Producto</h2>
                        <form action="productos-crud.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                            <label for="nombre">Nombre del Producto:</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" required><br>

                            <label for="imagen">Imagen del Producto:</label>
                            <input type="file" name="imagen" id="imagen"><br>

                            <label for="valor">Valor del Producto:</label>
                            <input type="number" name="valor" id="valor" value="<?php echo $producto['valor']; ?>" required><br>

                            <label for="descripcion">Descripción del Producto:</label>
                            <textarea name="descripcion" id="descripcion" rows="4" required><?php echo $producto['descripcion']; ?></textarea><br>

                            <input type="submit" name="update" value="Actualizar Producto">
                        </form>
                        <?php
                    } else {
                        echo "Producto no encontrado.";
                    }
                }

                // Actualizar producto
                if (isset($_POST['update'])) {
                    $id = $_POST['id'];
                    $nombre = $_POST['nombre'];
                    $valor = $_POST['valor'];
                    $descripcion = $_POST['descripcion'];

                    $imagen = $_FILES['imagen']['name'];
                    if ($imagen) {
                        $target = "assets/img/" . basename($imagen);
                        move_uploaded_file($_FILES['imagen']['tmp_name'], $target);
                        $sql_update = "UPDATE productos SET nombre='$nombre', imagen='$imagen', valor='$valor', descripcion='$descripcion' WHERE id=$id";
                    } else {
                        $sql_update = "UPDATE productos SET nombre='$nombre', valor='$valor', descripcion='$descripcion' WHERE id=$id";
                    }

                    if ($conn->query($sql_update) === TRUE) {
                        
                        // Redirigir para evitar el reenvío del formulario
                        header("Location: productos-crud.php");
                        exit();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }

                // Buscar productos
                $search_query = '';
                if (isset($_GET['search'])) {
                    $search_query = $_GET['search'];
                }

                $sql = "SELECT id, nombre, imagen, valor, descripcion FROM productos WHERE nombre LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="producto-card">
                            <img src='assets/img/<?php echo $row['imagen']; ?>' alt='Imagen del producto'>
                            <h3><?php echo $row['nombre']; ?></h3>
                            <p><strong>Valor:</strong> $<?php echo $row['valor']; ?></p>
                            <p><strong>Descripción:</strong> <?php echo $row['descripcion']; ?></p>
                            <div class="action-buttons">
                                <a href='productos-crud.php?edit=<?php echo $row['id']; ?>' class='edit-btn'>Editar</a>
                                <a href='productos-crud.php?delete=<?php echo $row['id']; ?>' class='delete-btn' onclick='return confirm("¿Estás seguro de que deseas eliminar este producto?")'>Eliminar</a>
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
