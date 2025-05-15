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
    $Cantidad = $_POST['Cantidad'];
    $Precio_Unitario = $_POST['Precio_Unitario'];
    $Numerp_Factura = $_POST['Numerp_Factura'];
    $Fecha = $_POST['Fecha'];
    $Total = $_POST['Total'];
    $Metodo_Pago = $_POST['Metodo_Pago'];
    $Id_Usuario = $_POST['Id_Usuario'];
    $Id_Cliente = $_POST['Id_Cliente'];

    if (!empty($Cantidad) && !empty($Precio_Unitario) && !empty($Numerp_Factura) && !empty($Fecha) && !empty($Total) && !empty($Metodo_Pago) && !empty($Id_Usuario) && !empty($Id_Cliente)) {
        $sql = "INSERT INTO facturas(Cantidad, Precio_Unitario ,Numerp_Factura, Fecha, Total,Metodo_Pago ,Id_Usuario ,Id_Cliente )
                VALUES(:Cantidad, :Precio_Unitario,:Numerp_Factura ,:Fecha, :Total, :Metodo_Pago, :Id_Usuario, :Id_Cliente)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':Cantidad', $Cantidad);
        $query->bindparam(':Precio_Unitario', $Precio_Unitario);
        $query->bindparam(':Numerp_Factura', $Numerp_Factura);
        $query->bindparam(':Fecha', $Fecha);
        $query->bindparam(':Total', $Total);
        $query->bindparam(':Metodo_Pago', $Metodo_Pago);
        $query->bindparam(':Id_Usuario', $Id_Usuario);
        $query->bindparam(':Id_Cliente', $Id_Cliente);
        $query->execute();
        header("Location: ListadoFacturas.php");
        exit();
    }
}

$editing = false;
if (isset($_GET['edit_id'])) {
    $editing = true;
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM Facturas WHERE Id_Factura=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    extract($data);
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM facturas WHERE Id_Factura=:id";
    $query = $dbConn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    header("Location: ListadoFacturas.php");
    exit();

}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $Cantidad = $_POST['Cantidad'];
    $Precio_Unitario = $_POST['Precio_Unitario'];
    $Numerp_Factura = $_POST['Numerp_Factura'];
    $Fecha = $_POST['Fecha'];
    $Total = $_POST['Total'];
    $Metodo_Pago = $_POST['Metodo_Pago'];
    $Id_Usuario = $_POST['Id_Usuario'];
    $Id_Cliente = $_POST['Id_Cliente'];


    $sql = "UPDATE facturas SET Cantidad=:Cantidad, Precio_Unitario=:Precio_Unitario, Numerp_Factura=:Numerp_Factura,
            Fecha=:Fecha,Total=:Total ,Metodo_Pago=:Metodo_Pago ,Id_Usuario=:Id_Usuario ,Id_Cliente=:Id_Cliente
             WHERE Id_Factura=:id";
    $query = $dbConn->prepare($sql);
    $query->bindparam(':id', $id);
    $query->bindparam(':Cantidad', $Cantidad);
    $query->bindparam(':Precio_Unitario', $Precio_Unitario);
    $query->bindparam(':Numerp_Factura', $Numerp_Factura);
    $query->bindparam(':Fecha', $Fecha);
    $query->bindparam(':Total', $Total);
    $query->bindparam(':Metodo_Pago', $Metodo_Pago);
    $query->bindparam(':Id_Usuario', $Id_Usuario);
    $query->bindparam(':Id_Cliente', $Id_Cliente);
    $query->execute();
    header("Location: ListadoFacturas.php");
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

    <h2><?php echo $editing ? 'Editar Facturas' : 'Agregar Facturas'; ?></h2>
    <form method="post" action="ListadoFacturas.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <label>Cantidad:</label><input type="text" name="Cantidad" value="<?php echo $editing ? $Cantidad : ''; ?>"><br>
        <label>Precio_Unitario:</label><input type="text" name="Precio_Unitario" value="<?php echo $editing ? $Precio_Unitario : ''; ?>"><br>
        <label>Numerp_Factura:</label><input type="text" name="Numerp_Factura" value="<?php echo $editing ? $Numerp_Factura : ''; ?>"><br>
        <label>Fecha:</label><input type="text" name="Fecha" value="<?php echo $editing ? $Fecha : ''; ?>"><br>
        <label>Total:</label><input type="text" name="Total" value="<?php echo $editing ? $Total : ''; ?>"><br>
        <label>Metodo_Pago:</label><input type="text" name="Metodo_Pago" value="<?php echo $editing ? $Metodo_Pago : ''; ?>"><br>
        <label>Id_Usuario:</label><input type="text" name="Id_Usuario" value="<?php echo $editing ? $Id_Usuario : ''; ?>"><br>
        <label>Id_Cliente:</label><input type="text" name="Id_Cliente" value="<?php echo $editing ? $Id_Cliente : ''; ?>"><br>
        <input type="submit" name="<?php echo $editing ? 'update' : 'Submit'; ?>" value="<?php echo $editing ? 'Actualizar' : 'Agregar'; ?>">
    </form>

    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>Id_Factura</th>
                <th>Cantidad</th>
                <th>Precio_Unitario</th>
                <th>Numerp_Factura</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Metodo_Pago</th>
                <th>Id_Usuario</th>
                <th> Id_Cliente</th>
            </tr>
            <?php
                $result = $dbConn->query("SELECT * FROM Facturas ORDER BY Id_Factura ASC");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo 
                    '<tr>
                            <td>' . $row['Id_Factura'] . '</td>
                            <td>' . $row['Cantidad'] . '</td>
                            <td>' . $row['Precio_Unitario'] . '</td>
                            <td>' . $row['Numerp_Factura'] . '</td>
                            <td>' . $row['Fecha'] . '</td>
                            <td>' . $row['Total'] . '</td>
                            <td>' . $row['Metodo_Pago'] . '</td>
                            <td>' . $row['Id_Usuario'] . '</td>
                            <td>' . $row['Id_Cliente'] . '</td>
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
