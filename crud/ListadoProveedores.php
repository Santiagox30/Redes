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
        $Nombre_Empresa = $_POST['Nombre_Empresa'];
        $Nit = $_POST['Nit'];
        $Contacto = $_POST['Contacto'];
        $Telefono = $_POST['Telefono'];
        $Correo = $_POST['Correo'];
        $Direccion = $_POST['Direccion'];
    
        if (!empty($Nombre_Empresa) && !empty($Nit) && !empty($Contacto) && !empty($Telefono) && !empty($Correo) && !empty($Direccion)) {
            $sql = "INSERT INTO Proveedores(Nombre_Empresa, Nit,Contacto , Telefono, Correo,Direccion )
                    VALUES(:Nombre_Empresa, :Nit,:Contacto ,:Telefono, :Correo, :Direccion)";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':Nombre_Empresa', $Nombre_Empresa);
            $query->bindparam(':Nit', $Nit);
            $query->bindparam(':Contacto', $Contacto);
            $query->bindparam(':Telefono', $Telefono);
            $query->bindparam(':Correo', $Correo);
            $query->bindparam(':Direccion', $Direccion);
            $query->execute();
            header("Location: ListadoProveedores.php");
            exit();
        }
    }
    
    $editing = false;
    if (isset($_GET['edit_id'])) {
        $editing = true;
        $id = $_GET['edit_id'];
        $sql = "SELECT * FROM Proveedores WHERE Id_Proveedor=:id";
        $query = $dbConn->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        extract($data);
    }

    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];
        $sql = "DELETE FROM Proveedores WHERE Id_Proveedor=:id";
        $query = $dbConn->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        header("Location: ListadoProveedores.php");
        exit();
    
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $Nombre_Empresa = $_POST['Nombre_Empresa'];
        $Nit = $_POST['Nit'];
        $Contacto = $_POST['Contacto'];
        $Telefono = $_POST['Telefono'];
        $Correo = $_POST['Correo'];
        $Direccion = $_POST['Direccion'];


        $sql = "UPDATE Proveedores SET Nombre_Empresa=:Nombre_Empresa, Nit=:Nit, Contacto=:Contacto,
                Telefono=:Telefono, Correo=:Correo , Direccion=:Direccion WHERE Id_Proveedor=:id";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':id', $id);
        $query->bindparam(':Nombre_Empresa', $Nombre_Empresa);
        $query->bindparam(':Nit', $Nit);
        $query->bindparam(':Contacto', $Contacto);
        $query->bindparam(':Telefono', $Telefono);
        $query->bindparam(':Correo', $Correo);
        $query->bindparam(':Direccion', $Direccion);
        $query->execute();
        header("Location: ListadoProveedores.php");
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
    <h2><?php echo $editing ? 'Editar Proveedor' : 'Agregar Proveedor'; ?></h2>
    <form method="post" action="ListadoProveedores.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <label>Nombre_Empresa:</label><input type="text" name="Nombre_Empresa" value="<?php echo $editing ? $Nombre_Empresa : ''; ?>"><br>
        <label>Nit:</label><input type="text" name="Nit" value="<?php echo $editing ? $Nit : ''; ?>"><br>
        <label>Contacto:</label><input type="text" name="Contacto" value="<?php echo $editing ? $Contacto : ''; ?>"><br>
        <label>Telefono:</label><input type="text" name="Telefono" value="<?php echo $editing ? $Telefono : ''; ?>"><br>
        <label>Correo:</label><input type="text" name="Correo" value="<?php echo $editing ? $Correo : ''; ?>"><br>
        <label>Direccion:</label><input type="text" name="Direccion" value="<?php echo $editing ? $Direccion : ''; ?>"><br>
        <input type="submit" name="<?php echo $editing ? 'update' : 'Submit'; ?>" value="<?php echo $editing ? 'Actualizar' : 'Agregar'; ?>">
    </form>
    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>Id_Proveedor</th>
                <th>Nombre_Empresa</th>
                <th>Nit</th>
                <th>Contacto</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Direccion</th>
            </tr>
            <?php
                $result = $dbConn->query("SELECT * FROM Proveedores ORDER BY Id_Proveedor ASC");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo 
                    '<tr>
                            <td>' . $row['Id_Proveedor'] . '</td>
                            <td>' . $row['Nombre_Empresa'] . '</td>
                            <td>' . $row['Nit'] . '</td>
                            <td>' . $row['Contacto'] . '</td>
                            <td>' . $row['Telefono'] . '</td>
                            <td>' . $row['Correo'] . '</td>
                            <td>' . $row['Direccion'] . '</td>
                            <td>
                                <a href="?edit_id=' . $row['Id_Proveedor'] . '">Editar</a> |
                                <a href="?delete_id=' . $row['Id_Proveedor'] . '" onclick="return confirm(\'¿Está seguro?\')">Eliminar</a>
                            </td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>
