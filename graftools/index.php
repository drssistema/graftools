<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #ece9e6, #ffffff);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
    }

    header {
      background-color: #1f3b4d;
      color: #fff;
      padding: 20px;
      width: 100%;
      text-align: center;
      font-size: 1.5em;
    }

    .logo {
      margin: 20px auto;
      text-align: center;
    }

    .logo img {
      width: 200px;
      height: auto;
    }

    .menu-container {
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      padding: 30px;
      background: #f9f9f9;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
      text-align: center;
    }

    .menu-container button {
      width: 100%;
      margin: 10px 0;
      padding: 14px;
      font-size: 1rem;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .menu-container button:hover {
      transform: scale(1.02);
      opacity: 0.9;
    }

    .btn-blue { background-color: cornflowerblue; color: white; }
    .btn-yellow { background-color: khaki; color: black; }
  </style>
  <script>
    function telaloginusr() { location = 'loginusr.php'; }
    function telalogin() { location = 'login.php'; }
    function telaloginchklist() { location = 'loginchklist.php'; }
    function telalogin_cx() { location = 'logincx.php'; }
    function telaloginhot() { location = 'loginhot.php'; }
    function paginainicial() { location = '../index.html'; }
    function gerasenha() { location = 'geracripto.php'; }
  </script>
  <link rel="shortcut icon" href="../menu/icones/favicon.ico" type="image/x-icon">
  <title>Menu Inicial - Ferramentas Gráficas</title>
</head>
<body>
  <header>Menu Inicial</header>
    <div class="logo">
      <img src="../Imagens e Logos/Imagens/LOGO6_DRS.jpg" alt="Logo DRS Sistemas" />
    </div>
  <div class="menu-container">
    <button class="btn-blue" onclick="telaloginusr()">USUÁRIOS</button>
    <button class="btn-blue" onclick="telalogin()">FORMULÁRIO MOVIMENTAÇÃO PESSOAL (RH)</button>
    <button class="btn-blue" onclick="telaloginchklist()">CHECK-LIST ORÇAMENTO (COML)</button>
    <button class="btn-blue" onclick="telalogin_cx()">CAIXA EMBARQUE (PROD)</button>
    <button class="btn-blue" onclick="telaloginhot()">CÁLCULO DE HOT STAMPING</button>
    <button class="btn-yellow" onclick="paginainicial()">MENU INICIAL - DRSSISTEMAS</button>
  </div>

</body>
</html>
