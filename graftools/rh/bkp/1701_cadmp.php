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
					font-size: 12px;
					background-color: rgb(240, 240, 240)
				}
			table
				{
					font-size: 12px;
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
		</style>
	</head>
	
	<body>
	<center>
		<table width="70%" cellspacing="3" cellpadding='1' border='2'>
			<tr>
				<td colspan='1' rowspan='1'>
				<font color="blue"><center><h3><i><b>PO RHS 006</b></i></h3></center></font>
				</td>
				<td colspan='1' rowspan='1'>
					<font color="blue"><center><h3><i><b>ANEXO 01</b></i></h3></center></font>
				</td>
				<td colspan='2' rowspan='2'>
				<font color="blue"><center><h3><i><b> MOVIMENTAÇÃO PESSOAL </b></i></h3></center></font>
				</td>
				<td colspan='1' rowspan='2'>
				<center><img align="center" src="/Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="120px" height="50px"/></center>
				</td>
			</tr>
			<tr>
				<td colspan='1' rowspan='1'>
					<form>
						<label for="num_rev">REV.:</label></br>
						<input type="number" min="000" max="999" id="num_rev" name="rev" />
					</form>
				</td>
				<td colspan='1' rowspan='1'>
					<form>
							<label for="Data">Informe a Data:</label>
							<input type="date" maxlength="10" id="Data" name="Data"/><br/>
					</form>
				</td>
			</tr>
			</br>
			<tr>
				<td colspan='2' rowspan='1'>
					<form>
						<label for="num_mp">Nº da MP .:</label></br>
						<input type="number" min="00001" max="99999" id="num_mp" name="mp" />
					</form>
				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<label for="num_ano">ANO :</label></br>
						<input type="number" min="2022" max="2099" id="num_ano" name="ano" />
					</form>
				</td>
				<td colspan='2' rowspan='1'>
					<form>
							<label for="area">ÁREA :</label></br>
							<input type="text" maxlength="30" id="area" name="nome_area"/>
					</form>
				</td>
			</tr>
			<tr>
				<th colspan='5' rowspan='1'>
					<font color="blue"><center><h3><i><b> PROCESSO SELETIVO </b></i></h3></center></font>
				</th>
			</tr>
			<tr>
				<td colspan='1' rowspan='1'>
					<form>
						<p>
							<label for="lbl_data_ini_processo">INICIO DO PROCESSO:</label></br>
							<input type="date" maxlength="10" id="id_data_ini_processo" name="name_data_ini_processo"/>
						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_qtde_vagas">QTDE DE VAGAS:</label></br>
								<input type="number" min="01" max="99" id="id_qtde_vagas" name="name_qtde_vagas"/>

						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_cargo">CARGO:</label>
								<input type="text" maxlength="50" id="id_cargo" name="name_cargo"/>

						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_salario">SALARIO:</label>
								<input type="text" maxlength="20" id="id_salario" name="name_salario"/>

						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_total">TOTAL:</label></br>
								<input type="number" min="01" max="99" id="id_total" name="name_total"/>

						</p>
					</form>

				</td>
			</tr>
				<td colspan='1' rowspan='1'>
					<form>
						<p>
								<label for="lbl_gestor_imediato">GESTOR IMEDIATO:</label></br>
								<input type="text" width="10"  maxlength="30" id="id_gestor_imediato" name="name_gestor_imediato"/>
						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_contato">CONTATO:</label>
								<input type="text" width="10" maxlength="30" id="id_contato" name="name_contato"/>

						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_area">ÁREA:</label>
								<input type="text" width="10" maxlength="30" id="id_area" name="name_area"/>

						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_centro_custo_001">CENTRO CUSTO:</label></br>
								<input type="text" width="10" maxlength="30" id="id_centro_custo_001" name="name_centro_custo_001"/>

						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>

								<label for="lbl_horario_trabalho">HORÁRIO TRABALHO:</label></br>
								<input type="text" width="10" maxlength="30" id="id_horario_trabalho" name="name_horario_trabalho"/>

						</p>
					</form>

				</td>
			<tr>
				<td colspan='4' rowspan='1'>
					<form>
						<p>
								<font color="blue"><h3><label for="contratacao">TIPO CONTRATAÇÃO:</label></h3></font>
								<input type="checkbox" name="EFETIVO" value="false"/>E
								<input type="checkbox" name="TEMPORARIO" value="false"/>T
								<input type="checkbox" name="JA" value="false"/>JA
								<input type="checkbox" name="EST" value="false"/>EST
								<input type="checkbox" name="OUTROS" value="false"/>OUTROS

						</p>
					</form>

				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>
							<font color="blue"><h3><label for="confidencial">CONFIDENCIAL:</label></h3></font>
							<input type="checkbox" name="CONFIDENCIAL_SIM" value="on"/>SIM
							<input type="checkbox" name="CONFIDENCIAL_NAO" value="off"/>NÃO

						</p>
					</form>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<form>
						<p>
							<font color="blue"><h3>PERFIL DA VAGA:</br><textarea id="id_perfil_da_vaga" placeholder="Informe qual é o perfil desta vaga requirida.............................." required></textarea></h3></font>
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
							<font color="blue"><h3><left><label for="idioma">IDIOMA:</label></h3></font>
							<input type="checkbox" name="IDIOMA_SIM" value="on"/>SIM
							<input type="checkbox" name="IDIOMA_NAO" value="off"/>NÃO
						</p>
					</form>
				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>
							<font color="blue"><h3><left><label for="sexo">SEXO:</label></h3></font>
							<input type="checkbox" name="SEXO_MASC" value="on"/>MASC
							<input type="checkbox" name="SEXO_FEM" value="off"/>FEM
						</p>
					</form>
				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<p>
							<font color="blue"><h3><left><label for="dispon_viagens">DISPONIB. P/ VIAGENS:</label></h3></font>
							<input type="checkbox" name="DISPONIBILIDADE_SIM" value="on"/>SIM
							<input type="checkbox" name="DISPONIBILIDADE_NAO" value="off"/>NÃO
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
			<th colspan='5' rowspan='1'>
				<font color="blue"><center><h3><i><b> EXPERIÊNCIA PROFISSIONAL </b></i></h3></center></font>
			</th>
		</tr>
		<tr>
			<td colspan='5' rowspan='1'>
				<left><h3><i><b></b></i></h3></left>
				<br>
			</td>
		</tr>
		<tr>
			<th colspan='5' rowspan='1'>
				 <font color="blue"><center><h3><i><b> MOVIMENTAÇÃO DO EMPREGADO </b></i></h3></center></font>
			</th>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<font color="blue"><left><h4><i><b>NOME DO APROVADO:</b></i></h4></left></font>
			</td>
			<td colspan='2' rowspan='1'>
				<font color="blue"><left><h4><i><b>CARGO:</b></i></h4></left></font>
			</td>
			<td colspan='1' rowspan='1'>
				<font color="blue"><left><h4><i><b>MATRICULA:   </b></i></h4></left></font>
			</td>
		</tr>
		<tr>
			<th colspan='5' rowspan='1'>
			<font color="blue"><center><h3><i><b> TIPO DE MOVIMENTAÇÃO </b></i></h3></center></font>
			</th>
		</tr>
		<tr>
			<td colspan='3' rowspan='2'>
				<br>
				<left><h4><i><b>AUMENTO DE QUADRO C/ PREVISÃO ORÇAMENTÁRIA: [__]SIM  -  [__]NÃO</b></i></h4></left>
			</td>
			<td colspan='2' rowspan='1'>
				<left><i><b>SUBSTITUIÇÃO: [__] SIM  -  [__] NÃO</b></i></left>
				<tr>
					<td colspan='2' rowspan='1'>
						<left><i><b>AUMENTO DE CUSTO: [__] SIM  -  [__] NÃO</b></i></left>
					</td>
				</tr>
			</td>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> [__] PROCESSO SELETIVO   -   [__] INTERNO</b></i></left>
			</td>
			<td colspan='3' rowspan='1'>
				<left><i><b> NOME</b></i></left>
			</td>
		</tr>
		<tr>
			<td colspan='1' rowspan='2'>
				<br>
				<left><h4><i><b>[__] PROMOÇÃO </b></i></h4></left>
			</td>
			<td colspan='2' rowspan='1'>
				<left><i><b>NOVA FUNÇÃO</b></i></left>
			</td>
			<td colspan='2' rowspan='1'>
				<left><i><b>A PARTIR DE</b></i></left>
			</td>
			<tr>
				<td colspan='2' rowspan='1'>
					<left><i><b>MOTIVO</b></i></left>
				</td>
				<td colspan='2' rowspan='1'>
					<left><i><b>NOVO SALARIO</b></i></left>
				</td>
			</tr>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> [__] LICENÇA </b></i></left>
			</td>
			<td colspan='3' rowspan='1'>
				<left><i><b> MOTIVO: </b></i></left>
			</td>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> [__] AFASTAMENTO </b></i></left>
			</td>
			<td colspan='3' rowspan='1'>
				<left><i><b> MOTIVO: </b></i></left>
			</td>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> [__] DEMISSÃO </b></i></left>
			</td>
			<td colspan='3' rowspan='1'>
				<left><i><b> MOTIVO: </b></i></left>
			</td>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> [__] TRANSFERÊNCIA </b></i></left>
			</td>
			<td colspan='3' rowspan='1'>
				<left><i><b> MOTIVO: </b></i></left>
			</td>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> [__] ADVERTÊNCIA </b></i></left>
			</td>
			<td colspan='3' rowspan='3'>
				<left><i><b> MOTIVO: </b></i></left>
			</td>
			<tr>
				<td colspan='2' rowspan='1'>
					<left><i><b> [__] SUSPENSÃO </b></i></left>
				</td>
			</tr>
			<tr>
				<td colspan='2' rowspan='1'>
					<left><i><b> [__] JUSTA CAUSA </b></i></left>
				</td>
			</tr>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> [__] OUTROS </b></i></left>
			</td>
			<td colspan='3' rowspan='1'>
				<left><i><b> MOTIVO: </b></i></left>
			</td>
		</tr>
		<tr>
			<td colspan='2' rowspan='1'>
				<left><i><b> HORAS EXTRAS </b></i></left>
			</td>
			<td colspan='3' rowspan='2'>
				<left><i><b> MOTIVO: </b></i></left>
			</td>
			<tr>
				<td colspan='2' rowspan='1'>
					<left><i><b> [__] SIM    -    [__] NÃO </b></i></left>
				</td>
			</tr>
		</tr>
		<tr>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>DE AREA: </b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>CENTRO DE CUSTO</b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b> </b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>PARA ÁREA: </b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>CENTRO DE CUSTO</b></i></h4></left>
			</td>
		</tr>
		<tr>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>SALÁRIO: </b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>TOTAL: </b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b> </b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>SALÁRIO: </b></i></h4></left>
			</td>
			<td colspan='1' rowspan='1'>
				<left><h4><i><b>TOTAL: </b></i></h4></left>
			</td>
		</tr>
		<tr>
			<td colspan='5' rowspan='1'>
				<left><h3><i><b>OBSERVAÇÕES: </b></i></h3></left>
			</td>
		</tr>
		<br>
		<tr>
			<td colspan='1' rowspan='5'>
				<left><h4><i><b>APROVAÇÃO: </b></i></h4></left>
				<center><h4><i><b>          ___________________________________________          </b></i></h4></center>
				<center><h4><i><b>RESPONSÁVEL PELA ÁREA</b></i></h4></center>
				<form>
						<label for="responsavel"></label>
						<center><input type="text" maxlength="50" id="responsavel" name="nome_responsavel"/></center>
				</form>
					<left><h4><i><b>DATA: ___ / ___ / ______ </b></i></h4></left>
			</td>
			<td colspan='2' rowspan='5'>
				<left><h4><i><b>APROVAÇÃO: </b></i></h4></left>
				<center><h4><i><b>___________________________________________________</b></i></h4></center>
				<center><h4><i><b>DIRETORIA DA ÁREA</b></i></h4></center>
				<form>
						<label for="diretoria"></label>
						<center><input type="text" maxlength="50" id="diretoria" name="nome_diretoria"/></center>
				</form>
					<left><h4><i><b>DATA: ___ / ___ / ______ </b></i></h4></left>
			</td>
			<td colspan='2' rowspan='5'>
				<left><h4><i><b>APROVAÇÃO: </b></i></h4></left>
				<center><h4><i><b>___________________________________________________</b></i></h4></center>
				<center><h4><i><b>GERÊNCIA RECURSOS HUMANOS</b></i></h4></center>
				<form>
						<label for="recursos_humanos"></label>
						<center><input type="text" maxlength="50" id="rh" name="nome_rh"/></center>
				</form>
					<left><h4><i><b>DATA: ___ / ___ / ______ </b></i></h4></left>
			</td>
		</tr>
	</table>
</body>
<form name='abertura'>
	<input type='button' value=' VOLTAR ' onClick='abertura2(this.form)'>
</form>
</html>
