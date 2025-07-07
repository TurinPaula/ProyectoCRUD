<?php
include 'conexion.php'; // Incluir el archivo de conexión

if (isset($_GET['numero_control'])) {
    $numero_control = $conn->real_escape_string($_GET['numero_control']);

    $sql = "DELETE FROM estudiantes WHERE numero_control = '$numero_control'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?mensaje=Estudiante eliminado exitosamente.");
        exit();
    } else {
        header("Location: index.php?mensaje=<div class='message error'>Error al eliminar estudiante: " . urlencode($conn->error) . "</div>");
        exit();
    }
} else {
    header("Location: index.php?mensaje=<div class='message error'>Número de control no especificado para eliminar.</div>");
    exit();
}
$conn->close();
?>