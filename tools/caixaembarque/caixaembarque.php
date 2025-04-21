<?php
session_start();

$DEBUG = false;
if (isset($_REQUEST["DEBUG"])) {
    $DEBUG = $_REQUEST["DEBUG"];
    if ($DEBUG == 1)
        $DEBUG = true;		
} 

$vid_user = "0";
$vusuario = "teste"; 
if (!$DEBUG) {
    if (empty($_SESSION['id'])){
        $_SESSION['msg'] = "Área restrita";
	header("Location: ../index.php");	
	return;
    }
    $vid_user = $_SESSION['id'];
    $vusuario = $_SESSION['nome'];
}

$vprog = explode('-',$_SESSION['prog']);
$vdescr = "";

if (in_array("02",$vprog)) {
    $vdescr = "./caixaembarque/caixaembarque.php";
} 
if (empty($vdescr)) {
    header("Location: ../index.php");	
    return;    
}



?>

<!DOCTYPE html>
<html>
<head>
<title>Caixa Embarque</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='../js/jquery-3.7.1.min.js'></script>
<script src='../js/jquery-ui.js'></script>
<link rel='stylesheet' href='../js/jquery-ui.css'>
<script src='../js/jquery.inputmask.js'></script>
<script src='../js/jspdf.min.js'></script>
<script src='modce.min.ob.js?version="5"'></script>

<link href="../js/datatables.min.css" rel="stylesheet">
 
<script src="../js/datatables.min.js"></script>
<script src="../js/dataTables.keyTable.js"></script>
<script src="../js/keyTable.dataTables.js"></script>
<link href="../js/keyTable.dataTables.css" rel="stylesheet">

<script src="../js/scroller.dataTables.js"></script>
<script src="../js/dataTables.scroller.js"></script>
<link href="../js/scroller.dataTables.css" rel="stylesheet">

<script src="../js/dataTables.select.js"></script>
<link href="../js/select.dataTables.css" rel="stylesheet">


<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  width: 100%;
  overflow : auto;
}

.header {
  position: fixed;
  top: 0vh;
  left: 0vh;
  background-color: #bbb;
  padding: 1px;
  text-align: center;
  font-size: 0.8vw;
  height : 2vw;
  width: 100%;
  z-index: 10;
}

/* Style the footer */
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #bbb;
  padding-top: 0px;
  padding-bottom: 2px;
  text-align: center;
  font-size: 0.5vw;
  height: 1vw;
}

.main {
  /*position: absolute;*/  
  top: 3vw;
  left: 0vw;
  padding: 0px;
  height: 100%;
  width: 100%;
  /* overflow: auto;*/
}

div.infcard {
  position: fixed;
  top: 6vh;
  left: 0vw;
  width: 15vw;
  height:50vw;
}
div.datacard {
  position: fixed;
  top: 6vh;
  left: 20vw;
  width: 50vw;
}
div.tempoProces {
  position:fixed;
  top: 27vh;
  left: 20vw;
  width : 20vw;
}
div.caixaChoice {
  position:fixed;
  top: 30vh;
  left: 20vw;
  width : 60vw;
}
<!--
#tbCaixaChoice {
  width:50%;
}
-->
div.cartuchoFrente {
  position:fixed;
  top: 27vh;
  left: 57vw;
  width : 10vw;
}
div.cartuchoLateral {
  position:fixed;
  top: 27vh;
  left: 77vw;
  width : 10vw;
}

div.mensagemErro {
  position:fixed;
  top: 34vh;
  left: 20vw;
  width : 70vw;
}

div.sentidoCartucho {
  position:fixed;
  top: 44vh;
  left: 1vw;
  width : 20vw;
  height: 50vw;

}
div.montagemCartucho {
  position:fixed;
  top: 40vh;
  left: 20vw;
  width: 20vw;
  height: 50vw;


}


div.tbcaixaEmb {
  position: fixed;
  top: 40vh;
  left: 57vw;
  width: 24vw;
  height: 50vw;
}
#tbcaixaEmbarque {
  height:5vw;

}

.divprint {
  display: none;	
}

table.dataTable th.focus,
table.dataTable td.focus {
  <!--outline: #4CAF50 solid 4px;-->
  background-color: yellow;  
}
table.dataTable td {
  font-size: 0.8vw;
  padding: 1px;
  font-weight: bold;
}
table.dataTable th {
  font-size: 0.8vw;
  padding:1px;
}

th {
  font-size: 0.8vw;
}
td {
  font-size: 0.8vw;
  width: 2vw;
}


div.minSpace {
   position:fixed;
   top:42vh;
   left:82vw;
   width:20vw;
}

div.btnAction {
   position:fixed;
   top:60vh;
   left:82vw;
   width:20vw;
}


input[type=text]:focus {
   background-color: yellow;
}
input {
  width:5vw;
  font-size: 0.8vw;
}
select {
  width: 5vw;
  font-size: 0.8vw;
}

legend {
  font-size: 0.8vw;
}
button {
  font-size: 0.8vw;
}

