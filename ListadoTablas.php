<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO BASE DE DATOS</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div>
        <h1>Bienvenidos al Website</h1>

        <div style="width: 100%; overflow-x: auto;">
            <table id="clientes-table">
                <thead>
                    <tr>
                        <th>Id_Cliente</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Tipo_Documento</th>
                        <th>Numero_Documento</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="clientes-body">
                    <!-- Aquí se llenarán los datos con JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Función para cargar los datos de la API y mostrarlos en la tabla
        function cargarClientes() {
            fetch('api.php')  // Llamada a la API PHP
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        const tbody = document.getElementById('clientes-body');
                        tbody.innerHTML = '';  // Limpiar la tabla antes de llenarla

                        // Recorrer los datos y agregar cada fila a la tabla
                        data.forEach(cliente => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${cliente.Id_Cliente}</td>
                                <td>${cliente.Nombre}</td>
                                <td>${cliente.Apellido}</td>
                                <td>${cliente.Tipo_Documento}</td>
                                <td>${cliente.Numero_Documento}</td>
                                <td>${cliente.Telefono}</td>
                                <td>${cliente.Correo}</td>
                                <td>
                                    <a href="?edit_id=${cliente.Id_Cliente}">Editar</a> |
                                    <a href="?delete_id=${cliente.Id_Cliente}" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        alert('Error al cargar los datos');
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                    alert('Hubo un problema al cargar los datos.');
                });
        }

        
        window.onload = cargarClientes;
    </script>

</body>
</html>
