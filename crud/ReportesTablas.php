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

    // Parámetros de paginación
    $porPagina = 100; // filas por página
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina < 1) $pagina = 1;
    $offset = ($pagina - 1) * $porPagina;

    // Contar total registros para paginación
    $countSql = "
        SELECT COUNT(*) AS total FROM Usuarios u
        CROSS JOIN Facturas f
        CROSS JOIN Clientes c
        CROSS JOIN DetalleFactura df
        CROSS JOIN Productos pr
        CROSS JOIN Proveedores p
        CROSS JOIN Inventario i
        CROSS JOIN Gastos g
        CROSS JOIN Reportes r
        CROSS JOIN Usuario_Reporte ur
        CROSS JOIN AuditoriaUsuarios au
    ";

    $totalRegistros = 0;
    try {
        $countStmt = $dbConn->query($countSql);
        $totalRegistros = $countStmt->fetchColumn();
    } catch (PDOException $e) {
        die("Error al contar registros: " . $e->getMessage());
    }

    $totalPaginas = ceil($totalRegistros / $porPagina);

    // Consulta con límite y offset para paginación
    $sql = "
        SELECT 
            u.Nombre AS Usuario_Nombre,
            c.Nombre AS Cliente_Nombre,
            p.Nombre_Empresa AS Proveedor_Nombre,
            f.Numero_Factura AS Numero_Factura,
            i.Tipo_de_Movimiento AS Movimiento,
            g.Descripcion AS Gasto_Descripcion,
            r.Tipo_de_Reporte AS Tipo_Reporte,
            pr.Nombre AS Producto_Nombre,
            df.Subtotal AS Subtotal_Detalle,
            ur.Id_Usuario AS Usuario_Reporte_Id,
            au.Actividad AS Actividad_Auditoria
        FROM Usuarios u
        CROSS JOIN Facturas f
        CROSS JOIN Clientes c
        CROSS JOIN DetalleFactura df
        CROSS JOIN Productos pr
        CROSS JOIN Proveedores p
        CROSS JOIN Inventario i
        CROSS JOIN Gastos g
        CROSS JOIN Reportes r
        CROSS JOIN Usuario_Reporte ur
        CROSS JOIN AuditoriaUsuarios au
        LIMIT :porPagina OFFSET :offset
    ";

    try {
        $stmt = $dbConn->prepare($sql);
        $stmt->bindValue(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error en la consulta: " . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <style>
        /* Mantén tu CSS tal cual */
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
        /* Paginación */
        .paginacion {
            text-align: center;
            margin: 20px auto;
            font-size: 18px;
        }
        .paginacion a {
            margin: 0 8px;
            padding: 6px 12px;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .paginacion a.disabled {
            background-color: #ccc;
            pointer-events: none;
            cursor: default;
            color: #666;
        }
    </style>
</head>
<body>    
    <h1  style="display: flex; justify-content: center;">Bienvenidos al website</h1>
    <a href="main.php" style="padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Volver a Principal</a>
    <!-- Container for centering the table -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <table>
            <tr>
                <th>Usuario_Nombre</th>
                <th>Cliente_Nombre</th>
                <th>Proveedor_Nombre</th>
                <th>Numero_Factura</th>                               
                <th>Movimiento</th>
                <th>Gasto_Descripcion</th>
                <th>Producto_Nombre</th>
                <th>Subtotal_Detalle</th>
                <th>Usuario_Reporte_Id</th>
                <th>Actividad_Auditoria</th>
            </tr>
            <?php
                if ($results) {
                    foreach ($results as $row) {
                        echo '<tr>
                            <td>' . htmlspecialchars($row['Usuario_Nombre']) . '</td>
                            <td>' . htmlspecialchars($row['Cliente_Nombre']) . '</td>
                            <td>' . htmlspecialchars($row['Proveedor_Nombre']) . '</td>
                            <td>' . htmlspecialchars($row['Numero_Factura']) . '</td>
                            <td>' . htmlspecialchars($row['Movimiento']) . '</td>
                            <td>' . htmlspecialchars($row['Gasto_Descripcion']) . '</td>
                            <td>' . htmlspecialchars($row['Producto_Nombre']) . '</td>
                            <td>' . htmlspecialchars($row['Subtotal_Detalle']) . '</td>
                            <td>' . htmlspecialchars($row['Usuario_Reporte_Id']) . '</td>
                            <td>' . htmlspecialchars($row['Actividad_Auditoria']) . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="10">No hay registros para mostrar.</td></tr>';
                }
            ?>
        </table>
    </div>

    <!-- Controles de paginación -->
    <div class="paginacion">
        <?php if($pagina > 1): ?>
            <a href="?pagina=<?= $pagina - 1 ?>">« Página anterior</a>
        <?php else: ?>
            <a class="disabled">« Página anterior</a>
        <?php endif; ?>

        Página <?= $pagina ?> de <?= $totalPaginas ?>

        <?php if($pagina < $totalPaginas): ?>
            <a href="?pagina=<?= $pagina + 1 ?>">Página siguiente »</a>
        <?php else: ?>
            <a class="disabled">Página siguiente »</a>
        <?php endif; ?>
    </div>
</body>
</html>