.tutorialtext {
  overflow: auto;	
  position: absolute;
  top: 0;
  left: 10px;
  font-size: 1vw;
  color: black;
  width:90%;
}



</style>



<script>
vid_user = <?php echo "'".$vid_user."'" ?>;
vusuario = <?php echo "'".$vusuario."'" ?>;

</script>


</head>

<body>
<div class='header' id='top_header'>
 <p style='width:10vw;float:left;color:blue;'>Usuario:<?php echo $vusuario ?></p>

 <button type='button' id='btnTutorial'  title='Tutorial' style='width:8vw'>Tutorial</button>
 <button type='button' id='btnCartao'  title='CARTÃO' style='width:8vw'>Cartão</button>
 <button type='button' id='btnGram'  title='GRAMATURA' style='width:8vw'>Gramatura</button>
 <button type='button' id='btnCaixa'  title='CAIXA'  style='width:8vw'>Caixas</button>
 <button type='button' id='btnMontagem'  title='MONTAGEM' style='width:8vw'>Montagem</button>
 <button type='button' id='btnCaixaEmb'  title='CAIXA EMBARQUE' style='width:8vw'>Caixa Embarque</button>
 <button type='button' id='btnExit'  title='SAIR' style='width:8vw;float:right;color:red;'>Sair</button>
 
</div>

<div class='main'>
<div class='infcard'>
<fieldset>
<legend>Informações do Cartão</legend>
<table>
  <tr>
   <th>Fecham.<br>Cartucho</th>
   <th>Cartão</th>
   <th>Gramatura</th>
  </tr>
  <tr>
   <td>
    <select id='fechamentos' name='fechamentos'>
      <option value='COMUM'>Comum</option>
      <option value='AUTOMATICO'>Automatico</option>
      <option value='HOTMELT'>Hotmelt</option>
      <option value='OUTROS'>Outros</option>
    </select>

   </td>
   <td> 
    <select id='cartoes' name='cartoes'>
      <option value='DP'>DP</option>
      <option value='TP'>TP</option>
    </select>
   </td>
   <td>
    <select id='gramaturas' name='gramaturas'>
     <option value=''></option>
    </select>

   </td>
  </tr>
  <tr>
   <td colspan=3>
     <p id='descricao_cartao'></p>
   </td>
  </tr>
  <tr>
    <td colspan=3>
      <img src='' id='getImageCard' style='max-width:50%;object-fit:contain;' >
    </td>
  </tr>
</table>

</fieldset>
</div>


<div class='datacard'>
<fieldset>
<legend>Medidas em Milimetros</legend>
<table>
<tr>
<th>FRENTE</th>
<th>LATERAL</th>
<th>ALTURA</th>
<th>DESCONTO<BR>LATERAL</th>
<th id='lblMedidaFundo'>MEDIDA<BR>FUNDO</th>
<th id='lblCalcAMED'>CALC A MED <BR>F.ALT PELA</th>
<th>ABA COLA</th>
<th>ABA SUPERIOR</th>
<th id='lblAbaInferior'>ABA INFERIOR</th>
<th>ACRÉSCIMO<BR>ESPESSURA<BR>EM %</th>
<th>ESPESSURA<br>CARTÃO</th>
</tr>
<tr>
<td><input type='text' id='frente' name='frente' class='decimal' style='font-weight:bold;' ></input></td>
<td><input type='text' id='lateral' name='lateral' class='decimal' style='font-weight:bold;' ></input></td>
<td><input type='text' id='altura' name='altura' class='decimal' style='font-weight:bold;' ></input></td>
<td><input type='number' id='desc_lat' name='desc_lat' value='0.50' step='0.1' class='decimal' style='font-weight:bold;' ></input></td>
<td id='td_med_f_aut'><input type='number' id='med_f_aut' name='med_f_aut' value='10.00' step='0.1' class='decimal' style='font-weight:bold;' ></input></td>
<td id='td_frente_lateral'>
	<select id='frente_lateral' name='frente_lateral' style='font-weight:bold;' onchange=''>
	  <option value='LATERAL'>Lateral</option>
	  <option value='FRENTE'>Frente</option>
	</select>
</td>
<td><input type='number' id='aba_cola' name='aba_cola' value='10.00' step='0.1' class='decimal' style='font-weight:bold;' ></input></td>
<td><input type='number' id='aba_superior' name='aba_superior' value='10.00' step='0.1' class='decimal' style='font-weight:bold;' ></input></td>
<td><input type='number' id='aba_inferior' name='aba_inferior' value='10.00' step='0.1' class='decimal' style='font-weight:bold;' ></input></td>
<td><input type='number' id='acrescimo_espessura' name='acrescimo_espessura' value='0' step='0.1' class='decimal' style='font-weight:bold;' ></input></td>
<td><input type='text' id='espessura_cartao' name='espessura_cartao' value=''  class='decimalf' style='font-weight:bold;' disabled></input></td>

