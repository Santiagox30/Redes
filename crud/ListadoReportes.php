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
        $Tipo_de_Reporte = $_POST['Tipo_de_Reporte'];
        $Fecha_Generacion = $_POST['Fecha_Generacion'];
        $Id_Usuario = $_POST['Id_Usuario'];
    
        if (!empty($Tipo_de_Reporte) && !empty($Fecha_Generacion) && !empty($Id_Usuario)) {
            $sql = "INSERT INTO reportes(Tipo_de_Reporte, Fecha_Generacion, Id_Usuario)
                    VALUES(:Tipo_de_Reporte, :Fecha_Generacion, :Id_Usuario)";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':Tipo_de_Reporte', $Tipo_de_Reporte);
            $query->bindparam(':Fecha_Generacion', $Fecha_Generacion);
            $query->bindparam(':Id_Usuario', $Id_Usuario);
            $query->execute();
            header("Location: ListadoReportes.php");
            exit();
        }
    }
    
    $editing = false;
    if (isset($_GET['edit_id'])) {
        $editing = true;
        $id = $_GET['edit_id'];
        $sql = "SELECT * FROM reportes WHERE Id_Reporte=:id";
        $query = $dbConn->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        extract($data);
    }
    
    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];
        $sql = "DELETE FROM reportes WHERE Id_Reporte=:id";
        $query = $dbConn->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        header("Location: ListadoReportes.php");
        exit();
    
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $Tipo_de_Reporte = $_POST['Tipo_de_Reporte'];
        $Fecha_Generacion = $_POST['Fecha_Generacion'];
        $Id_Usuario = $_POST['Id_Usuario'];
    
    
        $sql = "UPDATE reportes SET Tipo_de_Reporte=:Tipo_de_Reporte, Fecha_Generacion=:Fecha_Generacion, Id_Usuario=:Id_Usuario WHERE Id_Reporte=:id";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':id', $id);
        $query->bindparam(':Tipo_de_Reporte', $Tipo_de_Reporte);
        $query->bindparam(':Fecha_Generacion', $Fecha_Generacion);
        $query->bindparam(':Id_Usuario', $Id_Usuario);
        $query->execute();
        header("Location: ListadoReportes.php");
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
        <a href="main.php" style="padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Volver a Principal</a>
    <h2><?php echo $editing ? 'Editar Usuario' : 'Agregar Usuario'; ?></h2>
    <form method="post" action="ListadoReportes.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <label>Tipo_de_Reporte:</label><input type="text" name="Tipo_de_Reporte" value="<?php echo $editing ? $Tipo_de_Reporte : ''; ?>"><br>
        <label>Fecha_Generacion:</label><input type="text" name="Fecha_Generacion" value="<?php echo $editing ? $Fecha_Generacion : ''; ?>"><br>
        <label>Id_Usuario:</label><input type="text" name="Id_Usuario" value="<?php echo $editing ? $Id_Usuario : ''; ?>"><br>
        <input type="submit" name="Submit" value="<?php echo $editing ? 'Actualizar' : 'Agregar'; ?>">
    </form>

    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>Id_Reporte</th>
                <th>Tipo_de_Reporte</th>
                <th>Fecha_Generacion</th>
                <th>Id_Usuario</th>
            </tr>
            <?php
                $result = $dbConn->query("SELECT * FROM reportes ORDER BY Id_Reporte ASC");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo 
                    '<tr>
                            <td>' . $row['Id_Reporte'] . '</td>
                            <td>' . $row['Tipo_de_Reporte'] . '</td>
                            <td>' . $row['Fecha_Generacion'] . '</td>
                            <td>' . $row['Id_Usuario'] . '</td>
                            <td>
                                <a href="?edit_id=' . $row['Id_Reporte'] . '">Editar</a> |
                                <a href="?delete_id=' . $row['Id_Reporte'] . '" onclick="return confirm(\'¿Está seguro?\')">Eliminar</a>
                            </td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>
