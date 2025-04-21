<?php
session_start();
if(!empty($_SESSION['id'])){
  echo "<h4>";
	echo "Usuário em sessão .: ".$_SESSION['nome']." <br>";
	echo "</h4>";
}else{
	$_SESSION['msg'] = "Área restrita";
	header("Location: ../loginhot.php");	
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Hot Stamping - Home</title>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="https://www.drssistemas.com.br/menu/icones/favicon.ico" type="image/x-icon" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="css/custom.css" />
  
</head>

<body>
  <nav class="navbar">
    <div class="max-width">
      <div class="logo">
        <a href="../../index.html">
          <img src="../../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="50px" height="50px" alt="Logo" />
        </a>
      </div>
      <ul class="menu" id="menu-site">
        <li><a href="listar.php">CONSULTA (HOTSTAMPING)</a></li>
        <li><a href="incluir.php">INCLUIR (HOTSTAMPING)</a></li>
        <li><a href='../sairhot.php'>Voltar ao Login HotStamping</a></li>
        
      </ul>
      <div class="menu-btn" id="menu-btn">
        <i class="fa-solid fa-bars" id="menu-icon"></i>
      </div>
    </div>
  </nav>

  <footer>
    <span>Created By <a href="https://www.drssistemas.com.br">DRS Sistemas Ltda &reg</a></span>
  </footer>

  <script src="js/custom.js"></script>
</body>
</html>