</tr>
<tr style='color:red;font-weight:bold;'>
<th>FECHAMENTO</th>
<th>LARG</th>
<th>ALT</th>
<th>BASE</th>
<th>ALTURA</th>
<th>MED.ESPESSURA</th>
<th>*LARG</th>
<th style='font-size:12px;'> ==>Sentido</th>
<th COLSPAN=3></th>
</tr>
<tr>
<td><input type='text' id='tipo_fechamento' name='tipo_fechamento' style='color:blue;font-weight:bold;' disabled></input></td>
<td><input type='text' id='larg_aberto' name='larg_aberto' class='decimal' style='color:blue;font-weight:bold;' disabled></input></td>
<td><input type='text' id='alt_aberto' name='alt_aberto' class='decimal' style='color:blue;font-weight:bold;' disabled></input></td>
<td><input type='text' id='medida_base' name='medida_base' class='decimal' style='background-color:orange;color:blue;font-weight:bold;' disabled></input></td>
<td><input type='text' id='medida_altura' name='medida_altura' class='decimal' style='background-color:orange;color:blue;font-weight:bold;'  disabled></input></td>
<td><input type='text' id='media_espessura' name='media_espessura' class='decimalf' style='color:blue;font-weight:bold;' disabled></input></td>
<td><input type='text' id='larg_espelho_ii' name='larg_espelho_ii' class='decimal' style='color:blue;font-weight:bold;' disabled></input></td>
<td style='color:red;font-size:12px;font-weight:bold;'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp da Fibra</td>
<td colspan=3><button type='button' id='btnCalc'  style='font-weight:bold;' onclick='calcular()'>CALCULAR</button></td>

</tr>

</table>
</fieldset>
</div>

<div class='tempoProces'>
<label for = 'txtTempoProcess' style='font-size:0.8vw;'>Tempo Processamento</label>
<input type='text' id='txtTempoProcess' value='00:00:00' disabled></input>

<div>

<div class='caixaChoice'>
<table id='tbCaixaChoice'>
<tr>
<th>N.CX</th>
<th>Col</th>
<th>g/m2</th>
<th>C x L x A</th>
<th>Pallet</th>
<th>Canton.</th>
</tr>
<tr>
<td><input type='text' id='cx_ncx' style='background-color:#33e6ff;font-weight:bold;color:black;width:5vw;' disabled></input></td>
<td><input type='text' class='decimal' id='cx_col' style='font-weight:bold;color:black;width:5vw;' disabled></input></td>
<td><input type='text' class='decimal' id='cx_gm2' style='font-weight:bold;color:black;width:5vw;' disabled></input></td>
<td><input type='text' id='cx_cla' style='font-weight:bold;color:black;width:7vw;' disabled></input></td>
<td><input type='text' id='cx_pallet' style='background-color:#33e6ff;font-weight:bold;color:black;width:5vw;' disabled></input></td>
<td><input type='text' id='cx_canton' style='background-color:#33e6ff;font-weight:bold;color:black;width:5vw;' disabled></input></td>
</tr>
</table>
</div>

<div class='cartuchoFrente'>
<fieldset id='fieldsetFrente' style='background-color:white;'>
<legend>Cartucho Montados pela frente caixa</legend> 
<table id='cartuchoFrent'>
<tr>
<th>Qtde Cartuchos</th>
<th>Peso Kg</th>
<th>%</th>
</tr>
<tr>
<td><input type='text' id='txtQtdCartuchoF' class='decimal0' style='font-weight:bold;color:black;' disabled </input></td>
<td><input type='text' id='txtPesoF' class='decimal' style='font-weight:bold;color:black;' disabled </input></td>
<td><input type='text' id='txtPercentF' class='decimal' style='font-weight:bold;color:black;' disabled </input></td>
</tr>
</table>
</fieldset>
</div>
<div class='cartuchoLateral'>
<fieldset id='fieldsetLateral' style='background-color:white;'>
<legend>Cartucho Montados pela lateral caixa</legend> 
<table id='cartuchoLater'>
<tr>
<th>Qtde Cartuchos</th>
<th>Peso Kg</th>
<th>%</th>
</tr>
<tr>
<td><input type='text' id='txtQtdCartuchoL' class='decimal0' style='font-weight:bold;color:black;' disabled </input></td>
<td><input type='text' id='txtPesoL' class='decimal' style='font-weight:bold;color:black;' disabled </input></td>
<td><input type='text' id='txtPercentL' class='decimal' style='font-weight:bold;color:black;' disabled </input></td>
</tr>
</table>
</fieldset>

</div>

<div class='mensagemErro'>
<p id='txtMensagemErro' style='font-size:0.8vw;color:red;'>----</p>
<div>


<div class='sentidoCartucho' id='sentidoCartucho'>
<img src='' id='getImageSentido' style='max-width:80%;object-fit:contain;' ></td>
<table id='tbSentidoCartucho'>
<tr>
  <th>SENTIDO DO CARTUCHO</th>
