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
    <style>
        /* Set the body to use flexbox to center content */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Make sure the content is centered vertically */
            margin: 0;
        }

        /* Add some styling to the table */
        table {
            border-collapse: collapse;
            width: 80%; /* Adjust table width if needed */
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    
    <h1  style="display: flex; justify-content: center;">Bienvenidos al website</h1>

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
