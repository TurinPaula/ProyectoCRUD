<?php
include 'conexion.php'; // Incluir el archivo de conexión

$mensaje = '';
$estudiante = null;

if (isset($_GET['numero_control'])) {
    $numero_control_url = $conn->real_escape_string($_GET['numero_control']);
    $sql = "SELECT * FROM estudiantes WHERE numero_control = '$numero_control_url'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $estudiante = $result->fetch_assoc();
    } else {
        $mensaje = "<div class='message error'>Estudiante no encontrado.</div>";
    }
}

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

    $sql = "UPDATE estudiantes SET
            nombre_completo = '$nombre_completo',
            direccion = '$direccion',
            semestre = $semestre,
            grupo = $grupo,
            telefono = '$telefono',
            edad = $edad,
            sexo = '$sexo',
            fecha_nacimiento = '$fecha_nacimiento',
            promedio_general = $promedio_general
            WHERE numero_control = '$numero_control'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?mensaje=Estudiante actualizado exitosamente.");
        exit();
    } else {
        $mensaje = "<div class='message error'>Error al actualizar estudiante: " . $conn->error . "</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Estudiante</h1>
        <?php echo $mensaje; ?>
        <?php if ($estudiante): ?>
            <form action="editar.php" method="POST">
                <div class="form-group">
                    <label for="numero_control">Número de Control:</label>
                    <input type="text" id="numero_control" name="numero_control" value="<?php echo htmlspecialchars($estudiante['numero_control']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nombre_completo">Nombre Completo:</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($estudiante['nombre_completo']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($estudiante['direccion']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="semestre">Semestre:</label>
                    <input type="number" id="semestre" name="semestre" value="<?php echo htmlspecialchars($estudiante['semestre']); ?>" required min="1">
                </div>
                <div class="form-group">
                    <label for="grupo">Grupo:</label>
                    <input type="number" id="grupo" name="grupo" value="<?php echo htmlspecialchars($estudiante['grupo']); ?>" required min="1">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($estudiante['telefono']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($estudiante['edad']); ?>" required min="1">
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <input type="text" id="sexo" name="sexo" value="<?php echo htmlspecialchars($estudiante['sexo']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento (YYYY-MM-DD):</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($estudiante['fecha_nacimiento']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="promedio_general">Promedio General:</label>
                    <input type="number" step="0.01" id="promedio_general" name="promedio_general" value="<?php echo htmlspecialchars($estudiante['promedio_general']); ?>" required min="0" max="100">
                </div>
                <div class="form-group">
                    <input type="submit" value="Actualizar Estudiante" class="btn btn-success">
                    <a href="index.php" class="btn btn-info">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <p>No se pudo cargar la información del estudiante para editar.</p>
            <a href="index.php" class="btn btn-info">Volver a la lista</a>
        <?php endif; ?>
    </div>
</body>
</html>