<tr>
<tr>
   <td>
	<select id='cboSentidoCartucho' style='font-size:1vw;width:8vw;font-weight:bold;'>
	  <option value='PAISAGEM'>Paisagem</option>
	  <option value='RETRATO'>Retrato</option>
	</select>
	<script>
           /* 
	   function getSentidoImage() {
	      codigoMontagemCaixaEmbarque = '';
	      document.getElementById('txtCodigoMontagem').value = '';
	      document.getElementById('txtCodDescricaoColagem').innerHTML = '';
	      document.getElementById('txtCodSentidoCartucho').innerHTML = '';
		  
	      sel_imageMontagem(codigoMontagemCaixaEmbarque);
	      calcular();
	      if (!empty(document.getElementById('cx_ncx').value)) {
		  tableCaixaEmb
	   	    .column(0)
		    .data()
		    .each(function (value, index) {
			//console.log('Data in index: ' + index + ' is: ' + value);
			if (value === document.getElementById('cx_ncx').value) {
			   let row = index;
			   document.getElementById('cx_ncx').value = tbcaixas[row][1];
			   document.getElementById('cx_col').value = tbcaixas[row][2];
			   document.getElementById('cx_gm2').value = tbcaixas[row][3];
			   document.getElementById('cx_cla').value = tbcaixas[row][4]+tbcaixas[row][5]+tbcaixas[row][6]+tbcaixas[row][7]+tbcaixas[row][8];
			   document.getElementById('cx_pallet').value = tbcaixas[row][9];
			   document.getElementById('cx_canton').value = tbcaixas[row][10];
			   //console.log('pallet='+tbcaixas[row][8]);
			   //console.log('canton='+tbcaixas[row][9]);
			   varComprimento = tbcaixas[row][4];
			   varLargura = tbcaixas[row][6];
			   varAltura = tbcaixas[row][8];
			   varCubagem = tbcaixaCalc[row][12];
						
			   Identificando_Caixas();
			}
		   });
              }			
		  
	   }
           */
	</script>
   
   </td>
</tr>
</table>
</div>

<div class='montagemCartucho' id='montagemCartucho'>
<table id='tbMontagemCartucho' style='width:100%'>
<tr>
<td>CODIGO DA MONTAGEM</td>
<tr>
<tr>
<td><input type='text' id='txtCodigoMontagem' style='font-size:1.5vw;font-weight:bold;color:red;' disabled ></td>
<tr>
<td>
   <img src='' id='getImageMontagem' style='max-width:100%;object-fit:contain;' ></td>
</td>
</tr>
<tr>
<td><p id='txtCodDescricaoColagem' style='font-weight:bold;color:red;'></p></td>
</tr>
<tr>
<td><p id='txtCodSentidoCartucho' style='font-weight:bold;color:red;'></p></td>
</tr>
</table>
</div>

<div class='tbcaixaEmb' id='tbcaixaEmb'>
<!--<caption style='font-size:12px;'>CAIXAS DE EMBARQUE<caption> -->
<table id='tbcaixaEmbarque' class='display' cellspacing="0" width="100%">
<thead>
<tr>
<th colspan='8'>CAIXAS DE EMBARQUE</th>
</tr>
<tr>
<th style='width:5%;'>N.CX</th>
<th style='width:5%;'>Col.</th>
<th style='width:5%;'>g/m</th>
<th style='width:5%;'>C</th>
<th style='width:1%;'>x</th>
<th style='width:5%;'>L</th>
<th style='width:1%;'>x</th>
<th style='width:5%;'>A</th>
</tr>
</thead>
<tbody id='tbody'>
</tbody>
</table>
<img src='./images/Image_Setas.png' id='imgSetas' style='max-width:50%;object-fit:contain;' >
</div>

<div class='minSpace' id='minSpace'>
<label for='txtMinimoEspaco' style='font-size:0.8vw;'>Mínimo de espaço<br>na altura da caixa:</label>
<input type='number' id='txtMinimoEspaco' class='decimal' value='0' style='font-weight:bold;'/> 
<caption>mm</caption>
<div>

<div class='btnAction' id='btnAction'>
<button type='button' id='btnSave' style='width:8vw;font-weight:bold;' disabled>Gravar</button>
<br><input type='text' id='txtPkRec' value='0'  disabled />
<input type='text' id='txtDataRec' value=''  disabled /><br><br>  
<button type='button' id='btnPDF' style='width:8vw;font-weight:bold;' disabled>Gerar PDF</button><br><br>
<button type='button' id='btnReset' style='width:8vw;font-weight:bold;'>Limpar/Resetar campos</button>
<!--<button type='button' id='btnClose' style='width:50px;'>Sair</button>-->
<div>


</div>

