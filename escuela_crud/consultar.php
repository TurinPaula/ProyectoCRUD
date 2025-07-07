<?php
include 'conexion.php'; // Incluir el archivo de conexión

$resultados = [];
$mensaje = '';
$buscar_numero_control = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['buscar'])) {
    $buscar_numero_control = $conn->real_escape_string($_GET['numero_control_buscar']);

    if (!empty($buscar_numero_control)) {
        // Consultar por número de control específico
        $sql = "SELECT * FROM estudiantes WHERE numero_control LIKE '%$buscar_numero_control%'";
        $stmt = $conn->prepare($sql);
        // No se usa bind_param porque ya escapamos con real_escape_string y LIKE se maneja distinto.
        // Para una mayor seguridad con LIKE, podrías usar:
        // $param = "%" . $buscar_numero_control . "%";
        // $stmt->bind_param("s", $param);
        // $stmt->execute();
        // $result = $stmt->get_result();
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultados[] = $row;
            }
        } else {
            $mensaje = "<div class='message error'>No se encontraron estudiantes con ese número de control.</div>";
        }
    } else {
        // Si el campo de búsqueda está vacío, mostrar todos los estudiantes
        $sql = "SELECT * FROM estudiantes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultados[] = $row;
            }
        } else {
            $mensaje = "<div class='message info'>No hay estudiantes registrados en la base de datos.</div>";
        }
    }
} else {
    // Por defecto, al cargar la página por primera vez, mostrar todos los estudiantes
    $sql = "SELECT * FROM estudiantes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
    } else {
        $mensaje = "<div class='message info'>No hay estudiantes registrados en la base de datos.</div>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Estudiantes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Consultar Estudiantes</h1>

        <div class="button-container" style="text-align: left; margin-bottom: 20px;">
            <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
        </div>

        <form action="consultar.php" method="GET" class="form-search">
            <div class="form-group">
                <label for="numero_control_buscar">Buscar por Número de Control:</label>
                <input type="text" id="numero_control_buscar" name="numero_control_buscar" value="<?php echo htmlspecialchars($buscar_numero_control); ?>" placeholder="Ingrese número de control">
                <button type="submit" name="buscar" class="btn btn-success">Buscar</button>
                <a href="consultar.php" class="btn btn-info">Ver Todos</a>
            </div>
        </form>

        <?php echo $mensaje; ?>

        <?php if (!empty($resultados)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Número de Control</th>
                        <th>Nombre Completo</th>
                        <th>Dirección</th>
                        <th>Semestre</th>
                        <th>Grupo</th>
                        <th>Teléfono</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Promedio General</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["numero_control"]); ?></td>
                            <td><?php echo htmlspecialchars($row["nombre_completo"]); ?></td>
                            <td><?php echo htmlspecialchars($row["direccion"]); ?></td>
                            <td><?php echo htmlspecialchars($row["semestre"]); ?></td>
                            <td><?php echo htmlspecialchars($row["grupo"]); ?></td>
                            <td><?php echo htmlspecialchars($row["telefono"]); ?></td>
                            <td><?php echo htmlspecialchars($row["edad"]); ?></td>
                            <td><?php echo htmlspecialchars($row["sexo"]); ?></td>
                            <td><?php echo htmlspecialchars($row["fecha_nacimiento"]); ?></td>
                            <td><?php echo htmlspecialchars($row["promedio_general"]); ?></td>
                            <td>
                                <a href='editar.php?numero_control=<?php echo urlencode($row["numero_control"]); ?>' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='eliminar.php?numero_control=<?php echo urlencode($row["numero_control"]); ?>' class='btn btn-danger btn-sm' onclick="return confirm('¿Estás seguro de que quieres eliminar este estudiante?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (empty($mensaje)): ?>
            <div class="message info">No se encontraron resultados para la consulta.</div>
        <?php endif; ?>
    </div>
</body>
</html>