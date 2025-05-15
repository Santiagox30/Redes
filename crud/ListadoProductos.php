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
        $Nombre = $_POST['Nombre'];
        $Descripcion = $_POST['Descripcion'];
        $Categoria = $_POST['Categoria'];
        $Precio_Compra = $_POST['Precio_Compra'];
        $Precio_Venta = $_POST['Precio_Venta'];
        $Stock = $_POST['Stock'];
        $Unidad_Medida = $_POST['Unidad_Medida'];
        $Id_Proveedor = $_POST['Id_Proveedor'];
        if (!empty($Nombre) && !empty($Descripcion) && !empty($Categoria) && !empty($Precio_Compra) && !empty($Precio_Venta) && !empty($Stock) && !empty($Unidad_Medida)  && !empty($Id_Proveedor)) {
            $sql = "INSERT INTO Productos(Nombre, Descripcion,Categoria , Precio_Compra, Precio_Venta,Stock, Unidad_Medida, Id_Proveedor )
                    VALUES(:Nombre, :Descripcion,:Categoria ,:Precio_Compra, :Precio_Venta, :Stock, :Unidad_Medida, :Id_Proveedor)";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':Nombre', $Nombre);
            $query->bindparam(':Descripcion', $Descripcion);
            $query->bindparam(':Categoria', $Categoria);
            $query->bindparam(':Precio_Compra', $Precio_Compra);
            $query->bindparam(':Precio_Venta', $Precio_Venta);
            $query->bindparam(':Stock', $Stock);
            $query->bindparam(':Unidad_Medida', $Unidad_Medida);
            $query->bindparam(':Id_Proveedor', $Id_Proveedor);

            $query->execute();
            header("Location: ListadoProductos.php");
            exit();
        }
    }
    
    $editing = false;
    if (isset($_GET['edit_id'])) {
        $editing = true;
        $id = $_GET['edit_id'];
        $sql = "SELECT * FROM Productos WHERE Id_Producto=:id";
        $query = $dbConn->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        extract($data);
    }
    
    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];
        $sql = "DELETE FROM Productos WHERE Id_Producto=:id";
        $query = $dbConn->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        header("Location: ListadoProductos.php");
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
    <h2><?php echo $editing ? 'Editar Producto' : 'Agregar Producto'; ?></h2>
    <form method="post" action="ListadoProductos.php">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <label>Nombre:</label><input type="text" name="Nombre" value="<?php echo $editing ? $Nombre : ''; ?>"><br>
        <label>Descripcion:</label><input type="text" name="Descripcion" value="<?php echo $editing ? $Descripcion : ''; ?>"><br>
        <label>Categoria:</label><input type="text" name="Categoria" value="<?php echo $editing ? $Categoria : ''; ?>"><br>
        <label>Precio_Compra:</label><input type="text" name="Precio_Compra" value="<?php echo $editing ? $Precio_Compra : ''; ?>"><br>
        <label>Precio_Venta:</label><input type="text" name="Precio_Venta" value="<?php echo $editing ? $Precio_Venta : ''; ?>"><br>
        <label>Stock:</label><input type="text" name="Stock" value="<?php echo $editing ? $Stock : ''; ?>"><br>
        <label>Unidad_Medida:</label><input type="text" name="Unidad_Medida" value="<?php echo $editing ? $Unidad_Medida : ''; ?>"><br>
        <label>Id_Proveedor:</label><input type="text" name="Id_Proveedor" value="<?php echo $editing ? $Id_Proveedor : ''; ?>"><br>
        <input type="submit" name="<?php echo $editing ? 'update' : 'Submit'; ?>" value="<?php echo $editing ? 'Actualizar' : 'Agregar'; ?>">
    </form>
    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>Id_Producto</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Categoria</th>
                <th>Precio_Compra</th>
                <th>Precio_Venta</th>
                <th>Stock</th>
                <th>Unidad_Medida</th>
                <th>Id_Proveedor</th>
            </tr>
            <?php
                $result = $dbConn->query("SELECT * FROM Productos ORDER BY Id_Producto ASC");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo 
                    '<tr>
                            <td>' . $row['Id_Producto'] . '</td>
                            <td>' . $row['Nombre'] . '</td>
                            <td>' . $row['Descripcion'] . '</td>
                            <td>' . $row['Categoria'] . '</td>
                            <td>' . $row['Precio_Compra'] . '</td>
                            <td>' . $row['Precio_Venta'] . '</td>
                            <td>' . $row['Stock'] . '</td>
                            <td>' . $row['Unidad_Medida'] . '</td>
                            <td>' . $row['Id_Proveedor'] . '</td>
                            <td>
                                <a href="?edit_id=' . $row['Id_Producto'] . '">Editar</a> |
                                <a href="?delete_id=' . $row['Id_Producto'] . '" onclick="return confirm(\'¿Está seguro?\')">Eliminar</a>
                            </td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</body>
</html>