<div class='divprint' id='divprint'>
   <table style='margin:0 auto;width:90%'>
    <tr>  
       <td id='r_num'></td> 
       <td>CAIXA EMBARQUE</td> 
       <td id='r_data'></td>
    </tr>
   </table>
   <table style='margin:0 auto;width:10%'>
    <tr>
       <th>Frente</th>       
       <th>Lateral</th>       
       <th>Altura</th>       
    </tr>   
    <tr>
       <td id='r_txtFrente_PDF'></td>       
       <td id='r_txtLateral_PDF' ></td>       
       <td id='r_txtAltura_PDF'></td>       
    </tr>   
   </table>       
   <table style='margin:0 auto;width:80%'>
    <tr>
       <th>Fechamento Cartucho</th>       
       <th>Base Cartucho</th>       
       <th>Altura Cartucho</th>       
       <th>Acrescimo Espess. em %</th>       
    </tr>   
    <tr>
       <td id='r_txtTipoFechamento_PDF'></td>       
       <td id='r_txtMedidaBase_PDF' ></td>       
       <td id='r_txtMedidaAltura_PDF'></td>       
       <td id='r_txtAcrescimoEspessura_PDF'></td>       
    </tr>   
   </table>       
   <table style='margin:0 auto;width:80%'>
    <tr>
       <th>N.CX</th>       
       <th>Col</th>       
       <th>g/m2</th>       
       <th>C x L x A</th>       
       <th>Pallet</th>       
       <th>Canton.</th>       
    </tr>   
    <tr>
       <td id='r_txtNumCX_PDF'></td>       
       <td id='r_txtColCX_PDF' ></td>       
       <td id='r_txtgm2CX_PDF'></td>       
       <td id='r_txtCLACX_PDF'></td>       
       <td id='r_txtPallet_PDF'></td>       
       <td id='r_txtCantoneira_PDF'></td>       
    </tr>   
   </table>       
   <table style='margin:0 auto;width:80%'>
    <tr>
       <th>Qtd Calculada</th>       
       <th>Peso Kg</th>       
       <th>%</th>       
       <th>Qtde Real</th>       
    </tr>   
    <tr>
       <td id='r_txtQtdeCartuchos_PDF'></td>       
       <td id='r_txtPesoCaixa_PDF' ></td>       
       <td id='r_txtAproveitamentoLateral_PDF'></td>       
       <td id='r_txtQtdeReal_PDF'></td>       
    </tr>   
   </table>       
        
        
   <table id='r_tbMontagemCartucho_PDF' style='width:100%'>
    <tr>
	<td>CODIGO DA MONTAGEM</td>
    <tr>
    <tr>
	<td id='r_txtCodigoMontagem_PDF' style='font-weight:bold;color:red;'></td>
    <tr>
	<td>
	   <img src='' id='r_getImageMontagem_PDF' style='max-width:80%;object-fit:contain;' ></td>
	</td>
    </tr>
    <tr>
	<td><p id='r_txtCodDescricaoColagem_PDF' style='font-weight:bold;color:red;'></p></td>
    </tr>
    <tr>
	<td><p id='r_txtCodSentidoCartucho_PDF' style='font-weight:bold;color:red;'></p></td>
    </tr>
   </table>
       
    
</div>

<script>
$(function() {
  
  document.getElementById("tbcaixaEmb").style.display = "none";
  document.getElementById("minSpace").style.display = "none"; 
  document.getElementById("btnAction").style.display = "none";  
  document.getElementById("montagemCartucho").style.display = "none";  
  document.getElementById("sentidoCartucho").style.display = "none";  
  query_mode = false;
  document.getElementById('btnPDF').disabled = true;
  document.getElementById('btnSave').disabled = false;
  
  
  
  $('.decimal').inputmask('currency', {'autoUnmask': true,
	radixPoint:',',
        groupSeparator: '.',
	allowMinus: true,
	rightAlign: true,
	inputtype:'text',
	prefix:'',
	digits: 2,
	unmaskAsNumber: true
  });

  $('.decimalf').inputmask('currency', {'autoUnmask': true,
	radixPoint:',',
        groupSeparator: '.',
	allowMinus: true,
	rightAlign: true,
	inputtype:'text',
	prefix:'',
	digits: 4,
	unmaskAsNumber: true
  });
  $('.decimal0').inputmask('currency', {'autoUnmask': true,
        radixPoint:',',
        groupSeparator: '.',
	allowMinus: true,
	rightAlign: true,
	inputtype:'text',
	prefix:'',
	digits: 0,
	unmaskAsNumber: true
  });
  
  
  $('input').on('keydown',function(e) {
      let keyCode = e.keyCode || e.which;
      if (e.keyCode === 13) {
         e.preventDefault();
         try {
            $('input')[$('input').index(this)+1].focus();
         } catch (ex) {
         	//document.getElementById('larguraPapel').focus();
         }         
      }
  
  });

  $( '#txtData1').datepicker({dateFormat:'dd/mm/yy'});  
  
  $('#fechamentos').get(0).selectedIndex = -1;
  $('#cartoes').get(0).selectedIndex = -1;
  document.getElementById('txtPkRec').value = 0;
  document.getElementById('txtDataRec').value = '';

  document.getElementById('desc_lat').value = 0.50;
  document.getElementById('med_f_aut').value = 10.00;
  document.getElementById('aba_cola').value = 10.00;
  document.getElementById('aba_superior').value = 10.00;
  document.getElementById('aba_inferior').value = 10.00;
  document.getElementById('acrescimo_espessura').value = 0;
  document.getElementById('espessura_cartao').value = 0;
  
  document.getElementById('txtQtdCartuchoL').value = 0;
  document.getElementById('txtPesoL').value = 0;
  document.getElementById('txtPercentL').value = 0;

  document.getElementById('txtQtdCartuchoF').value = 0;
  document.getElementById('txtPesoF').value = 0;
  document.getElementById('txtPercentF').value = 0;
	
  document.getElementById('cx_ncx').value = '';
  document.getElementById('cx_col').value = 0;
  document.getElementById('cx_gm2').value = 0;
  document.getElementById('cx_cla').value = '';
  document.getElementById('cx_pallet').value = '';
  document.getElementById('cx_canton').value = '';
	
  document.getElementById('tipo_fechamento').value = '';
  document.getElementById('larg_aberto').value = '';
  document.getElementById('alt_aberto').value = '';
  document.getElementById('medida_base').value = '';
  document.getElementById('medida_altura').value = '';
  document.getElementById('media_espessura').value = '';
  document.getElementById('larg_espelho_ii').value = '';

  
});
	
