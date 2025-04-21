<?php
session_start();
if(!empty($_SESSION['id'])){
	echo "<h4>";
	echo "Usuário em sessão .: ".$_SESSION['nome']." <br>";
	echo "</h4>";

}else{
	$_SESSION['msg'] = "Área restrita - necessário Login";
	header("Location: loginchklist.php");	
}
?>

<html lang="pt-br">
	<head>
	    <meta charset="UTF-8">
	    <title>Check-List do Setor de Orçamentos - REV.: 00</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="description" content="Documento de Check-list do setor de orçamentos">
    	<meta name="author" content="David A R Silva - https://www.drssistemas.com.br/">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="../menu/icones/favicon.ico" type="image/x-icon">

		<script language='JavaScript' type='text/JavaScript'>
			//Escrito por DRS SISTEMAS
        	//https://www.drssistemas.com.br

			function printpage(form)
			{	
				window.print()
			}

			function sairchklist(form)
    		{
        		location='sairchklist.php' ;
    		}
			
	    </script>
		<script>
			jQuery(function() {
    
    			jQuery("#valor").maskMoney({
					prefix:'R$ ', 
					thousands:'.', 
					decimal:','
		})

		});
		</script>
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" 
		integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" 
		crossorigin="anonymous" referrerpolicy="no-referrer">
		</script> 

		<style>
			@media print
			{
				.imprime
				{
					display: none;
				}
			}
			button
			{
				background-color:blue;
				border-color:red;
				color:white;
			}
			body{
					font-size: 11px;
					background-color: rgb(240, 240, 240)
				}
			table
				{
					font-size: 11px;
					background-color: rgb(200, 230, 250)
				}
			th
				{
					background-color: rgb(62, 64, 149)
					font color="white"
				}
			form name
			{
				text-align: center;
			}
			label 
			{
				width: 80px;
				display: inline-block;
			}
			mark
        	{
            	background-color: yellow;
        	}
		</style>
	</head>
	<form name='aberturachklist'>
		<table>
			<tr>
				<th>
					<left><input type="button" class="imprime" value="Imprimir / Gerar PDF" onclick="printpage()" /></left>
					<left><input type="button" value="      SAIR CHECK-LIST     " onclick="sairchklist(this.form)" style="background-color:#91e40d;" /></left>
					<!-- <h2><a href='sairchklist.php'><b>Sair do Formulário Check-list</b> </a></h2> -->
				</th>
			</tr>
		</table>
	</form>
	<body>
		<div class="Content">
			<center>
			<table width="80%" cellspacing="3" cellpadding='0' border='2'>
				<h1>CHECK-LIST DO SETOR DE ORÇAMENTOS</h1>
				<h2>
					Reunião orçamentistas (10/08/2023)
					<br><br>
					<p style="text-align: left;">Checklist</p>
					<ol type=1 style="text-align: left;">
						<li>Buscar histórico anterior, permite avaliar todos os custos</li>
						<li>Cliente</li>
						<li>Código</li>
						<li>Descrição</li>
						<li>Quantidade</li>
						<li>Tipo de Entrega (Verificar estoque disponível)</li>
						<li>Condição de Pagamento (<mark>Analisar as últimas compras</mark></li>
						<li>Montagem e faca (Analisar <mark>se tem ou não</mark> destacador, estado da faca) - Analisar a faca antiga</li>
						<li>Cartão, tipo e gramatura (Analisar o <b>contratipo e estoque</b> disponível)</li>
						<li>Cores (Arquivo x Orçamento)</li>
						<li>Acabamentos: tipo de verniz, braille, relevo, hot stamping, laminação</li>
						<li>Criar pasta com estratégia de cada cliente e histórico de reajustes</li>
					</ol>		
				</h2>
			</table>
		</div>
	</body>
</html>