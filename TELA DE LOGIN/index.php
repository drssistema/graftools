<?php
    require_once 'CLASSES/usuarios.php';
    $u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../menu/icones/favicon.ico" type="image/x-icon">
    <title>Login DRS Sistemas &reg</title>
    <link rel="stylesheet" href="CSS/estilo.css">
    <script language='JavaScript' type='text/JavaScript'>
    function fechar_form(form) 
    {
        {
            window.close();
        }
    }
    </script>
</head>
<body>
    <center><div id="corpo-form">
    <center><img align="left" src="../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="100px" height="100px"/></center><br><br>
    <h2>DRS Sistemas &reg</h2>
    <h1>Entrar</h1>
    <form id="form-acessar" method="POST">
        

        <input type="email" name="email" placeholder="Usuário" maxlength="40">
        <input type="password" name="senha" placeholder="Senha" maxlength="15">
        <input type="submit" value="ACESSAR">
        <br><h3><a href="cadastrar.php" target="_blank">Ainda não é inscrito?  <strong> CADASTRE-SE </strong></a></h3>
        <center><h2> Powered by DRSSISTEMAS &reg</h2></center>
    </form>
    </div></center>
<?php
    if(isset($_POST['email']))
    {
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        if(!empty($email) && !empty($senha))
        {
            $u->conectar("dbdrs","mysql.uhserver.com","dbdrsadmin","688657Swf@");
            if($u->msgErro == "")
            {
                if($u->logar($email,$senha))
                {
                    header("location: AreaPrivada.php");
                }
                else
                {
                    ?>
                    <script language="JavaScript" type="text/JavaScript">window.alert
                    ("e-mail e/ou senha estão incorretos!");</script>
                    <?php
                }
            }else
            {
                echo "Erro: ".$u->msgErro;
            }
        }else
        {
            ?>
            <script language="JavaScript" type="text/JavaScript">window.alert
            ("Preencha todos os campos !");</script>
            <?php
        }
    }
?>
</body>
</html>