</script> 



<div class='tutorial' id='tutorial' title='Tutorial'>
  <div class="tutorialtext" id="tutorialtext">
  <p style="font-size: 1vw;">
      PERGUNTA PARA O DAVID R SILVA.
  </p>   
  </div>

  <script>
	
  </script>

</div>




<div id='frmCard' title='Cartão'>
 <div>
  <table id='tbCard1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
   <thead>
   <tr>
   <th>Tipo</th>
   <th>Descrição</th>
   </tr>
   </thead>
   <tbody id='tbodyCard1'>
   </tbody>
  </table>
 </div>
</div>
<div id='frmCardDetail' title='Cartão'>
<div>
  <input type='text' id='txtRowCard' style='width:5vw;' disabled></input>
  <input type='text' id='txtPkCard' style='width:5vw;' disabled></input></br></br>
  <table>
   <tr>
     <td>Tipo Cartão</td>
     <td><input type='text' id='txtTpCard' disabled></input></td>
   </tr>
   <tr>
     <td>Descrição</td>
     <td><input type='text' id='txtDescrCard' style='width:10vw' disabled></input></td>
   </tr>
  </table>
</div>
</div>


<div id='frmCardGram' title='Gramatura'>
	<div class='selCard'>
    <label for = 'selCard1'>Cartão</label>
	<select id='selCard1'>
	</select>	  
	</div>	  

	<div class='tbCardg'>
	<table id='tbCardg1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
	<thead>
	<tr>
	<th>CARTAO</th>
	<th>GRAMATURA</th>
	<th>ESPESSURA</th>
	<th>INDICE</th>
	</tr>
	</thead>
	<tbody id='tbodyCardg1'>
	</tbody>
	</table>
	</div>
</div>

<div id='frmCardGramDetail' title='Gramatura'>
 <input type='text' id='txtRowCardGram' style='width:5vw;' disabled></input>
 <input type='text' id='txtIndCardGram' style='width:5vw;' disabled></input>
 <input type='text' id='txtPkCardGram' style='width:5vw;' disabled></input>
 <input type='text' id='txtCardGram' style='width:5vw;' disabled></input><br><br>
 <label for = 'txtGram'>Gramatura</label>
 <input type='text' id='txtGram' class='decimal'></input><br><br>
 <label for = 'txtEspessuraGram'>Espessura</label>
 <input type='text' id='txtEspessuraGram' class='decimalf'></input>
</div>


<div id='frmCaixa' title='Caixas'>
	<table id='tbCaixa1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
	<thead>
	<tr>
	<th>NCX</th>
	<th>Col.</th>
	<th>g/m</th>
	<th>C</th>
	<th>L</th>
	<th>A</th>
	<th>Pallet</th>
	<th>Canton</th>
	</tr>
	</thead>
	<tbody id='tbodyCaixa1'>
	</tbody>
	</table>
</div>

<div id='frmCaixaDetail' title='Caixa'>
 <input type='text' id='txtRowCaixa' style='width:5vw;' disabled></input>
 <input type='text' id='txtPkCaixa' style='width:5vw;' disabled></input><br><br>
 
 <label for = 'txtNCX' style='display: inline-block;width:5vw;text-align:right;'>N.CX</label>
 <input type='text' id='txtNCX'></input><br><br>
 <label for = 'txtCol' style='display: inline-block;width:5vw;text-align:right;'>Col.</label>
 <input type='text' id='txtCol' class='decimal'></input><br><br>
 <label for = 'txtgm2' style='display: inline-block;width:5vw;text-align:right;'>gm2</label>
 <input type='text' id='txtgm2' class='decimal'></input><br><br>
 <label for = 'txtComp' style='display: inline-block;width:5vw;text-align:right;'>Comp.</label>
 <input type='text' id='txtComp' class='decimal'></input><br><br>
 <label for = 'txtLarg' style='display: inline-block;width:5vw;text-align:right;'>Larg.</label>
 <input type='text' id='txtLarg' class='decimal'></input><br><br>
 <label for = 'txtAlt' style='display: inline-block;width:5vw;text-align:right;'>Alt.</label>
 <input type='text' id='txtAlt' class='decimal'></input><br><br>
 <label for = 'txtPallet' style='display: inline-block;width:5vw;text-align:right;'>Pallet</label>
 <input type='text' id='txtPallet'></input><br><br>
 <label for = 'txtCanton' style='display: inline-block;width:5vw;text-align:right;'>Canton.</label>
 <input type='text' id='txtCanton'></input><br>
 
