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
    $Id_Factura = $_POST['Id_Factura'];
    $Id_Producto = $_POST['Id_Producto'];
    $Cantidad = $_POST['Cantidad'];
    $Precio_Unitario = $_POST['Precio_Unitario'];
    $Subtotal = $_POST['Subtotal'];

    if (!empty($Id_Factura) && !empty($Id_Producto) &&!empty($Cantidad) && !empty($Precio_Unitario) && !empty($Subtotal)) {
        $sql = "INSERT INTO detallefactura(Id_Factura,Id_Producto ,Cantidad, Precio_Unitario,Subtotal)
                VALUES(:Id_Factura,:Id_Producto ,:Cantidad, :Precio_Unitario,:Subtotal)";
        $query = $dbConn->prepare($sql);
         $query->bindparam(':Id_Factura', $Id_Factura);
          $query->bindparam(':Id_Producto', $Id_Producto);
        $query->bindparam(':Cantidad', $Cantidad);
        $query->bindparam(':Precio_Unitario', $Precio_Unitario);
        $query->bindparam(':Subtotal', $Subtotal);
        $query->execute();
        header("Location: ListadoDetalleFactura.php");
        exit();
    }
}

$editing = false;
if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM detallefactura WHERE Id_Detalle=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    extract($data);
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM detallefactura WHERE Id_Detalle=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    header("Location: ListadoDetalleFactura.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $Id_Factura = $_POST['Id_Factura'];
    $Id_Producto = $_POST['Id_Producto'];
    $Cantidad = $_POST['Cantidad'];
    $Precio_Unitario = $_POST['Precio_Unitario'];
    $Subtotal = $_POST['Subtotal'];


    $sql = "UPDATE detallefactura SET Id_Factura=:Id_Factura, Id_Producto=:Id_Producto, Cantidad=:Cantidad,
            Precio_Unitario=:Precio_Unitario,Subtotal=:Subtotal  WHERE Id_Detalle=:id";
    $query = $dbConn->prepare($sql);
    $query->bindparam(':id', $id);
    $query->bindparam(':Id_Factura', $Id_Factura);
    $query->bindparam(':Id_Producto', $Id_Producto);
    $query->bindparam(':Cantidad', $Cantidad);
    $query->bindparam(':Precio_Unitario', $Precio_Unitario);
    $query->bindparam(':Subtotal', $Subtotal);
    $query->execute();
    header("Location: ListadoDetalleFactura.php");
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

    <h2><?php echo $editing ? 'Editar Usuario' : 'Agregar Usuario'; ?></h2>
    <form method="post" action="ListadoDetalleFactura.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <label>Id_Factura:</label><input type="text" name="Id_Factura" value="<?php echo $editing ? $Id_Factura : ''; ?>"><br>
        <label>Id_Producto:</label><input type="text" name="Id_Producto" value="<?php echo $editing ? $Id_Producto : ''; ?>"><br>
        <label>Cantidad:</label><input type="text" name="Cantidad" value="<?php echo $editing ? $Cantidad : ''; ?>"><br>
        <label>Precio_Unitario:</label><input type="text" name="Precio_Unitario" value="<?php echo $editing ? $Precio_Unitario : ''; ?>"><br>
        <label>Subtotal:</label><input type="text" name="Subtotal" value="<?php echo $editing ? $Subtotal : ''; ?>"><br>
        <input type="submit" name="<?php echo $editing ? 'update' : 'Submit'; ?>" value="<?php echo $editing ? 'Actualizar' : 'Agregar'; ?>">
    </form>
    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>Id_Detalle</th>
                <th>Id_Factura</th>
                <th>Id_Producto</th>
                <th>Cantidad</th>
                <th>Precio_Unitario</th>
                <th>Subtotal</th>
            </tr>
            <?php
                $result = $dbConn->query("SELECT * FROM DetalleFactura ORDER BY Id_Factura ASC");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo 
                    '<tr>
                            <td>' . $row['Id_Detalle'] . '</td>
                            <td>' . $row['Id_Factura'] . '</td>
                            <td>' . $row['Id_Producto'] . '</td>
                            <td>' . $row['Cantidad'] . '</td>
                            <td>' . $row['Precio_Unitario'] . '</td>
                            <td>' . $row['Subtotal'] . '</td>
                            <td>
                                <a href="?edit_id=' . $row['Id_Factura'] . '">Editar</a> |
                                <a href="?delete_id=' . $row['Id_Factura'] . '" onclick="return confirm(\'¿Está seguro?\')">Eliminar</a>
                            </td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>