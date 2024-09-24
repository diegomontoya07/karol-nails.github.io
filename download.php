<?php
// Archivo de descarga
$file = $_GET['file'];

// Ruta completa del archivo
$filepath = realpath($file);

// Verificar si el archivo existe
if (file_exists($filepath) && strpos($filepath, realpath('uploads/')) === 0) {
    // Forzar descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    flush(); // Limpiar el buffer de salida
    readfile($filepath);
    exit;
} else {
    echo "Archivo no encontrado o no autorizado.";
}
?>