</div>

<div id='frmMontagem' title='Montagens'>
	<table id='tbMontagem1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
	<thead>
	<tr>
	<th>Código</th>
	<th>Descrição</th>
	<th>Sentido</th>
	</tr>
	</thead>
	<tbody id='tbodyMontagem1'>
	</tbody>
	</table>
</div>

<div id='frmMontagemDetail' title='Montagem'>
 <input type='text' id='txtRowMontagem' style='width:5vw;' disabled></input>
 <input type='text' id='txtPkMontagem' style='width:5vw;' disabled></input><br><br>
 
 <label for = 'txtCodMontagem1' style='display: inline-block;width:8vw;text-align:right;'>Código Montagem</label>
 <input type='text' id='txtCodMontagem1'></input><br><br>
 <label for = 'txtDescrMontagem' style='display: inline-block;width:8vw;text-align:right;'>Descrição Colagem</label>
 <input type='text' id='txtDescrMontagem' style='width:24vw;'></input><br><br>
 <label for = 'txtSentMontagem' style='display: inline-block;width:8vw;text-align:right;'>Sentido Cartucho</label>
 <input type='text' id='txtSentMontagem' style='width:24vw;' ></input><br><br>
 
</div>


<div id='frmCaixaEmb' title='Caixa Embarque'>
    <!--
    <label for = 'txtData1' style='display: inline-block;width:5vw;text-align:right;'>Data Pesquisa</label>
    <input type='text' id='txtData1' style='width:6vw;'></input>
    <button type='button' id='btnPesq'>Pesquisar</button><br><br>
    -->
    <label for="txtSearch" style='font-size: 0.8vw;'>Procurar</label> 
    <input type="text" id="txtSearch" style='width:30vw;font-size: 0.8vw;'></input>
    <button type="button" id='btnSearch' style="width: 4vw;font-size: 0.6vw">Procurar</button>
    <label for="txtRecord" style='font-size: 0.8vw;'>Registros</label> 
    <input type="text" id="txtRecord" style='width:4vw;font-size: 0.8vw;' value="50"></input>
    
    <table id='tbCaixaEmb1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
    <tr>
    <th>Numero</th>
    <th>Data</th>
    <th>Fechamento</th>
    <th>Cartão</th>
    <th>Gramatura</th>
    <th>Frente</th>
    <th>Lateral</th>
    <th>Altura</th>
    <th>Usuario</th>
    </tr>
    </thead>
    <tbody id='tbodyCaixaEmb1'>
    </tbody>
    </table>
</div>




