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
    <title>Cadastro DRS Sistemas &reg</title>
    <link rel="stylesheet" href="CSS/estilo.css">
    <script language='JavaScript' type='text/JavaScript'>
    function menu_inicial(form) 
    {
        {
            location='https://www.drssistemas.com.br/TELA DE LOGIN/index.php' ;
        }
    }

    function fechar_form(form) 
    {
        {
            window.close();
        }
    }
    </script>
</head>
<body>
    <center><div id="corpo-form-cad">
    <center><img align="left" src="../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="100px" height="100px"/></center><br><br>
    <h2>DRS Sistemas &reg</h2>
    <h1>Cadastrar</h1>
    <form id="form-cadastrar" method="POST">
        <input type="text" name="nome" placeholder="Nome Completo" maxlength="30">
        <input type="text" name="telefone" placeholder="Telefone" maxlength="30">
        <input type="email" name="email" placeholder="Usuário" maxlength="40">
        <input type="password" name="senha" placeholder="Senha" maxlength="15">
        <input type="password" name="confSenha" placeholder="Confirmar Senha" maxlength="15">
        <input type="submit" value="CADASTRAR">
   <!-- <input type="button" value="VOLTAR AO LOGIN" onclick="fechar_form(this.form)"> -->
        <a href="javascript:void()" onclick="window.close()">VOLTAR AO LOGIN</a>
        <center><h2> Powered by DRSSISTEMAS &reg</h2></center>
    </form>
    </div></center>
    <?php
    require_once 'CLASSES/usuarios.php';
    $u = new Usuario;
//verificar se o botão foi clicado
    if(isset($_POST['nome']))
    {
        $nome = addslashes($_POST['nome']);
        $telefone  = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);
        $confirmarSenha = addslashes($_POST['confSenha']);
//verificar se esta preenchido
        if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
        {
            $u->conectar("dbdrs","mysql.uhserver.com","dbdrsadmin","688657Swf@");
            if($u->msgErro == "") //está ok
            {   
                if($senha == $confirmarSenha) 
                {
                    if($u->cadastrar($nome,$telefone,$email,$senha))
                    {
// Mensagem (Usuário Cadastrado com sucesso! )
                        ?>
                        <script language="JavaScript" type="text/JavaScript">window.alert
                        ("Usuário Cadastrado com sucesso! - Acesse agora com o novo usuário!"); window.close();</script>
                        <?php
                    }else
                    {
// Mensagem (E-mail já cadastrado !)
                        ?>
                        <script language="JavaScript" type="text/JavaScript">window.alert
                        ("E-mail já cadastrado !"); window.close();</script>
                        <?php
                    }
                }else
                {
// Mensagem (Divergência nas 2 senhas digitadas !)
                    ?>
                    <script language="JavaScript" type="text/JavaScript">window.alert
                    ("Divergência nas 2 senhas digitadas !");</script>
                    <?php
                }
            }else
            {
                echo "Erro: ".$u->msgErro;
            }
        }else
        {
// (Preencha todos os campos !)
            ?>
            <script language="JavaScript" type="text/JavaScript">window.alert
            ("Preencha todos os campos !");</script>
            <?php
        }
    }
    ?>
</body>
</html>