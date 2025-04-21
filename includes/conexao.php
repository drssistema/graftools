<?php
	$servidor = "mysql.uhserver.com";
	$dbname = "dbferramentas";	
	$usuario = "adm_principal";
	$senha = "688657Swf@";

	//Criar a conexão
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

	// Check connection
	if (!$conn) {
	      die("Conexão falhou: " . mysqli_connect_error());
	}
 
	echo "Conectado ao Banco de Dados [dbferramentas] com sucesso !  ";
	echo "<br>";
?>