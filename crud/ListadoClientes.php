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
