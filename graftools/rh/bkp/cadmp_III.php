<?php
?>
<html lang="pt-br">
	<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link rel="shortcut icon" href="icones/favicon.ico" type="image/x-icon">
	    <script language='JavaScript' type='text/JavaScript'>
	        function abertura2(form)
	        {
	            {              
					location='http://www.drssistemas.com.br/menu/abertura_graftools.htm' ;
	            }
	        }
	    </script>
	    <title>Formulário Movimentação de Pessoal - MP - REV.: 00</title>
		<link rel="stylesheet" href="estilos.css">
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	</head>
	<body>
	<div id="d1">
		<center>
		<table>
			<form name='FRM_MP'>
				<tr>
					<td colspan='1' rowspan='1'>
						<p>
							<center>
							<h3><center><a href="../../menu/abertura_graftools.htm" 
                            rel="next">VOLTAR AO MENU DE CADASTRO</a></center></h3>
							</center>
						</p>
					</td>
					<td colspan='1' rowspan='1'>
						<p>
							<center><font color="blue"><h3>PO RHS 006</font></br>
							<i><b>
							<label for="num_rev">REV  .:  00 </label>
							</b></i>
							</center>
						</p>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<center><font color="blue"><h3>    ANEXO 01</font></br>
								<i><b>
								<label for="Data">DATA:   <?php echo date("d/m/Y");?></label>
								</b></i>
								</center>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<font color="blue"><center><h3><i><b> MOVIMENTAÇÃO PESSOAL </b></i></h3></center></font>
					</td>
					<td colspan='1' rowspan='1'>
						<center><img align="center" src="/Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="130px" height="29px"/></center>
					</td>
				</tr></br>
			</form>
		</table>
	</div>
	<!-- 
	<script src="estilos.css"></script>
	-->
	</body>
</html>
