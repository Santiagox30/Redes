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
    $Tipo_Documento = $_POST['Tipo_Documento'];
    $Numero_Documento = $_POST['Numero_Documento'];
    $Telefono = $_POST['Telefono'];
    $Correo = $_POST['Correo'];

    if (!empty($nombre) && !empty($Apellido) && !empty($Tipo_Documento) && !empty($Numero_Documento) && !empty($Telefono) && !empty($Correo)) {
        $sql = "INSERT INTO Clientes(Nombre, Apellido,Tipo_Documento , Numero_Documento, Telefono, Correo)
                VALUES(:Nombre, :Apellido,:Tipo_Documento ,:Numero_Documento, :Telefono, :Correo)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':Nombre', $nombre);
        $query->bindparam(':Apellido', $Apellido);
        $query->bindparam(':Tipo_Documento', $Tipo_Documento);
        $query->bindparam(':Numero_Documento', $Numero_Documento);
        $query->bindparam(':Telefono', $Telefono);
        $query->bindparam(':Correo', $Correo);
        $query->execute();
        header("Location: ListadoClientes.php");
        exit();
    }
}

$editing = false;
if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM Clientes WHERE Id_Cliente=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    extract($data);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Tipo_Documento = $_POST['Tipo_Documento'];
    $Numero_Documento = $_POST['Numero_Documento'];
    $Telefono = $_POST['Telefono'];
    $Correo = $_POST['Correo'];

    $sql = "UPDATE clientes SET Nombre=:Nombre, Apellido=:Apellido, Tipo_Documento=:Tipo_Documento,
            Numero_Documento=:Numero_Documento, Telefono=:Telefono, Correo=:Correo WHERE Id_Cliente=:id";
    $query = $dbConn->prepare($sql);
    $query->bindparam(':id', $id);
    $query->bindparam(':Nombre', $Nombre);
    $query->bindparam(':Apellido', $Apellido);
    $query->bindparam(':Tipo_Documento', $Tipo_Documento);
    $query->bindparam(':Numero_Documento', $Numero_Documento);
    $query->bindparam(':Telefono', $Telefono);
    $query->bindparam(':Correo', $Correo);
    $query->execute();
    header("Location: ListadoUsuarios.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO BASE DE DATOS</title>
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

    <h2><?php echo $editing ? 'Editar Clientes' : 'Agregar Clientes'; ?></h2>
    <form method="post" action="ListadoClientes.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <label>Nombre:</label><input type="text" name="Nombre" value="<?php echo $editing ? $Nombre : ''; ?>"><br>
        <label>Apellido:</label><input type="text" name="Apellido" value="<?php echo $editing ? $Apellido : ''; ?>"><br>
        <label>Tipo Documento:</label><input type="text" name="Tipo_Documento" value="<?php echo $editing ? $Tipo_Documento : ''; ?>"><br>
        <label>Numero Documento:</label><input type="text" name="Numero_Documento" value="<?php echo $editing ? $Numero_Documento : ''; ?>"><br>
        <label>Telefono:</label><input type="text" name="Telefono" value="<?php echo $editing ? $Telefono : ''; ?>"><br>
        <label>Correo:</label><input type="text" name="Correo" value="<?php echo $editing ? $Correo : ''; ?>"><br>
        <input type="submit" name="<?php echo $editing ? 'update' : 'Submit'; ?>" value="<?php echo $editing ? 'Actualizar' : 'Agregar'; ?>">
    </form>


    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>Id_Cliente</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo_Documento</th>
                <th>Numero_Documento</th>
                <th>Telefono</th>
                <th>Correo</th>
            </tr>
            <?php
                $result = $dbConn->query("SELECT * FROM Clientes ORDER BY Id_Cliente ASC");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo 
                    '<tr>
                            <td>' . $row['Id_Cliente'] . '</td>
                            <td>' . $row['Nombre'] . '</td>
                            <td>' . $row['Apellido'] . '</td>
                            <td>' . $row['Tipo_Documento'] . '</td>
                            <td>' . $row['Numero_Documento'] . '</td>
                            <td>' . $row['Telefono'] . '</td>
                            <td>' . $row['Correo'] . '</td>
                            <td>
                                <a href="?edit_id=' . $row['Id_Cliente'] . '">Editar</a> |
                                <a href="?delete_id=' . $row['Id_Cliente'] . '" onclick="return confirm(\'¿Está seguro?\')">Eliminar</a>
                            </td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>
