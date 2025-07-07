<?php
include 'conexion.php'; // Incluir el archivo de conexión

// Mensajes de éxito o error (si vienen de otras páginas)
$mensaje = '';
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>CECYTEM Villa de Allende Seminario de Titulación 2025</h1>
        <h1>Gestión de Estudiantes Grupo 602</h1>
        

        <?php if (!empty($mensaje)): ?>
            <div class="message success"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <div class="button-container">
            <a href="crear.php" class="btn btn-primary">Agregar Nuevo Estudiante</a>
            <a href="consultar.php" class="btn btn-info">Consultar Estudiantes</a>
        </div>

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
                <?php
                $sql = "SELECT * FROM estudiantes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["numero_control"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre_completo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["direccion"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["semestre"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["grupo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["edad"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["sexo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fecha_nacimiento"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["promedio_general"]) . "</td>";
                        echo "<td>";
                        echo "<a href='editar.php?numero_control=" . urlencode($row["numero_control"]) . "' class='btn btn-warning btn-sm'>Editar</a> ";
                        echo "<a href='eliminar.php?numero_control=" . urlencode($row["numero_control"]) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Estás seguro de que quieres eliminar este estudiante?');\">Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No hay estudiantes registrados.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>