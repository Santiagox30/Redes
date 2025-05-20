<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sistema de Gestión</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      color: #2c3e50;
    }

    header {
      width: 100%;
      background-color: #ffffff;
      padding: 25px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      position: fixed;
      top: 0;
      z-index: 1000;
      flex-wrap: wrap;
    }

    header h1 {
      font-size: 26px;
      color: #1f3b73;
      font-weight: 700;
      flex: 1 1 100%;
      margin-bottom: 15px;
      letter-spacing: 1px;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
      justify-content: center;
      width: 100%;
    }

    nav a {
      padding: 10px 22px;
      border-radius: 30px;
      background-color: #1f3b73;
      color: #ffffff;
      text-decoration: none;
      font-weight: 600;
      font-size: 14.5px;
      letter-spacing: 0.4px;
      box-shadow: 0 4px 10px rgba(31, 59, 115, 0.15);
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    nav a:hover {
      background-color: #2b4f9c;
      transform: translateY(-2px);
    }

    .hero {
      margin-top: 140px;
      width: 100%;
      height: 90vh;
      background-image: url('https://media.licdn.com/dms/image/v2/C4D12AQEm0JOA2SfUMA/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1597236426122?e=2147483647&v=beta&t=XcNmzLu42RrlKY0tzloU8llyyDQ6H2vpB0l3xxh9RA4');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
    }

    .hero::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.55);
      z-index: 1;
    }

    .hero h2,
    .hero p {
      position: relative;
      z-index: 2;
      color: white;
      text-shadow: 1px 1px 8px rgba(0, 0, 0, 0.8);
    }

    .hero h2 {
      font-size: 44px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .hero p {
      font-size: 20px;
      margin-top: 15px;
    }
  </style>
</head>
<body>

  <header>
    <h1>Sistema de Gestión</h1>
    <nav>
      <a href="ListadoUsuarios.php">Usuarios</a>
      <a href="ListadoClientes.php">Clientes</a>
      <a href="ListadoProveedores.php">Proveedores</a>
      <a href="ListadoFacturas.php">Facturas</a>
      <a href="ListadoDetalleFactura.php">DetalleFactura</a>
      <a href="ListadoInventario.php">Inventario</a>
      <a href="ListadoGastos.php">Gastos</a>
      <a href="ListadoProductos.php">Productos</a>
      <a href="ListadoReportes.php">Reportes</a>
      <a href="ListadoAuditoriaUsuarios.php">Auditoría</a>
      <a href="ListadoReporteUsuario.php">ReporteUsuarios</a>
      <a href="ReportesTablas.php">ReportesTablas</a>
    </nav>
  </header>

  <section class="hero">
    <h2>¡Es muy fácil!</h2>
    <p>Accede a toda la información del sistema desde el menú superior</p>
  </section>

</body>
</html>
