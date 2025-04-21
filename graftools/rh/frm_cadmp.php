<?php
?>
<html lang="pt-br">
	<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link rel="shortcut icon" href="icones/favicon.ico" type="image/x-icon">
	    <script language='JavaScript' type='text/JavaScript'>

        //Escrito por DRS SISTEMAS
        //http://www.drssistemas.com.br
	        function abertura2(form)
	        {
	            {              
	                location='http://www.drssistemas.com.br/index.htm' ;
	            }
	        }
	    </script>
	    <title> *** Sist Cadastro Graf Tools *** </title>
		<style>
			body{
					background-color: rgb(200, 230, 250)
				}
			table
				{
					font-size: 10px;
				}
		</style>
	</head>
	
	<body>
		<table cellpadding='5' border='1'>
			<tr>
				<td colspan='3' rowspan='1'>
					<form method="POST" action="salva_mp.php">
						Nome: <input type="text" name="nome" placeholder="Nome Completo" required></br></br>
						E-mail <input type="email" name="email" placeholder="Seu melhor e-mail" required></br></br>
						Assunto <input type="text" name="assunto" placeholder="Assunto do contato" required></br></br>
						Mensagem: <textarea name="mensagem"></textarea></br></br>
						<input type="submit" value="Enviar">
						<form name='abertura'>
							<input type='button' value=' VOLTAR ' onClick='abertura2(this.form)'>
						</form>
				</td>
			</tr>
		</table>
	</body>
</html>
