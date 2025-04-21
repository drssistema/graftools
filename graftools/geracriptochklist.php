<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="David A Ribeiro da Silva">
    <link rel="shortcut icon" href="../menu/icones/favicon.ico" type="image/x-icon">
    <script language='JavaScript' type='text/JavaScript'>
        function telaloginchklist(form) { location='loginchklist.php' ; }
    </script>
    <title> *** DRS Sistemas - Login Check-list  ***</title>
    <style>
		table
			{
				align-self: center;
				font-size: 15px;
				background-color:deepskyblue;
			}
	</style>
</head>
<body>
    <center><table cellspacing="3" cellpadding='0' border='2'>
        <tr>
            <td colspan='1'>
                <br>
                <center><img align="center" src="../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="80px" height="80px"/></center>
                <br><br>
            </td>
        </tr>
        <tr>
        <td colspan='1'>
                <center><h2>[     Senha criptografada     ]</h2></center>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo "<center><h3>Copie p/ alguma área a senha criptografada abaixo, depois </h3></center>";
                        echo "<center><h3>insira esta criptografia no campo senha do usuário no Cadastro Usuarios</h3></center>";
                        echo "<center><font color='blue'>";
                        echo $_SESSION['msg'];
                        echo "</font></center>";
                        echo "<br><br>";
                        unset($_SESSION['msg']);
                    }
                ?>
                </font></h2></center>
            </td>
        </tr>
        <tr>
            <td colspan="1" class="minusculo">
                <form name="aberturachklist" method="POST" action="valida_criptochklist.php"> 
                    <h3>
                        <p>
                            <center>
                            <!-- 
                            <br>
                            <img align="center" src="../Imagens e Logos/Imagens/users.bmp" width="25px" height="25px"/>
                            <label> Usuário</label>
                   // <input type="text" id="usu_login" name="usu_login" style="text-transform: lowercase;" placeholder="digite o seu  login...> 
                            <input type="text" id="usuario" name="usuario" placeholder="digite o seu login...">
                            <br><br><br>
                            -->
                            <img align="center" src="../Imagens e Logos/Imagens/img_cadeado.jpg" width="25px" height="25px"/>
                            <label> Senha   </label>
                            <input type='password' id="senha" name='senha' placeholder="digite a sua senha...">
                            <br><br>
                            </center>
                            <h2><center>
			                <!-- <input type='button' value=' OK ' onClick='confirmar(this.form)'> -->
		                    <input class="cor_btn" type="submit" name="btnLoginchklist" value="Gerar Senha" style="background-color: aquamarine;">
                            <input type='Reset' value='Limpar Campos' style="background-color: antiquewhite;">
                            <input type='button' value='Voltar p/ Tela Login' onClick='telaloginchklist(this.form)' target="_blank" style="background-color: yellow;">
                            </center></h2><br>
                            <center>
                            <h5><mark>
                            <a href="https://www.drssistemas.com.br/nitoli/geracriptochklist.php" rel="external">ATUALIZAR !</a>
                            </mark></h5>
                            </center>
                        </p>
                    </h3>
                </form>
            </td>
        </tr>
    </table></center>    
</body>
</html>
