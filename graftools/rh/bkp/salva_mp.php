<?php
	include_once('conexao.php');
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$assunto = $_POST['assunto'];
	$mensagem = $_POST['mensagem'];

	$sql = "INSERT INTO tblmp (nome, email, assunto, mensagem, created) VALUES ('$nome', '$email', '$assunto', '$mensagem', NOW())";
	if (mysqli_query($conn, $sql)) {
      		echo "Novo registro criado com sucesso !!!";
	} else {
      		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
?>
<html lang="pt-br">
	<head>
		<script language='JavaScript' type='text/JavaScript'>

        	//Escrito por DRS SISTEMAS
        	//http://www.drssistemas.com.br
	        function fecha2(form)
	        {
	            	{              
	                	location='http://www.drssistemas.com.br/graftools/rh/frm_cadmp.php' ;
	            	}
	        }
	    	</script>
	</head>
	<body bgcolor="EEEEAA">
	
	    <form name='fecha'>
	        <input type='button' value=' VOLTAR ' onClick='fecha2(this.form)'>
	    </form>
	</body>
</html>