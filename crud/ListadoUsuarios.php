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

if (isset($_POST['Submit'])) {
    $nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Correo = $_POST['Correo'];
    $Contrasena = $_POST['Contrasena'];
    $Rol = $_POST['Rol'];

    if (!empty($nombre) && !empty($Apellido) && !empty($Correo) && !empty($Contrasena) && !empty($Rol)) {
        $sql = "INSERT INTO Usuarios(Nombre, Apellido,Correo , Contrasena, Rol)
                VALUES(:Nombre, :Apellido,:Correo ,:Contrasena, :Rol)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':Nombre', $nombre);
        $query->bindparam(':Apellido', $Apellido);
        $query->bindparam(':Correo', $Correo);
        $query->bindparam(':Contrasena', $Contrasena);
        $query->bindparam(':Rol', $Rol);
        $query->execute();
        header("Location: ListadoUsuarios.php");
        exit();
    }
}

$editing = false;
if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM estudiante WHERE id=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    extract($data);
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
    
    <h1  style="display: flex; justify-content: center;">Bienvenidos al website</h1>

    <h2><?php echo $editing ? 'Editar Usuario' : 'Agregar Usuario'; ?></h2>
    <form method="post" action="ListadoUsuarios.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <label>Nombre:</label><input type="text" name="Nombre" value="<?php echo $editing ? $Nombre : ''; ?>"><br>
        <label>Apellido:</label><input type="text" name="Apellido" value="<?php echo $editing ? $Apellido : ''; ?>"><br>
        <label>Correo:</label><input type="text" name="Correo" value="<?php echo $editing ? $Correo : ''; ?>"><br>
        <label>Contrasena:</label><input type="text" name="Contrasena" value="<?php echo $editing ? $Contrasena : ''; ?>"><br>
        <label>Rol:</label><input type="text" name="Rol" value="<?php echo $editing ? $Rol : ''; ?>"><br>
        <input type="submit" name="<?php echo $editing ? 'update' : 'Submit'; ?>" value="<?php echo $editing ? 'Actualizar' : 'Agregar'; ?>">
    </form>

    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>ID_Usuarios</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Rol</th>
            </tr>
            <?php
                $result = $dbConn->query("SELECT * FROM Usuarios ORDER BY Id_Usuario ASC");
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
                                <a href="?edit_id=' . $row['Id_Usuario'] . '">Editar</a> |
                                <a href="?delete_id=' . $row['Id_Usuario'] . '" onclick="return confirm(\'¿Está seguro?\')">Eliminar</a>
                            </td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>
