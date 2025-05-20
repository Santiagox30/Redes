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
    $sql = "SELECT * FROM Usuarios WHERE Id_Usuario=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    extract($data);
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM Usuarios WHERE ID_Usuarios=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    header("Location: ListadoUsuarios.php");
    exit();

}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Correo = $_POST['Correo'];
    $Contrasena = $_POST['Contrasena'];
    $Rol = $_POST['Rol'];

    $sql = "UPDATE Usuarios SET Nombre=:Nombre, Apellido=:Apellido, Correo=:Correo,
            Contrasena=:Contrasena, Rol=:Rol WHERE Id_Usuario=:id";
    $query = $dbConn->prepare($sql);
    $query->bindparam(':id', $id);
    $query->bindparam(':Nombre', $Nombre);
    $query->bindparam(':Apellido', $Apellido);
    $query->bindparam(':Correo', $Correo);
    $query->bindparam(':Contrasena', $Contrasena);
    $query->bindparam(':Rol', $Rol);
    $query->execute();
    header("Location: ListadoUsuarios.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .acciones {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
    </style>
</head>
<body>    
    <h1  style="display: flex; justify-content: center;">Bienvenidos al website</h1>
    <a href="main.php" style="padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Volver a Principal</a>


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
