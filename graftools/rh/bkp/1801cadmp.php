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
		<table width="70%"cellspacing='1' cellpadding='1' border='1'>
			<tr>
				<td colspan='3' rowspan='1'>
					<center><i><b>PO RHS 006</b></i></center>
				</td>
				<td colspan='1' rowspan='3'>
					<center><h3><i><b> MOVIMENTAÇÃO PESSOAL </b></i></h3></center>
				</td>
				<td colspan='1' rowspan='3'>
				<center><img align="center" src="/Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="120px" height="50px"/></center>
				</td>
			</tr>
			<tr>
				<td colspan='3' rowspan='1'>
					<center><i><b>ANEXO 01</b></i></center>
				</td>
			</tr>
			<tr>
				<td colspan='1' rowspan='1'>
					<form>
						<label for="num_rev">REV .:</label>
						<input type="number" min="000" max="999" id="num_rev" name="rev" />
					</form>
				</td>
				<td colspan='2' rowspan='1'>
					<form>
							<label for="Data">Informe a Data:</label>
							<input type="date" maxlength="10" id="Data" name="nome"/><br/>
					</form>
				</td>
			</tr>
			</br>
			<tr>
				<td colspan='3' rowspan='1'>
					<form>
						<label for="num_mp">Nº da MP .: :</label>
						<input type="number" min="00001" max="99999" id="num_mp" name="mp" />
					</form>
				</td>
				<td colspan='1' rowspan='1'>
					<form>
						<label for="num_ano">ANO :</label>
						<input type="number" min="2022" max="2099" id="num_ano" name="ano" />
					</form>
				</td>
				<td colspan='1' rowspan='1'>
					<form>
							<label for="area">ÁREA :</label>
							<input type="text" maxlength="30" id="area" name="nome_area"/>
					</form>
				</td>
			</tr>
		</br>
		</br>
		</br>

			<tr>
				<th colspan='5' rowspan='1'>
					<center><i><b>[ ------------------ PROCESSO SELETIVO ------------------ ]</b></i></center>
				</th>
			</tr>
			<tr>
				<th colspan='1' rowspan='1'>
					<left><i><b>INICIO DO PROCESSO</b></i></left>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>QTDE DE VAGAS</b></i></left></br>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>      CARGO      </b></i></left></br>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>SALARIO</b></i></left></br>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>TOTAL</b></i></left></br>
				</th>
			</tr>
			<tr>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
			</tr>
			<tr>
				<th colspan='1' rowspan='1'>
					<left><i><b>GESTOR IMEDIATO</b></i></left>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>            CONTATO            </b></i></left></br>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>      ÁREA      </b></i></left></br>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>C/C</b></i></left></br>
				</th>
				<th colspan='1' rowspan='1'>
					<left><i><b>    HORARIO DE TRABALHO    </b></i></left></br>
				</th>
			</tr>
			<tr>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
				<td colspan='1' rowspan='1'>
					</br>
				</td>
			</tr>
			<tr>
				<td colspan='4' rowspan='1'>
					<left><i><b>TIPO CONTRATAÇÃO</b></i></left>
				</td>
				<td colspan='1' rowspan='1'>
					<left><i><b>CONFIDENCIAL - SIM / NÃO</b></i></left>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<left><h3><i><b>PERFIL DA VAGA</b></i></h3></left>
				</td>
			</tr>
			<tr>
				<td colspan='2' rowspan='1'>
					<left><h4><i><b>FORMAÇÃO ACADÊMICA:</b></i></h4></left>
					<br>
				</td>
				<td colspan='1' rowspan='1'>
					<left><h4><i><b>IDIOMA:</b></i></h4></left>
					<br>
				</td>
				<td colspan='1' rowspan='1'>
					<left><h4><i><b>SEXO:</b></i></h4></left>
					<br>
				</td>
				<td colspan='1' rowspan='1'>
					<left><h4><i><b>DISPONIBILIDADE P/ VIAGENS:</b></i></h4></left>
					<br>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<left><h3><i><b>CARACTERÍSTICAS COMPORTAMENTAIS / COMPETÊNCIAS</b></i></h3></left>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<left><h3><i><b>DESCRIÇÃO DAS ATIVIDADES</b></i></h3></left>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<center><i><b>[ ----     EXPERIÊNCIA PROFISSIONAL     ----]</b></i></center>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<left><h3><i><b></b></i></h3></left>
					<br>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<center><i><b>[ ----     MOVIMENTAÇÃO DO EMPREGADO     ----]</b></i></center>
				</td>
			</tr>
			<tr>
				<td colspan='2' rowspan='1'>
					<left><h4><i><b>NOME DO APROVADO:</b></i></h4></left>
				</td>
				<td colspan='2' rowspan='1'>
					<left><h4><i><b>CARGO:</b></i></h4></left>
				</td>
				<td colspan='1' rowspan='1'>
					<left><h4><i><b>MATRICULA:   </b></i></h4></left>
				</td>
			</tr>
			<tr>
				<td colspan='5' rowspan='1'>
					<center><i><b>[ ----     TIPO DE MOVIMENTAÇÃO     ----]</b></i></center>
				</td>
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
					<i><b>OBSERVAÇÕES: </b></i>
				</td>
			</tr>
		
			<br>
		
			<tr>
				<td colspan='1' rowspan='7'>
					<left><h4><i><b>APROVAÇÃO: </b></i></h4></left></br>
					<center><h4><i><b>______________________________________________________</b></i></h4></center>
					<center><h4><i><b>[------------  RESPONSÁVEL PELA ÁREA  -------------]</b></i></h4></center>
					<form>
							<label for="responsavel"></label>
							<center><input type="text" maxlength="50" id="responsavel" name="nome_responsavel"/></center>
					</form>
					</br>
					<left><h4><i><b>DATA: ___ / ___ / ______ </b></i></h4></left>
				</td>
				<td colspan='3' rowspan='7'>
					<left><h4><i><b>APROVAÇÃO: </b></i></h4></left></br>
					<center><h4><i><b>____________________________________________________</b></i></h4></center>
					<center><h4><i><b>[--------------  DIRETORIA DA ÁREA  ---------------]</b></i></h4></center>
					<form>
							<label for="diretoria"></label>
							<center><input type="text" maxlength="50" id="diretoria" name="nome_diretoria"/></center>
					</form>
					</br>
					<left><h4><i><b>DATA: ___ / ___ / ______ </b></i></h4></left>
				</td>
				<td colspan='1' rowspan='7'>
					<left><h4><i><b>APROVAÇÃO: </b></i></h4></left></br>
					<center><h4><i><b>____________________________________________________</b></i></h4></center>
					<center><h4><i><b>[-------  GERÊNCIA RECURSOS HUMANOS  ------]</b></i></h4></center>
					<form>
							<label for="recursos_humanos"></label>
							<center><input type="text" maxlength="50" id="rh" name="nome_rh"/></center>
					</form>
					</br>
					<left><h4><i><b>DATA: ___ / ___ / ______ </b></i></h4></left>
				</td>
			</tr>
		</table>

	</body>

	<form name='abertura'>
		<input type='button' value=' VOLTAR ' onClick='abertura2(this.form)'>
	</form>
</html>
