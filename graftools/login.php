<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Login - RH</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../menu/icones/favicon.ico" type="image/x-icon">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #1e3c72, #2a5298);
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .top-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .top-buttons button {
      padding: 10px 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .content {
      background-color: #fff;
      color: #000;
      padding: 30px 40px;
      border-radius: 10px;
      width: 100%;
      max-width: 450px;
      text-align: center;
      box-shadow: 0px 0px 20px rgba(0,0,0,0.3);
    }

    .content h2 {
      margin-bottom: 20px;
    }

    .content img {
      margin-bottom: 15px;
    }

    .form-group {
      text-align: left;
      margin: 15px 0;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .btn-actions {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .btn-actions input,
    .btn-actions button {
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-actions .acessar {
      background-color: aquamarine;
    }

    .btn-actions .limpar {
      background-color: antiquewhite;
    }

    .btn-actions .voltar {
      background-color: cornflowerblue;
      color: white;
    }

    .mensagem {
      color: red;
      font-weight: bold;
      margin-top: 10px;
    }
  </style>
  <script>
    function gerasenha() { location = 'geracripto.php'; }
    function paginainicial() { location = '../index.html'; }
    function telalogin() { location = 'login.php'; }
    function menu_graftools() { location = 'index.php'; }
  </script>
</head>
<body>
  <div class="top-buttons">
    <button onclick="gerasenha()">GERAR SENHA CRIPTOGRAFADA</button>
    <button onclick="paginainicial()">MENU INICIAL - DRSSISTEMAS</button>
    <button onclick="telalogin()">ATUALIZAR PÁGINA</button>
  </div>
  <div class="content">
    <img src="../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="80" height="80" />
    <h2>LOGIN (RH)</h2>
    <?php if (isset($_SESSION['msg'])): ?>
      <div class="mensagem"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>
    <form method="POST" action="valida.php">
      <div class="form-group">
        <label for="usuario">Usuário</label>
        <input type="text" name="usuario" id="usuario" placeholder="Digite seu login..." required />
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha..." required />
      </div>
      <div class="btn-actions">
        <input type="submit" class="acessar" name="btnLogin" value="Acessar" />
        <input type="reset" class="limpar" value="Limpar Campos" />
        <button type="button" class="voltar" onclick="menu_graftools()">Voltar ao Menu Inicial</button>
      </div>
    </form>
  </div>
</body>
</html>
