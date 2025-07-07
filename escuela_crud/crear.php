<?php
include 'conexion.php'; // Incluir el archivo de conexión

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_control = $conn->real_escape_string($_POST['numero_control']);
    $nombre_completo = $conn->real_escape_string($_POST['nombre_completo']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $semestre = (int)$_POST['semestre'];
    $grupo = (int)$_POST['grupo'];
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $edad = (int)$_POST['edad'];
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $fecha_nacimiento = $conn->real_escape_string($_POST['fecha_nacimiento']);
    $promedio_general = (int)$_POST['promedio_general'];

    // Verificar si el numero_control ya existe
    $sql_check = "SELECT numero_control FROM estudiantes WHERE numero_control = '$numero_control'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $mensaje = "<div class='message error'>Error: El número de control ya existe.</div>";
    } else {
        $sql = "INSERT INTO estudiantes (numero_control, nombre_completo, direccion, semestre, grupo, telefono, edad, sexo, fecha_nacimiento, promedio_general)
                VALUES ('$numero_control', '$nombre_completo', '$direccion', $semestre, $grupo, '$telefono', $edad, '$sexo', '$fecha_nacimiento', $promedio_general)";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?mensaje=Estudiante agregado exitosamente.");
            exit();
        } else {
            $mensaje = "<div class='message error'>Error al agregar estudiante: " . $conn->error . "</div>";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estudiante</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Estudiante</h1>
        <?php echo $mensaje; ?>
        <form action="crear.php" method="POST">
            <div class="form-group">
                <label for="numero_control">Número de Control:</label>
                <input type="text" id="numero_control" name="numero_control" required>
            </div>
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="semestre">Semestre:</label>
                <input type="number" id="semestre" name="semestre" required min="1">
            </div>
            <div class="form-group">
                <label for="grupo">Grupo:</label>
                <input type="number" id="grupo" name="grupo" required min="1">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" required min="1">
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <input type="text" id="sexo" name="sexo" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento (YYYY-MM-DD):</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="promedio_general">Promedio General:</label>
                <input type="number" step="0.01" id="promedio_general" name="promedio_general" required min="0" max="100">
            </div>
            <div class="form-group">
                <input type="submit" value="Guardar Estudiante" class="btn btn-success">
                <a href="index.php" class="btn btn-info">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>