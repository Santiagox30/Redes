<?php
    $databaseHost = 'localhost';
    $databasePort = '3307';
    $databaseName = 'SistemaGestion';
    $databaseUsername = 'root';
    $databasePassword = 'usbw';

    try {
        $dbConn = new PDO("mysql:host={$databaseHost};port={$databasePort};dbname={$databaseName}", $databaseUsername, $databasePassword);
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("❌ Error de conexión a la base de datos: " . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO BASE DE DATOS</title>
</head>
<body>
    <h1>Bienvenidos al website</h1>

    <h2>Listado de Estudiantes</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Identificación</th>
        <th>Nombre</th>
        <th>Curso</th>
        <th>Nota1</th>
        <th>Nota2</th>
        <th>Nota3</th>
        <th>Acciones</th>
    </tr>
    <?php
        $result = $dbConn->query("SELECT * FROM Usuarios ORDER BY Id_Usuario DESC");
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo 
            '<tr>
                    <td>' . $row['Id_Usuario'] . '</td>
                    <td>' . $row['Nombre'] . '</td>
                    <td>' . $row['Apellido'] . '</td>
                    <td>' . $row['Correo'] . '</td>
                    <td>' . $row['Contrasena'] . '</td>
                    <td>' . $row['Rol'] . '</td>
                    <td>
                        <a href="?edit_id=' . $row['id'] . '">Editar</a> |
                        <a href="?delete_id=' . $row['id'] . '" onclick="return confirm(\'¿Está seguro?\')">Eliminar</a>
                    </td>
            </tr>';
        }
    ?>
</table>
</body>
</html>