<?php
session_start();
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

if (isset($_POST['producto_id'])) {
    $producto_id = intval($_POST['producto_id']);
    $user_id = $_SESSION['user_id']; 

    // Aquí puedes agregar la lógica para manejar la compra, por ejemplo, actualizar el stock, registrar la compra en una tabla, etc.
    // A modo de ejemplo, simplemente eliminamos el producto del carrito después de "comprar"
    $sql = "DELETE FROM carrito WHERE user_id = ? AND producto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $producto_id);
    if ($stmt->execute()) {
        echo "Compra realizada con éxito.";
    } else {
        echo "Error al realizar la compra.";
    }
    $stmt->close();
}
$conn->close();
?>
