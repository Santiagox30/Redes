<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sistema de Gestión</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #eaeef7;
    }
    .container {
      display: flex;
      height: 100vh;
    }
    .sidebar {
      width: 160px;
      background: linear-gradient(to bottom, #6db3f2, #1e69de);
      color: white;
      padding-top: 10px;
    }
    .sidebar h2 {
      font-size: 18px;
      text-align: center;
      margin: 10px 0;
      border-bottom: 2px solid black;
      color: black;
    }
    .sidebar form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .sidebar button {
      width: 120px;
      margin: 8px 0;
      padding: 10px;
      background-color: #4d4d4d;
      color: white;
      border: none;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
    }
    .main {
      flex: 1;
      background-color: #dcdcdc;
      padding: 20px;
      text-align: center;
    }
    .main h1 {
      color: #2a5db0;
      font-size: 28px;
      margin-bottom: 5px;
    }
    .main h2 {
      color: white;
      font-size: 18px;
      background-color: #2a5db0;
      display: inline-block;
      padding: 5px 10px;
      border-radius: 5px;
    }
    .main img {
      margin-top: 20px;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Opciones</h2>
      <form method="get">
        <button name="opcion" value="usuarios">USUARIOS</button>
        <button name="opcion" value="clientes">CLIENTES</button>
        <button name="opcion" value="proveedores">PROVEEDORES</button>
        <button name="opcion" value="facturas">FACTURAS</button>
        <button name="opcion" value="inventario">INVENTARIO</button>
        <button name="opcion" value="gastos">GASTOS</button>
      </form>
    </div>
    <div class="main">
      <h1>SISTEMA DE GESTION</h1>
      <h2>¡ES MUY FACIL!</h2><br>
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTdnoVKfbMDCRvETqG2GcTndlRIIhUQL3nOqA&s" />
    </div>
  </div>
</body>
</html>