<div id='frmPDF' title='PDF'>
 <input type='text' id='txtPkRec_PDF' value='0'  disabled />
 <input type='text' id='txtDataRec_PDF' value=''  disabled /><br><br>  

 <fieldset id='fs01'> 
   <table>
   <tr>
     <th>Frente</th>
     <th>Lateral</th>
     <th>Altura</th>
     <th>Fechamento Cartucho</th>
     <th>Base Cartucho</th>
     <th>Altura Cartucho</th>
     <th>Acréscimo Espess. em %</th>
   </tr>   
   <tr>
     <td><input type='text' id='txtFrente_PDF' class='decimal' style='background-color:#fcfcd3;color:black' disabled></input></td>  
	 <td><input type='text' id='txtLateral_PDF' class='decimal' style='background-color:#fcfcd3;color:black' disabled></input></td> 
	 <td><input type='text' id='txtAltura_PDF' class='decimal' style='background-color:#fcfcd3;color:black' disabled></input></td> 
	 <td><input type='text' id='txtTipoFechamento_PDF' style='background-color:orange;color:blue' disabled></input></td>
	 <td><input type='text' id='txtMedidaBase_PDF' class='decimal' style='background-color:orange;color:blue' disabled></input></td>
	 <td><input type='text' id='txtMedidaAltura_PDF' class='decimal' style='background-color:orange;color:blue' disabled></input></td>
	 <td><input type='text' id='txtAcrescimoEspessura_PDF' class='decimal' style='background-color:orange;color:blue' disabled></input></td>
   </tr>   

   </table>   
 </fieldset>
 <fieldset id='fs02'>
   <table>
   <tr>
     <th>N.CX</th>
     <th>Col</th>
     <th>g/m2</th>
     <th>C x L x A</th>
     <th>Pallet</th>
     <th>Canton.</th>
   </tr>
   <tr>     
     <td><input type='text' id='txtNumCX_PDF' style='color:black;background-color:#33e6ff' disabled></input> </td>
     <td><input type='text' id='txtColCX_PDF' class='decimal' style='color:black' disabled></input> </td>
     <td><input type='text' id='txtgm2CX_PDF' class='decimal' style='color:black' disabled></input> </td>
     <td><input type='text' id='txtCLACX_PDF' style='width:8vw;color:black' disabled></input> </td>
     <td><input type='text' id='txtPallet_PDF' style='color:black;background-color:#33e6ff' disabled></input> </td>
     <td><input type='text' id='txtCantoneira_PDF' style='color:black;background-color:#33e6ff' disabled></input> </td>
   </tr>
   </table>
   <p style='text-align:right;color:blue;font-size:1.5vw;'>Informe qual opção de montagem nas caixas</p>
 </fieldset>

 <fieldset id='fs03'>
 <legend>Cartucho Montado pela (FRENTE) da caixa</legend>
   <table> 
     <tr>
	   <th>Qtd Calculada</th>
	   <th>Peso Kg</th>
	   <th>%</th>
	   <th>Qtd Real</th>
	 </tr>
	 <tr>
	   <td><input type='text' id='txtQtdCartuchosFrente_PDF' class='decimal0' style='background-color:#fcfcd3;color:black' disabled></input> </td>
	   <td><input type='text' id='txtPesoCaixaFrente_PDF' class='decimal' style='background-color:#fcfcd3;color:black' disabled></input> </td>
	   <td><input type='text' id='txtAproveitamentoFrente_PDF' class='decimal' style='background-color:#fcfcd3;color:black' disabled></input> </td>
	   <td><input type='text' id='txtQtdeRealFrente_PDF' class='decimal0'></input> </td>
	 </tr>
   </table> 
   <div align='right'>    
   <input type='radio' id='montaFrente1' name='montaF1' value='FRENTE_CAIXA'>   
   <label for='montaFrente1' style='color:blue;font-size:1.5vw'>PELA FRENTE DA CAIXA</label>   
   </div>
 </fieldset>
 
 <fieldset id='fs04'>
 <legend>Cartucho Montado pela (LATERAL) da caixa</legend>
   <table> 
     <tr>
	   <th>Qtd Calculada</th>
	   <th>Peso Kg</th>
	   <th>%</th>
	   <th>Qtd Real</th>
	 </tr>
	 <tr>
	   <td><input type='text' id='txtQtdCartuchosLateral_PDF' class='decimal0' style='background-color:#fcfcd3;color:black' disabled></input> </td>
	   <td><input type='text' id='txtPesoCaixaLateral_PDF'  class='decimal' style='background-color:#fcfcd3;color:black' disabled></input> </td>
	   <td><input type='text' id='txtAproveitamentoLateral_PDF'  class='decimal' style='background-color:#fcfcd3;color:black' disabled></input> </td>
	   <td><input type='text' id='txtQtdeRealLateral_PDF'  class='decimal0'></input> </td>
	 </tr>
   </table>   
   <div align='right'>    
   <input type='radio' id='montaLateral1' name='montaL1' value='LATERAL_CAIXA'>   
   <label for='montaLateral1' style='color:blue;font-size:1.5vw'>PELA LATERAL DA CAIXA</label>   
   </div>
 </fieldset>
 
 <fieldset id='fs05'>
 <div class='montagemCartucho_PDF'>
	<table id='tbMontagemCartucho_PDF' style='width:100%'>
	<tr>
	<td>CODIGO DA MONTAGEM</td>
	<tr>
	<tr>
	<td><input type='text' id='txtCodigoMontagem_PDF' style='font-size:1vw;font-weight:bold;color:red;' disabled ></td>
	<tr>
	<td>
	   <img src='' id='getImageMontagem_PDF' style='max-width:80%;object-fit:contain;' ></td>
	</td>
	</tr>
	<tr>
	<td><p id='txtCodDescricaoColagem_PDF' style='font-weight:bold;color:red;'></p></td>
	</tr>
	<tr>
	<td><p id='txtCodSentidoCartucho_PDF' style='font-weight:bold;color:red;'></p></td>
	</tr>
	</table>
 </div>

 </fieldset>
 
 
</div>
<div id='frmPDFView' title='PDF'>
    <iframe src='' id='pdfView' height='100%' width="800"></iframe>
</div>


<script>





//$(document).ready(function() {
//  makeTableCard();   
//  makeTableCardg();
//  makeTableCaixa1();   
//  makeTableMontagem1();   
//  makeTableCaixaEmb1();
//  loadCard();
//  loadCardg();
//  loadCaixa();
//  loadMontagem();
//});




</script>

<div id='dialog-delete' title='Atenção!'>
  <p>Deleta o item?</p><br>
  <p id='delItem'></p>  
</div>
<div id='dialog-message' title='Message'>
  <p id='txtmsg'>  </p>
</div>
<div id='auth' title='Auth'>
  <p id='txtauth'>  </p>
</div>


<div class="footer" id="bottom_footer">
  <p style="font-size: 0.5vw;text-align: right">Powered by DRSSISTEMAS</p>
</div>

</body>
</html>
