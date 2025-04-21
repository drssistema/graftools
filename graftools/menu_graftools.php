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
    function gerasenha(form) 
    {
        //location='https://www.drssistemas.com.br/graftools/geracripto.php' ;
        location='geracripto.php' ;
        
    }
    function telalogin(form) 
    {
        //location='https://www.drssistemas.com.br/graftools/login.php' ;
        location='login.php' ;
        
    }
    function telaloginchklist(form)
    {
        //location='https://www.drssistemas.com.br/graftools/loginchklist.php' ;
        location='loginchklist.php' ;
    }
    function telalogin_cx(form) 
    {
        //location='https://www.drssistemas.com.br/graftools/login.php' ;
        location='logincx.php' ;
        
    }
    function telaloginusr(form) 
    {
        //location='https://www.drssistemas.com.br/graftools/login.php' ;
        location='loginusr.php' ;
        
    }

    function paginainicial(form) 
    {
        location='../index.html' ;
        
    }
    </script>
    <title> *** Graf Tools - Menu  ***</title>
    <style>
		body
        {
            background-color:whitesmoke;
        }
        h1
        {
            color: blue;
        }
        h2
        {
            color: #242323;
        }
        h1, h2, table, tr, td, th
		{
            text-align: center;
 		}
        table, tr, td, th
        {
            border: 1px solid cornflowerblue;
            table-layout: auto;
        }
	</style>
    </head>
    <body>
        <h1><center>[   Menu Inicial   ]</center></h1>
        
        <table>
            <tr>
                <h2>    
                    <img align="center" src="../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="180px" height="35px"/></img>
                    <br><br><br>

                    <!-- ESSA É A PARTE ONDE É INSERIDO OS LINKS PARA LOCALIZAR OS ARQS HTML CRIADOS -->
                    
                    <ul style="list-style-type: none ">
                        <input type='button' value=' USUARIOS' onClick='telaloginusr(this.form)' target="_blank" style="background-color:cornflowerblue;">
                        <br><br>
                        <input type='button' value=' FORMULÁRIO MOVIMENTAÇÃO PESSOAL (RH) ' onClick='telalogin(this.form)' target="_blank" style="background-color:cornflowerblue;">
                        <br><br>
                        
                        <input type='button' value=' CHECK-LIST ORÇAMENTO (COML) ' onClick='telaloginchklist(this.form)' target="_blank" style="background-color:cornflowerblue;">
                        <br><br>
                        <input type='button' value=' CAIXA EMBARQUE (PROD) ' onClick='telalogin_cx(this.form)' target="_blank" style="background-color:cornflowerblue;">
                        <br><br>
                        
                        <input type='button' value=' MENU INICIAL - DRSSISTEMAS ' onClick='paginainicial(this.form)' target="_blank" style="background-color:khaki;">
                        <br><br>
                    </ul>
                </h2>
            </tr>
        </table>
    </body>
</html>
