<?php
session_start();
if(!empty($_SESSION['id'])){
	echo "<h4>";
	echo "Usuário em sessão .: ".$_SESSION['nome']." <br>";
	echo "</h4>";
	//echo "Olá ".$_SESSION['nome'].", Bem vindo <br>";
	//echo "<a href='sair.php'>Sair</a>";
}else{
	$_SESSION['msg'] = "Área restrita";
	header("Location: login.php");	
}
?>

<html lang="pt-br">
	<head>
	    <meta charset="UTF-8">
	    <title>Formulário Movimentação de Pessoal - MP - REV.: 00</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="description" content="Cadastro de Movimentação de Pessoal">
    	<meta name="author" content="David A R Silva - https://www.drssistemas.com.br/">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="shortcut icon" href="icones/favicon.ico" type="image/x-icon">

		<script language='JavaScript' type='text/JavaScript'>

			function printpage(form)
			{	
				window.print()
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
					<font color="white">
					color: white;
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
	<form name='abertura'>
		<left><input type="button" class="imprime" value="Imprimir / Gerar PDF" onclick="printpage()" /></left>
		<!-- <input type='button' class="imprime" value='<-- Voltar ao Menu de Cadastro' onClick='abertura2(this.form)'> -->
		<a href='sair.php'>Sair do Formulário MP</a>

	</form>
	<body>
	<div class="Content">
		<center>
		<table width="80%" cellspacing="3" cellpadding='0' border='2'>
			<form name='FRM_MP'>
				<tr>
					<td colspan='1' rowspan='1'>
						<p>
							<center><font color="blue"><h3>PO RHS 006</font></br>
							<i><b>
							<label for="num_rev">REV  .:  00 </label>
							</b></i>
							</center>
						</p>
					</td>
					<td colspan='2' rowspan='1'>
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
						<font color="blue"><center><h3><i><b><mark> MOVIMENTAÇÃO PESSOAL </mark></b></i></h3></center></font>
					</td>
					<td colspan='1' rowspan='1'>
						<center><img align="center" src="/Imagens e Logos/Imagens/LOGO6-DRS.jpg" width="130px" height="29px"/></center>
					</td>
				</tr></br>
				<tr>
					<td colspan='2' rowspan='1'>
						<form></br>
							<i><b>
							<label for="num_mp">Nº da MP .:</label>
							</b></i>
							<input type="number" min="00001" max="99999" id="num_mp" name="mp" />
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form></br>
							<i><b>
							<label for="num_ano">ANO :</label>
							</b></i>
							<input type="number" min="2023" max="2099" id="num_ano" name="ano" />
						</form>
					</td>
					<td colspan='2' rowspan='1'>
						<form>
							<p></br>
								<i><b>
								<label for="iarea1">ÁREA</label>
								</b></i>
								<select name="area1" id="iarea1">
									<optgroup label="1.0 - Corporativo">
										<option value="VAZ"> </option>	
										<option value="RHU">1.1 Recursos Humanos</option>
										<option value="FIN">1.2 Financeiro</option>
										<option value="FAT">1.3 Faturamento</option>
										<option value="CMP">1.4 Compras</option>
										<option value="CML">1.5 Comercial</option>
										<option value="TI">1.6 TI</option>
									</optgroup>
									<optgroup label="2.0 - Industrial">
										<option value="PCP">2.1 PCP</option>
										<option value="MAN">2.2 Manutenção</option>
										<optgroup label="2.3.0 - Setor da Pré-impressão">
											<option value="PRE">2.3.1 Pré-impressão</option>
											<option value="DSV">2.3.2 Desenvolvimento</option>
										</optgroup>
										<option value="IMP">2.4 Impressão</option>
										<option value="QUA">2.5 Qualidade</option>
										<option value="EXP">2.6 Expedição</option>
										<option value="ACB">2.7 Acabamento</option>
										<option value="COL">2.8 Coladeira</option>
										<option value="C/V">2.9 Corte e Vinco</option>
										<option value="GUI">2.10 Corte e Guilhotina</option>
									</optgroup>
								</select>
							</p>
						</form>		
					</td>
				</tr>
				<tr>
					<td colspan='5' rowspan='1'>
						<p>
							<font color="blue"><center><h3><i><b> PROCESSO SELETIVO </b></i></h3></center></font>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="lbl_data_ini_processo">INICIO DO PROCESSO:</label>
								</b></i></br>
								<input type="date" maxlength="10" id="id_data_ini_processo" name="name_data_ini_processo"/>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="lbl_qtde_vagas">QTDE DE VAGAS:</label>
								</b></i></br>
								<input type="number" min="01" max="99" id="id_qtde_vagas" name="name_qtde_vagas"/>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="lbl_cargo">CARGO:</label>
								<input type="text" maxlength="50" id="id_cargo" name="name_cargo"/>
								</b></i>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>	
								<label for="lbl_salario">SALARIO:</label>
								</b></i>
								<!-- <input type="text" maxlength="20" id="id_salario" name="name_salario"/> -->
								<input type="text" id="id_salario" name="name_salario" class="form-control" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});">
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>	
								<label for="lbl_total">TOTAL:</label>
								</b></i></br>
								<!-- <input type="number" min="01" max="99" id="id_total" name="name_total"/> -->
								<input type="text" id="id_total" name="name_total" class="form-control" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});">
							</p>
						</form>
					</td>
				</tr>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="lbl_gestor_imediato">GESTOR IMEDIATO:</label>
								</b></i></br>
								<input type="text" width="10"  maxlength="30" id="id_gestor_imediato" name="name_gestor_imediato"/>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="lbl_contato">CONTATO:</label>
								</b></i>
								<input type="text" width="10" maxlength="30" id="id_contato" name="name_contato" placeholder="Informe o Ramal do Gestor" required>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="iarea2">ÁREA</label>
								</b></i>
								<select name="area2" id="iarea2">
									<optgroup label="1.0 - Corporativo">
										<option value="VAZ"> </option>	
										<option value="RHU">1.1 Recursos Humanos</option>
										<option value="FIN">1.2 Financeiro</option>
										<option value="FAT">1.3 Faturamento</option>
										<option value="CMP">1.4 Compras</option>
										<option value="CML">1.5 Comercial</option>
										<option value="TI">1.6 TI</option>
									</optgroup>
									<optgroup label="2.0 - Industrial">
										<option value="PCP">2.1 PCP</option>
										<option value="MAN">2.2 Manutenção</option>
										<optgroup label="2.3.0 - Setor da Pré-impressão">
											<option value="PRE">2.3.1 Pré-impressão</option>
											<option value="DSV">2.3.2 Desenvolvimento</option>
										</optgroup>
										<option value="IMP">2.4 Impressão</option>
										<option value="QUA">2.5 Qualidade</option>
										<option value="EXP">2.6 Expedição</option>
										<option value="ACB">2.7 Acabamento</option>
										<option value="COL">2.8 Coladeira</option>
										<option value="C/V">2.9 Corte e Vinco</option>
										<option value="GUI">2.10 Corte e Guilhotina</option>
									</optgroup>
								</select>
							</p>
						</form>		
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="lbl_centro_custo_001">CENTRO CUSTO:</label>
								</b></i></br>
								<input type="text" width="10" maxlength="30" id="id_centro_custo_001" name="name_centro_custo_001"/>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="lbl_horario_trabalho">HORÁRIO TRABALHO:</label>
								</b></i></br>
								<input type="text" width="10" maxlength="30" id="id_horario_trabalho" name="name_horario_trabalho" placeholder="Ex: 07:30 - 17:30h " required/>
							</p>
						</form>
					</td>
				<tr>
					<td colspan='3' rowspan='1'>
						<form>
							<p>
								<i><b>TIPO CONTRATAÇÃO:</b></i>
								<input type="checkbox" name="EFETIVO" value="false"/>E
								<input type="checkbox" name="TEMPORARIO" value="false"/>T
								<input type="checkbox" name="JA" value="false"/>JA
								<input type="checkbox" name="EST" value="false"/>EST
								<input type="checkbox" name="OUTROS" value="false"/>OUTROS
								<input type="text" width="30" maxlength="30" id="id_OUTROS" name="name_OUTROS"/>
							</p>
						</form>
					</td>
					<td colspan='2' rowspan='1'>
						<form>
							<p>
								<i><b>CONFIDENCIAL:</b></i>
								<input type="radio" name="CONFIDENCIAL" value="SIM"/>SIM
								<input type="radio" name="CONFIDENCIAL" value="NÃO"/>NÃO
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='5' rowspan='1'>
						<form>
							<p>
								<font color="blue"><h3>PERFIL DA VAGA:</br><textarea id="id_perfil_da_vaga" placeholder="Informe o perfil para esta vaga......." required></textarea></h3></font>
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<form>
							<p>
								<font color="blue"><h3>FORMAÇÃO ACADÊMICA:</br><textarea id="id_formacao_academica" placeholder="Informe a formação acadêmica do candidato mencionado......." required></textarea></h3></font>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>IDIOMA:</b></i>
								<input type="radio" name="IDIOMA" value="SIM"/>SIM
								<input type="radio" name="IDIOMA" value="NÃO"/>NÃO
								<br>
								<select name="idioma_opc" id="id_idioma_opc">
									<optgroup label="IDIOMA">
										<option value="VAZ"> </option>	
										<option value="ALE">Alemão</option>
										<option value="CHI">Mandarim</option>
										<option value="ESP">Espanhol</option>
										<option value="FRA">Francês</option>
										<option value="ITA">Italiano</option>
										<option value="ING">Inglês</option>
										<option value="OUT">Outros</option>
									</optgroup>
								</select>
								<input type='text' width="10" maxlength="10" id="id_nome_idioma"name="nome_idioma" placeholder="Informe no caso OUTROS..." required/> 
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>SEXO:</b></i>
								<input type="radio" name="SEXO" value="MASC"/>MASC
								<input type="radio" name="SEXO" value="FEMI"/>FEM
								<input type="radio" name="SEXO" value="AMBOS"/>AMBOS
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>DISPONIBILIDADE P/ VIAGENS:</b></i><br>
								<input type="radio" name="DISP_VIAGENS" value="SIM"/>SIM
								<input type="radio" name="DISP_VIAGENS" value="NÃO"/>NÃO
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='5' rowspan='1'>
						<form>
							<p>
								<font color="blue"><h3>CARACTERÍSTICAS COMPORTAMENTAIS / COMPETÊNCIAS:</br><textarea id="id_caract_comport" placeholder="Informe as características comportamentais.............................." required></textarea></h3></font>
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='5' rowspan='1'>
						<form>
							<p>
								<font color="blue"><h3>DESCRIÇÃO DAS ATIVIDADES:</br><textarea id="id_descr_ativid" placeholder="Informe as atividades da função mencionada............................." required></textarea></h3></font>
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='5' rowspan='1' cellspacing="1" cellpadding='1' border='2'>
						<form>
							<p>
								<font color="blue"><h3>EXPERIÊNCIA PROFISSIONAL:</br>
								<textarea id="id_esperiencia" placeholder="Informe a(s) experiência(s) deste(a) profissional..................." required></textarea></h3></font>
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='1' rowspan='1'>
						<h3>
							<center> </center>
						</h3>
						
						<i><b>NOME DO APROVADO :</b></i>
						<input type="text" width="10" id="id_nome_aprovado" name="name_nome_aprovado"/>
					</td>
					<td colspan='2' rowspan='1'>
						<font color="blue">
						<h3>
							<center>MOVIMENTAÇÃO DO EMPREGADO</center>
						</h3>
						</font>
						</br>
						<center><i><b>
							CARGO :
						</b></i>
						<input type="text" width="10" id="id_cargo" name="name_cargo"/>
						</center>
						</br>
					</td>
					<td colspan='2' rowspan='1'>
						<center><h3> </h3>
						<i><b>MATRICULA :</b></i>
						<input type="text" width="10" id="id_matricula" name="name_matricula"/>
						</center>
					</td>
				</tr>
				<tr>
					<td colspan='5' rowspan='1'>
						<form>
							<p>
								<center>
								<font color="blue"><h3>TIPO DE MOVIMENTAÇÃO</h3></font>
								</center>
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='3' rowspan='1'>
						<left><i><b>AUMENTO DE QUADRO C/ PREVISÃO ORÇAMENTÁRIA:</b></i></left>
						<input type="radio" name="AUMENTO_QUADRO" value="SIM"/>SIM
						<input type="radio" name="AUMENTO_QUADRO" value="NÃO"/>NÃO
					</td>
					<td colspan='2' rowspan='1'>
						<left><i><b>SUBSTITUIÇÃO             :</b></i></left>
						<input type="radio" name="SUBSTITUICAO" value="SIM"/>SIM
						<input type="radio" name="SUBSTITUICAO" value="NÃO"/>NÃO</br>
						<left><i><b>AUMENTO DE CUSTO  :</b></i></left>
						<input type="radio" name="AUMENTO_CUSTO" value="SIM"/>SIM
						<input type="radio" name="AUMENTO_CUSTO" value="NÃO"/>NÃO
					</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<left>
							<i><b>
							<input type="radio" name="PROCESSO" value="SEL"/>PROCESSO SELETIVO
							<input type="radio" name="PROCESSO" value="INT"/>INTERNO
							</b></i>	
						</left>
					</td>
					<td colspan='3' rowspan='1'>
						<p>
							<i><b> NOME :</b></i>
							<input type="text" width="30" id="id_nome_tipo_movim" name="nome_tipo_movim"/></br>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<left><i><b>
									<input type="checkbox" name="promocao" value="false"/>  PROMOÇÃO
								</b></i></left>
							</p>
						</form>
					</td>
					<td colspan='2' rowspan='1'>
						<form>
							<p>
								<i><b>NOVA FUNÇÃO    .:</b></i>
								<input type="text" width="30" id="id_nova_funcao" name="nome_nova_funcao"/><br>
								<i><b>MOTIVO                .:</b></i>
								<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
							</p>
						</form>
					</td>
					<td colspan='2' rowspan='1'>
						<form>
							<p>
								<i><b>A PARTIR DE     .:</b></i>
								<input type="text" width="30" id="id_a_partir_de" name="nome_a_partir_de"/><br>
								<i><b>NOVO SALARIO.:</b></i>
								<!-- <input type="text" width="30" id="id_novo_salario" name="nome_novo_salario"/> -->
								<input type="text" id="id_novo_salario" name="name_novo_salario" class="form-control" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});">
							</p>
						</form>
					</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<p>
								<left><i><b>
									<input type="checkbox" name="licenca" value="false"/>  LICENÇA
								</b></i></left>
						</p>
					</td>
					<td colspan='3' rowspan='1'>
						<p>
							<i><b>MOTIVO :</b></i>
							<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
						</p>
						</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<p>
							<left><i><b>
							<input type="checkbox" name="name_afastamento" value="false"/>  AFASTAMENTO
							</b></i></left>
						</p>
					</td>
					<td colspan='3' rowspan='1'>
						<p>
							<i><b>MOTIVO :</b></i>
							<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<p>
							<left><i><b>
							<input type="checkbox" name="name_demissao" value="false"/>  DEMISSAO
							</b></i></left>
						</p>
					</td>
					<td colspan='3' rowspan='1'>
						<p>
							<i><b>MOTIVO :</b></i>
							<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<p>
							<left><i><b>
							<input type="checkbox" name="name_transferencia" value="false"/>  TRANSFERÊNCIA
							</b></i></left>
						</p>
					</td>
					<td colspan='3' rowspan='1'>
						<p>
							<i><b>MOTIVO :</b></i>
							<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<left>
							<i><b>
							<input type="radio" name="name_ADVERTENCIA" value="ADV"/>ADVERTÊNCIA
							<input type="radio" name="name_SUSPENSAO" value="SPE"/>SUSPENSÃO
							<input type="radio" name="name_JUSTACAUSA" value="JCA"/>JUSTA CAUSA
							</b></i>
						</left>
					</td>
					<td colspan='3' rowspan='1'>
						<p>
							<i><b>MOTIVO :</b></i>
							<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
						</p>
					</td>
				<tr>
					<td colspan='2' rowspan='1'>
						<p>
							<left><i><b>
							<input type="checkbox" name="name_outros" value="false"/>  OUTROS
							</b></i></left>
						</p>
					</td>
					<td colspan='3' rowspan='1'>
						<p>
							<i><b>MOTIVO :</b></i>
							<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan='2' rowspan='1'>
						<left><i><b>HORAS EXTRAS:</b></i></left>
						<input type="radio" name="HORAS_EXTRAS" value="SIM"/>SIM
						<input type="radio" name="HORAS_EXTRAS" value="NÃO"/>NÃO
					</td>
					<td colspan='3' rowspan='1'>
						<left><i><b>MOTIVO :</b></i></left>
						<input type="text" width="30" id="id_motivo" name="nome_motivo"/>
					</td>
				</tr>
				<tr>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="iarea3">ÁREA</label>
								</b></i>
								<select name="area3" id="iarea3">
									<optgroup label="1.0 - Corporativo">
										<option value="VAZ"> </option>	
										<option value="RHU">1.1 Recursos Humanos</option>
										<option value="FIN">1.2 Financeiro</option>
										<option value="FAT">1.3 Faturamento</option>
										<option value="CMP">1.4 Compras</option>
										<option value="CML">1.5 Comercial</option>
										<option value="TI">1.6 TI</option>
									</optgroup>
									<optgroup label="2.0 - Industrial">
										<option value="PCP">2.1 PCP</option>
										<option value="MAN">2.2 Manutenção</option>
										<optgroup label="2.3.0 - Setor da Pré-impressão">
											<option value="PRE">2.3.1 Pré-impressão</option>
											<option value="DSV">2.3.2 Desenvolvimento</option>
										</optgroup>
										<option value="IMP">2.4 Impressão</option>
										<option value="QUA">2.5 Qualidade</option>
										<option value="EXP">2.6 Expedição</option>
										<option value="ACB">2.7 Acabamento</option>
										<option value="COL">2.8 Coladeira</option>
										<option value="C/V">2.9 Corte e Vinco</option>
										<option value="GUI">2.10 Corte e Guilhotina</option>
									</optgroup>
								</select>
							</p>
						</form>		
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="ic_c1">CENTRO CUSTO</label>
								</br>
								</b></i>
								<select name="c_c1" id="ic_c1">
									<optgroup label="CENTROS CUSTO">
										<option value="VAZ"> </option>	
										<option value="CML">Comercial</option>
										<option value="CMP">Compras</option>
										<option value="RHU">Recursos Humanos</option>
										<option value="FIN">Financeiro</option>
										<option value="TI">Setor TI</option>
										<option value="VEN">Vendas</option>
										<option value="PRE">Pré-Impressão</option>
										<option value="FAT">Faturamento</option>
										<option value="PCP">Plan Contr Prod</option>
									</optgroup>
								</select>
							</p>
						</form>		
					</td>
					<td colspan='1' rowspan='1'>
						<left><h4><i><b> </b></i></h4></left>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
						<p>
								<i><b>
								<label for="iarea4">ÁREA</label>
								</b></i>
								<select name="area4" id="iarea4">
									<optgroup label="1.0 - Corporativo">
										<option value="VAZ"> </option>	
										<option value="RHU">1.1 Recursos Humanos</option>
										<option value="FIN">1.2 Financeiro</option>
										<option value="FAT">1.3 Faturamento</option>
										<option value="CMP">1.4 Compras</option>
										<option value="CML">1.5 Comercial</option>
										<option value="TI">1.6 TI</option>
									</optgroup>
									<optgroup label="2.0 - Industrial">
										<option value="PCP">2.1 PCP</option>
										<option value="MAN">2.2 Manutenção</option>
										<optgroup label="2.3.0 - Setor da Pré-impressão">
											<option value="PRE">2.3.1 Pré-impressão</option>
											<option value="DSV">2.3.2 Desenvolvimento</option>
										</optgroup>
										<option value="IMP">2.4 Impressão</option>
										<option value="QUA">2.5 Qualidade</option>
										<option value="EXP">2.6 Expedição</option>
										<option value="ACB">2.7 Acabamento</option>
										<option value="COL">2.8 Coladeira</option>
										<option value="C/V">2.9 Corte e Vinco</option>
										<option value="GUI">2.10 Corte e Guilhotina</option>
									</optgroup>
								</select>
							</p>
						</form>		
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<i><b>
								<label for="ic_c2">CENTRO CUSTO</label>
								</br>
								</b></i>
								<select name="c_c2" id="ic_c2">
									<optgroup label="CENTROS CUSTO">
										<option value="VAZ"> </option>	
										<option value="CML">Comercial</option>
										<option value="CMP">Compras</option>
										<option value="RHU">Recursos Humanos</option>
										<option value="FIN">Financeiro</option>
										<option value="TI">Setor TI</option>
										<option value="VEN">Vendas</option>
										<option value="PRE">Pré-Impressão</option>
										<option value="FAT">Faturamento</option>
										<option value="PCP">Plan Contr Prod</option>
									</optgroup>
								</select>
							</p>
						</form>		
					</td>
				</tr>
				<tr>
					<td colspan='1' rowspan='1'>
						<i><b>SALÁRIO:</i></b></br>
						<!-- <input type="text" maxlength="12" id="id_salario_1" name="name_salario_1"/> -->
						<input type="text" id="id_salario_1" name="name_salario_1" class="form-control" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});">
					</td>
					<td colspan='1' rowspan='1'>
						<i><b>TOTAL:</i></b>
						<!-- <input type="text" maxlength="10" id="id_total_1" name="name_total_1"/> -->
						<input type="text" id="id_total_1" name="name_total_1" class="form-control" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});">
					</td>
					<td colspan='1' rowspan='1'>
						<left><h4><i><b> </b></i></h4></left>
					</td>
					<td colspan='1' rowspan='1'>
						<!-- <left><h4><i><b>SALÁRIO: </b></i></h4></left> -->
						<i><b>SALÁRIO:</i></b>
						<!-- <input type="text" maxlength="12" id="id_salario_2" name="name_salario_2"/> -->
						<input type="text" id="id_salario_2" name="name_salario_2" class="form-control" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});">
					</td>
					<td colspan='1' rowspan='1'>
						<i><b>TOTAL:</i></b>
						<!-- <input type="text" maxlength="10" id="id_total_2" name="name_total_2"/> -->
						<input type="text" id="id_total_2" name="name_total_2" class="form-control" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});">
					</td>
				</tr>
				<tr>
					<td colspan='5' rowspan='1'>
						<form>
							<p>
								<font color="blue"><h3>OBSERVAÇÕES:</br><textarea id="id_observacoes" 
								placeholder="Observações ............................." required></textarea></h3></font>
							</p>
						</form>
					</td>
				</tr>
				<br>
				<tr>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<h3><left>
									<label for="Data1">
										  DATA SOLIC:   <?php echo date("d/m/Y");?>
									</label>
								</left></h3>
								<h4>
									<left>  ASSINATURA:</left>
									</br></br></br>
									<center>_____________________________
									</center>
									</br>
									<center>RESPONSÁVEL DA ÁREA<br>
									<input type="text" maxlength="40" id="responsavel" name="nome_responsavel"/></center>
								</h4>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<h3><center>
									<label for="Datas">   </label>
								</center></h3>
								<h4>
									<left>  APROVAÇÃO:</left>
									</br></br></br>
									<center>________________________________
									</center>
										</br>
									<center>GESTOR DA ÁREA<br>
									<input type="text" maxlength="40" id="gestor" name="nome_gestor"/></center>
								</h4>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
						<h1>
							<form name='abertura'>
								<center>
								<br>
								<input type='button' class="imprime" value='Imprimir / Gerar PDF' onClick='printpage(this.form)'>
								<br>
								<!-- 
								<input type='button' class="imprime" value='<-- Voltar ao Menu de Cadastro' onClick='abertura2(this.form)'>
								-->
								<h6><a href='sair.php'>Sair do Formulário MP</a></h6>
								
								<h6><mark><a href="https://www.autentique.com.br/" class="imprime" target="_blank" rel="external">www.autentique.com.br</a></mark></h6>
								</center>
							</form>
						</h1>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<h3><center>
									<label for="Datas">   </label>
								</center></h3>
								<h4>
									<left>  APROVAÇÃO:</left>
									</br></br></br>
									<center>________________________________
									</center>
									</br>
									<center>DIRETORIA DA ÁREA<br>
									<input type="text" maxlength="40" id="diretoria" name="nome_diretoria"/></center>
								</h4>
							</p>
						</form>
					</td>
					<td colspan='1' rowspan='1'>
						<form>
							<p>
								<h3><center>
									<label for="Datas">   </label>
								</center></h3>
								<h4>
									<left>  ASSINATURA:</left>
									</br></br></br>
									<center>_____________________________
									</center>
									</br>
									<center>GERÊNCIA DO RH<br>
									<input type="text" maxlength="40" id="rh" name="nome_rh"/></center>
								</h4>
							</p><label for="lbl_branco"> </label>
						</form>
					</td>
				</tr>
			</form>
		</table>
	</div>
	<!-- 
	<center><button class="imprime" onclick="downloadPDF()" >  GERAR PDF  </button></center>
  	<script src="script.js"></script>
	-->
	</body>
</html>
