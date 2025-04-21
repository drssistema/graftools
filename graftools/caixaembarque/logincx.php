<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Login - Graf Tools Produção</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../../menu/icones/favicon.ico" type="image/x-icon" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #283e51, #485563);
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .top-buttons {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin-bottom: 25px;
    }
    .top-buttons button {
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
    .login-box {
      background-color: #fff;
      color: #000;
      padding: 30px;
      border-radius: 10px;
      max-width: 450px;
      width: 90%;
      text-align: center;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    .login-box img {
      margin: 5px;
    }
    .form-group {
      margin: 15px 0;
      text-align: left;
    }
    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .btn-actions {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .btn-actions input, .btn-actions button {
      padding: 10px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .acessar { background-color: aquamarine; }
    .limpar  { background-color: antiquewhite; }
    .voltar  { background-color: cornflowerblue; color: white; }
    .mensagem {
      color: red;
      margin-top: 10px;
    }
  </style>
  <script>
    function gerasenha() { location = 'geracripto.php'; }
    function telalogin() { location = 'logincx.php'; }
    function paginainicial() { location = 'https://www.drssistemas.com.br/index.html'; }
    function menu_graftools() { location = 'index.php'; }
  </script>
</head>
<body>

  <div class="top-buttons">
    <button onclick="gerasenha()">GERAR SENHA CRIPTOGRAFADA</button>
    <button onclick="paginainicial()">MENU INICIAL - DRSSISTEMAS</button>
    <button onclick="telalogin()">ATUALIZAR PÁGINA</button>
  </div>

  <div class="login-box">
    <img src="../../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="80" height="80" />
    <h2>LOGIN (PROD)</h2>

    <?php if (isset($_SESSION['msg'])): ?>
      <div class="mensagem"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <form method="POST" action="validacx.php">
      <div class="form-group">
        <label for="usuario">Usuário</label>
        <input type="text" name="usuario" id="usuario" placeholder="Digite seu login..." required />
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha..." required />
      </div>

      <div class="btn-actions">
        <input type="submit" name="btnLogin" class="acessar" value="Acessar" />
        <input type="reset" class="limpar" value="Limpar Campos" />
        <button type="button" class="voltar" onclick="menu_graftools()">Voltar ao Menu Inicial - Graf Tools</button>
      </div>
    </form>
  </div>

</body>
</html>
