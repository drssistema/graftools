<?php
session_start();
if(!empty($_SESSION['id'])){
	echo "<h4>";
	echo "Usuário em sessão .: ".$_SESSION['nome']." <br>";
	echo "</h4>";
}else{
	$_SESSION['msg'] = "Área restrita";
	header("Location: ../logincx.php");	
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Caixa Embarque</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='jquery-3.7.1.min.js'></script>
<script src='jquery-ui.js'></script>
<link rel='stylesheet' href='jquery-ui.css'>
<script src='jquery.inputmask.js'></script>
<script src='jspdf.min.js'></script>

<link href="datatables.min.css" rel="stylesheet">
 
<script src="datatables.min.js"></script>
<script src="dataTables.keyTable.js"></script>
<script src="keyTable.dataTables.js"></script>
<link href="keyTable.dataTables.css" rel="stylesheet">

<script src="scroller.dataTables.js"></script>
<script src="dataTables.scroller.js"></script>
<link href="scroller.dataTables.css" rel="stylesheet">

<script src="dataTables.select.js"></script>
<link href="select.dataTables.css" rel="stylesheet">


<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  width: 100%;
  overflow : auto;
}

.header {
  position: fixed;
  background-color: #bbb;
  padding: 1px;
  text-align: center;
  font-size: 0.8vw;
  height : 2vw;
  width: 100%;
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
  padding: 0px;
  height: 100%;
  width: 100%;
  overflow: auto;
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


table.dataTable th.focus,
table.dataTable td.focus {
  //outline: #4CAF50 solid 4px;
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
  fonte-size: 0.8vw;
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
var query_mode = false;
var Troca_Cartucho = false;
var tableCardg;

const tbfechamento = [
'Comum',
'Automatico',
'Hotmelt',
'Outros'
];

var tbcartao = [];
var tbcartaogram = [];

var tbgramatura = [];
var tbespessura = [];

var tbcaixas = [];

var tbcaixaCalc;

var tbmontagem = [];

let vTipoCartao = '';
let vPesoCartao = '';

function sel_gramatura() {
  let prefer = document.getElementById('cartoes').value;
  let x = document.getElementById('gramaturas');
  
  tbespessura = [];
  tbgramatura = [];  
  while (x.options.length > 0)
    x.remove(0);
  let j = 0;	
  for (let i = 0;i < tbcartaogram.length;i++) {
    if (prefer == tbcartaogram[i][1]) { 
        let option = document.createElement('option');
        option.text = tbcartaogram[i][2];
        x.add(option);
		tbespessura.push([]);
		tbespessura[j] = tbcartaogram[i][3];
		tbgramatura.push([]);
		tbgramatura[j] = tbcartaogram[i][2];
		j++;
	}
  }
  //console.log(tbespessura);
  for (let i=0;i<tbcartao.length;i++) {  
     if (prefer == tbcartao[i][1]) {
        vTipoCartao = tbcartao[i][2];
        document.getElementById('descricao_cartao').innerHTML = 'CARTÃO '+vTipoCartao;     
     }		
  }
  vPesoCartao = document.getElementById('gramaturas').value;
  document.getElementById('descricao_cartao').innerHTML = 'CARTÃO '+vTipoCartao+' '+vPesoCartao+'G';     

  return;
}



function sel_peso() {
  vPesoCartao = document.getElementById('gramaturas').value;
  document.getElementById('descricao_cartao').innerHTML = 'CARTÃO '+vTipoCartao+' '+vPesoCartao+'G';     

}

function sel_image() {
  let prefer = document.getElementById('fechamentos').value;
  let Image_Id = document.getElementById('getImageCard');
  
  prefer = prefer.toUpperCase();
  //console.log('fecha = '+prefer);
  Troca_Cartucho = true;
  
  if (prefer === '') {
     Image_Id.src = '';
     return;
  }       
  if (prefer==='COMUM') {
     Image_Id.src = './images/cartucho_comum.png';
  }
  else if (prefer==='AUTOMATICO') {
     Image_Id.src = './images/cartucho_fundo_automatico.png';
  }
  else if (prefer==='HOTMELT') {
     Image_Id.src = './images/cartucho_hotmelt.png';
  }
  else {
     Image_Id.src = './images/cartucho_outros.png';
  }
  if (prefer=='AUTOMATICO') {
     document.getElementById('med_f_aut').setAttribute('style','display:block','font-weight:bold');
     document.getElementById('frente_lateral').setAttribute('style','display:block','font-weight:bold'); 
     document.getElementById('med_f_aut').setAttribute('style','font-weight:bold');
     document.getElementById('frente_lateral').setAttribute('style','font-weight:bold'); 
     document.getElementById('lblMedidaFundo').innerHTML='MEDIDA<BR>FUNDO';
     document.getElementById('lblCalcAMED').innerHTML='CALC A MED <BR>F.ALT PELA'; 
     document.getElementById('aba_inferior').style.display = 'none';
     document.getElementById('lblAbaInferior').innerHTML = '';

     $('#cboSentidoCartucho').get(0).selectedIndex = 1;
     $('#frente_lateral').get(0).selectedIndex = 0;

  } else {
     document.getElementById('med_f_aut').setAttribute('style','display:none');
     document.getElementById('lblMedidaFundo').innerHTML='';
     document.getElementById('frente_lateral').setAttribute('style','display:none'); 
     document.getElementById('lblCalcAMED').innerHTML=''; 
     document.getElementById('aba_inferior').style.display = 'block';
     document.getElementById('lblAbaInferior').innerHTML = 'ABA INFERIOR';

     $('#cboSentidoCartucho').get(0).selectedIndex = 0;
     $('#frente_lateral').get(0).selectedIndex = 0;
  }	 
  
  if (prefer == 'OUTROS') {
     $('#txtmsg').text('Rotina do Cartucho OUTROS - ainda está em desenvolvimento!!!');
     dialogFMsg.dialog('open');
	 resetField();
  }

    document.getElementById('tbcaixaEmb').style.display = 'none';
    document.getElementById('minSpace').style.display = 'none'; 
    document.getElementById('btnAction').style.display = 'none';  
    document.getElementById('montagemCartucho').style.display = 'none';  
    document.getElementById('sentidoCartucho').style.display = 'none';  
    $('#frente_lateral').get(0).selectedIndex = 0;
	
  
    $('#txtCodigoMontagem').val('');
    $('#txtCodDescricaoColagem').text('');
    $('#txtCodSentidoCartucho').text('');
    $('#txtMensagemErro').text('');
	document.getElementById('getImageMontagem').src = '';
	document.getElementById('getImageSentido').src = '';
	
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
	
	document.getElementById('txtPkRec').value = 0;
	document.getElementById('txtDataRec').value = '';
  
    query_mode = false;
	document.getElementById('btnPDF').disabled = true;
	document.getElementById('btnSave').disabled = false;
  
}

function sel_imageMontagem(pcodigoMontagemCaixaEmbarque) {
  let prefer = pcodigoMontagemCaixaEmbarque;
  let Image_Id = document.getElementById('getImageMontagem');
  
  if (empty(prefer))
      prefer = '';
  prefer = prefer.toUpperCase();
  //console.log('fecha = '+prefer);
  
  if (prefer === '') {
     Image_Id.src = '';
	 document.getElementById('txtQtdCartuchoF').value = '';
	 document.getElementById('txtPesoF').value = ''; 
	 document.getElementById('txtQtdCartuchoL').value = '';
	 document.getElementById('txtPesoL').value = ''; 
     return;
  }       
  if (prefer==='ACFC') {
     Image_Id.src = './images/Image_ACFC.png';
  }
  else if (prefer==='ACLC') {
     Image_Id.src = './images/Image_ACLC.png';
  }
  else if (prefer==='AHFC') {
     Image_Id.src = './images/Image_AHFC.png';
  }
  else if (prefer==='AHLC') {
     Image_Id.src = './images/Image_AHLC.png';
  }
  else if (prefer==='BFAF') {
     Image_Id.src = './images/Image_BFAF.png';
  }
  else if (prefer==='BFAL') {
     Image_Id.src = './images/Image_BFAL.png';
  }
  else if (prefer==='AFAF') {
     Image_Id.src = './images/Image_AFAF.png';
  }
  else if (prefer==='AFAL') {
     Image_Id.src = './images/Image_AFAL.png';
  }
  else if (prefer==='AOFC') {
     Image_Id.src = './images/Image_AOFC.png';
  }
  else if (prefer==='AOLC') {
     Image_Id.src = './images/Image_AOLC.png';
  }
  else {
     Image_Id.src = '';
	 document.getElementById('txtQtdCartuchoF').value = '';
	 document.getElementById('txtPesoF').value = ''; 
	 document.getElementById('txtQtdCartuchoL').value = '';
	 document.getElementById('txtPesoL').value = ''; 
  }
}


var A3;
var C3;
var E3;
   
var G3; 
var I3; 
var K3; 
   
var M3;
var N3;
var M6;
   
var P3;
var Q3;
var R3;

var V3;
   
var M5;
var O5 = 0;
var U3 = 0;
var V10;
var X10 = 0;
var Z10 = 0;
var AB10 = 0;
var AD10 = 0;
var AF10 = 0;
var AE3 = 0;

var X3;
var Z3;
var AB3;
var AD3;
var AF3; 



function calcular() {
   if (empty(document.getElementById('fechamentos').value)) {
      $('#txtmsg').text('Falta Fechamento');
	  dialogFMsg.dialog('open');
      return;
   }
   if (empty(document.getElementById('cartoes').value)) {
      $('#txtmsg').text('Falta Cartao');
	  dialogFMsg.dialog('open');
      return;
   }
   if (empty(document.getElementById('frente').value)) {
      $('#txtmsg').text('Falta Frente');
	  dialogFMsg.dialog('open');
      return;
   }
   if (empty(document.getElementById('lateral').value)) {
      $('#txtmsg').text('Falta Lateral');
	  dialogFMsg.dialog('open');
      return;
   }
   if (empty(document.getElementById('altura').value)) {
      $('#txtmsg').text('Falta Altura');
	  dialogFMsg.dialog('open');
      return;
   }


   Troca_Cartucho = false;

   A3 = document.getElementById('fechamentos').value;
   C3 = document.getElementById('cartoes').value;
   E3 = Number(document.getElementById('gramaturas').value);
   
   G3 = Number(document.getElementById('frente').value); 
   I3 = Number(document.getElementById('lateral').value); 
   K3 = Number(document.getElementById('altura').value); 
   
   M3 = Number(document.getElementById('desc_lat').value);
   N3 = Number(document.getElementById('med_f_aut').value);
   M6 = document.getElementById('frente_lateral').value;
   
   P3 = Number(document.getElementById('aba_cola').value);
   Q3 = Number(document.getElementById('aba_superior').value);
   R3 = Number(document.getElementById('aba_inferior').value);

   V3 = Number(document.getElementById('acrescimo_espessura').value) / 100;
   
   M5 = document.getElementById('frente_lateral').value;
   O5 = 0;
   if (M5 === 'FRENTE')
      O5 = G3; 
   else 
      O5 = I3;
	  
   if (document.getElementById('cboSentidoCartucho').value == 'PAISAGEM' && document.getElementById('fechamentos').value == 'AUTOMATICO') {
      habilitarImagemAutomatico();  
   }	  
   else if (document.getElementById('cboSentidoCartucho').value == 'RETRATO' && document.getElementById('fechamentos').value == 'AUTOMATICO') {
      habilitarImagemAutomatico();   
   }	  
   else if (document.getElementById('cboSentidoCartucho').value == 'PAISAGEM') {
      habilitarImagemComumHotmelt();
   }
   
   function habilitarImagemAutomatico() {
      if (document.getElementById('cboSentidoCartucho').value == 'RETRATO') {
         let Image_Id = document.getElementById('getImageSentido');
         Image_Id.src = './images/Image_Cart_Fundo_Aut_Retrato.png';
	  }
	  else {
         let Image_Id = document.getElementById('getImageSentido');
         Image_Id.src = './images/Image_Cart_Fundo_Aut_Paisagem.png';
	  }
   }
   function habilitarImagemComumHotmelt() {
      if (document.getElementById('fechamentos').value == 'COMUM') {
         let Image_Id = document.getElementById('getImageSentido');
         Image_Id.src = './images/Image_Cart_Comum_Paisagem.png';
	     document.getElementById('cboSentidoCartucho').disabled = true;
	  }
	  else if (document.getElementById('fechamentos').value == 'HOTMELT') {
         let Image_Id = document.getElementById('getImageSentido');
         Image_Id.src = './images/Image_Cart_Hotmelt_Paisagem.png';
	     document.getElementById('cboSentidoCartucho').disabled = true;
	  }
	  else if (document.getElementById('fechamentos').value == 'OUTROS') {
         let Image_Id = document.getElementById('getImageSentido');
         Image_Id.src = './images/Image_Cart_Hotmelt_Paisagem.png';
	  }
   
   }
   
   
   //U3 =SE(A13>0;A13;SE(E13>0;E13;0))
   U3 = 0;
   /*
   if (C3.toUpperCase() === 'DP') {
     let xIndex = dp_gramatura.indexOf(E3);
	 U3 = dp_espessura[xIndex];
	 document.getElementById('espessura_cartao').value=U3;
   }
   if (C3.toUpperCase() === 'TP') {
     let xIndex = tp_gramatura.indexOf(E3);
	 U3 = tp_espessura[xIndex];
	 document.getElementById('espessura_cartao').value=U3;
   }
   */
   let xIndex = tbgramatura.indexOf(E3);
   U3 = tbespessura[xIndex];
   document.getElementById('espessura_cartao').value=U3;
   
   V10 = ((P3+G3+I3+G3+I3)-M3);
   X10 = 0;
   Z10 = 0;
   AB10 = 0;
   AD10 = 0;
   AF10 = 0;
   AE3 = 0;
   if (A3.toUpperCase()==='COMUM') {
       X10 = (R3+K3+Q3+(I3*2));
	   Z10 = (G3+I3);
	   AB10 = (R3+K3+Q3+(I3*2));
	   //AD10 = ((((U3/(1-V3))*3)+((U3/(1-V3))*3))/2);
	   AD10 = (U3/(1-V3))*3;
	   //console.log('U3='+U3);
	   //console.log('V3='+V3);
	   
	   //console.log('AD10='+AD10);
	   AD10 = AD10+((U3/(1-V3))*3);
	   //console.log('AD10='+AD10);
	   AD10 = AD10/2;
	   //console.log('AD10='+AD10);
	   AF10 = (V10/1000)*(X10/1000)*(E3/1000); 
   } 
   if (A3.toUpperCase()==='AUTOMATICO') {
       X10 = (((O5/2)+N3)+K3+I3+Q3);
	   Z10 = G3+I3;
	   AB10 = K3+I3+Q3; 
	   AD10 = ((((U3/(1-V3))*5)+((U3/(1-V3))*3))/2); 
	   AF10 = (V10/1000)*(X10/1000)*(E3/1000);
   } 
   if (A3.toUpperCase()==='HOTMELT') {
       X10 = R3+K3+Q3;
	   Z10 = G3+I3;
	   AB10 = R3+K3+Q3;
	   AD10 = ((((U3/(1-V3))*3)+((U3/(1-V3))*3))/2);
	   AF10 = (V10/1000)*(X10/1000)*(E3/1000);
   } 
   if (A3.toUpperCase()==='OUTROS') {
      X10 = R3+K3+Q3;
	  Z10 = G3+I3;
	  AB10 = R3+K3+Q3;
	  AD10 = ((((U3/(1-V3))*3)+((U3/(1-V3))*3))/2); 
	  AF10 = (V10/1000)*(X10/1000)*(E3/1000);
   } 
   let X3 = Z10;
   let Z3 = AD10;
   let AB3 = AB10;
   let AD3 =  ((G3/1000)*(I3/1000)*(K3/1000)*(E3/1000))*(1+AE3);
   let AF3 =  (X3/10)*(Z3/10)*(AB3/10); 
  
  
   document.getElementById('media_espessura').value = Z3;
   document.getElementById('tipo_fechamento').value = A3;
   document.getElementById('larg_aberto').value = V10;
   document.getElementById('larg_espelho_ii').value = V10;
   document.getElementById('alt_aberto').value = X10;
   document.getElementById('medida_base').value = Z10;
   document.getElementById('medida_altura').value = AB10;
   
   calcCaixa();
   function  calcCaixa() {
	   //console.log('tbcaixas = '+tbcaixas.length);
	   tbcaixaCalc = new Array(tbcaixas.length);

	   for(var i=0;i<tbcaixas.length;i++) {
		 tbcaixaCalc[i]  = new Array(14);
		 tbcaixaCalc[i][0] = 0;
		 tbcaixaCalc[i][1] = 0;
		 tbcaixaCalc[i][2] = tbcaixas[i][1]; //ncx
		 tbcaixaCalc[i][3] = tbcaixas[i][2]; //col
		 tbcaixaCalc[i][4] = tbcaixas[i][3]; //gm2
		 tbcaixaCalc[i][5] = tbcaixas[i][4]; //C
		 tbcaixaCalc[i][6] = tbcaixas[i][5]; //x
		 tbcaixaCalc[i][7] = tbcaixas[i][6]; //L
		 tbcaixaCalc[i][8] = tbcaixas[i][7]; //x
		 tbcaixaCalc[i][9] = tbcaixas[i][8]; //A
		 tbcaixaCalc[i][10] = tbcaixas[i][9]; //pallet
		 tbcaixaCalc[i][11] = tbcaixas[i][10]; //cantoneira
		 tbcaixaCalc[i][12] = tbcaixas[i][11]; //cubagem
		 tbcaixaCalc[i][13] = 0;
		 tbcaixaCalc[i][14] = 0;
		 
		 let AR3 = (tbcaixas[i][4]/10) * (tbcaixas[i][6]/10) * (tbcaixas[i][8]/10);
		 tbcaixaCalc[i][12] = AR3;
		 //console.log('AR3='+AR3);
		 //console.log('AF3='+AF3);
		 let AI3 = (AR3 / AF3) * 100;
		 AI3 = Math.floor(AI3) / 100;
		 
		 let AH3 = AF10 * AI3;
		 tbcaixaCalc[i][0] = AH3;
		 tbcaixaCalc[i][1] = AI3;
	   }
	   //console.log(tbcaixaCalc);
   }
   
   document.getElementById('tbcaixaEmb').style.display = 'block';
   document.getElementById('minSpace').style.display = 'block'; 
   document.getElementById('btnAction').style.display = 'block';  
   document.getElementById('montagemCartucho').style.display = 'block';  
   document.getElementById('sentidoCartucho').style.display = 'block';  
   tableCaixaEmb.columns.adjust().draw();	
   
}

function empty(e) {
  switch (e) {
    case "":
    case 0:
    case "0":
    case null:
    case false:
    case undefined:
      return true;
    default:
      return false;
  }
}


var Var_Frente_Lateral;
var Var_Frente;
var Var_Lateral;
var Var_Altura;
var TIPO_CARTAO;
var Var_Acrescimo_Espessura;
var Var_TextBox_Desc_Lat;
var Var_TextBox_Med_F_Aut;
var Var_TextBox_Aba_Cola;
var Var_TextBox_Aba_Superior;
var Var_TextBox_Aba_Inferior;
var Var_TextBox_Acrescimo_Espessura;
var Var_Valor_Acrescimo_Anterior;
var Var_Precentual_Alterado;
var Var_Comprimento;
var Var_Largura;
var Var_Limite_Espaco;
var Var_Frente_ou_Lateral;
var Var_Perdas;
var Qtd_Frente_Caixa;
var Qtd_Lateral_Caixa;
var Qtd_Altura_Caixa;

var Mensagem_Erro;
var Codigo_Montagem_Caixa_Embarque='';


function Identificando_Caixas() { 

    var Inicio = new Date();
	
    var Campo_Divisor;
    var Campo_Divisor_com_Decimal;
    var Resultado_Campo_Divisor;
    var Sentido_Cartucho;

    var Base_Cartucho;
    var Altura_Cartucho;
    
    var Largura;
    var Altura;
    var Gramatura;

    var Altura_Caixa;
    var Frente_Caixa;
    var Lateral_Caixa
    
    var Med_Espessura_Cartucho;
    var Qtd_Cartuchos_Caixa;
    var Qtd_Cartuchos_Caixa_Frente;
    var Qtd_Cartuchos_Caixa_Lateral;
    
    var Peso_Caixa;
    var Peso_Caixa_Frente;
    var Peso_Caixa_Lateral;
    var Min_Esp;
    var Var_Continue;
    var Var_Iguais;

	var codigoMontagemCaixaEmbarque;
    let Res_2;
    let Res_22;
	
	

    if (Troca_Cartucho == false) {
        Sentido_Cartucho = document.getElementById('cboSentidoCartucho').value;
        if (!empty(document.getElementById('medida_base').value))
           Base_Cartucho = Number(document.getElementById('medida_base').value);
        if (!empty(document.getElementById('larg_aberto').value)) 
           Largura = Number(document.getElementById('larg_aberto').value);
        if (!empty(document.getElementById('alt_aberto').value))
           Altura = Number(document.getElementById('alt_aberto').value);
        if (!empty(document.getElementById('gramaturas').value))
           Gramatura = Number(document.getElementById('gramaturas').value);
    
        if (!empty(document.getElementById('medida_altura').value))
           Altura_Cartucho = Number(document.getElementById('medida_altura').value);
        Altura_Caixa = varAltura
        Frente_Caixa = varComprimento
        Lateral_Caixa = varLargura
        Qtd_Altura_Caixa = 0
        Qtd_Frente_Caixa = 0
        Qtd_Lateral_Caixa = 0
        if (!empty(document.getElementById('media_espessura').value))
           Med_Espessura_Cartucho = Number(document.getElementById('media_espessura').value);
        Qtd_Cartuchos_Caixa = 0
        Qtd_Cartuchos_Caixa_Frente = 0
        Qtd_Cartuchos_Caixa_Lateral = 0
        Peso_Caixa = 0
        Peso_Caixa_Frente = 0
        Peso_Caixa_Lateral = 0
        Min_Esp = Number(document.getElementById('txtMinimoEspaco').value);
        Var_Continue = false;
        Var_Iguais = false;
    
        //Gerando_Imagens_Caixas_Embarque();
    
//   *****************************************************************************************************
//   *         ************************** SENTIDO DO CARTUCHO NA PAISAGEM ************************       *
//   *****************************************************************************************************
    
            if (Sentido_Cartucho == 'PAISAGEM') {
                Var_Continue = true;
                
                while (Var_Continue) {
                    if (Base_Cartucho != 0) {
                        if (Base_Cartucho != 0 && Base_Cartucho <= Altura_Caixa) {
                            if ((Altura_Caixa - Base_Cartucho) >= Min_Esp) {
                            
        //                      *****************************************************************************************************
        //                              ************************** QTD CARTUCHOS NA ALTURA ****************************
                                Campo_Divisor = Math.round(Altura_Caixa / Base_Cartucho);
                                Campo_Divisor_com_Decimal = Math.round((Altura_Caixa / Base_Cartucho) * 10000) / 10000;
                                if (Campo_Divisor > Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor - Campo_Divisor_com_Decimal)*10000)/10000;
                                    Resultado_Campo_Divisor = 1 - Resultado_Campo_Divisor;
                                } else if (Campo_Divisor < Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor_com_Decimal - Campo_Divisor)*10000)/10000;
                                    Res_2 = Campo_Divisor * Base_Cartucho;
                                } else if (Campo_Divisor == Campo_Divisor_com_Decimal) {
                                    Var_Iguais = true;
                                }
                                
                                if (Var_Iguais == false) {
                                    if ((Altura_Caixa - Res_2) < Min_Esp)
										Campo_Divisor = Campo_Divisor - 1;
                                    
                                    
                                    if (Resultado_Campo_Divisor >= 0.5) {
                                            
                                        //'** QTD CARTUCHOS NA ALTURA
                                        Qtd_Altura_Caixa = (Campo_Divisor_com_Decimal - Resultado_Campo_Divisor);
                                    } else if (Resultado_Campo_Divisor > 0 && Resultado_Campo_Divisor < 0.5) {
                                            
                                        //'** QTD CARTUCHOS NA ALTURA
                                        Qtd_Altura_Caixa = Campo_Divisor;
								    }
                                } else {
                                    Qtd_Altura_Caixa = Campo_Divisor;
                                    Var_Iguais = false;
                                }
                                    
        //                      *****************************************************************************************************
        //                         ***********************[ CALCULANDO O CARTUCHO PELA FRENTE DA CAIXA ]*************************
                    
        //                              ************************** QTD CARTUCHOS NA FRENTE ****************************
                                Var_Frente_Lateral = 'FRENTE';
                                Campo_Divisor = Math.round(Frente_Caixa / Altura_Cartucho);
                                Campo_Divisor_com_Decimal = Math.round((Frente_Caixa / Altura_Cartucho)*10000)/10000;
                                if (Campo_Divisor > Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor - Campo_Divisor_com_Decimal)*10000)/10000;
                                    Resultado_Campo_Divisor = 1 - Resultado_Campo_Divisor;
                                } else if (Campo_Divisor < Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor_com_Decimal - Campo_Divisor)*10000)/10000;
                                    Res_2 = Campo_Divisor * Altura_Cartucho;
                                } else if (Campo_Divisor == Campo_Divisor_com_Decimal) {
                                    Var_Iguais = true;
                                }
                                
                                if (Var_Iguais == false) {
                                
                                    if (Resultado_Campo_Divisor > 0.5) {
                                        
                                        //** QTD CARTUCHOS NA FRENTE
                                        Qtd_Frente_Caixa = (Campo_Divisor_com_Decimal - Resultado_Campo_Divisor)
                                    } else if (Resultado_Campo_Divisor >= 0 && Resultado_Campo_Divisor < 0.5) {
                                        
                                        //** QTD CARTUCHOS NA FRENTE
                                        Qtd_Frente_Caixa = Campo_Divisor;
								    }
                                } else {
                                    Qtd_Frente_Caixa = Campo_Divisor;
                                    Var_Iguais = false;
                                }
                                
                                //      ************************** QTD CARTUCHOS NA LATERAL ****************************
                                Campo_Divisor = Math.round(Lateral_Caixa / Med_Espessura_Cartucho);
                                
                                //** QTD CARTUCHOS NA LATERAL
                                Qtd_Lateral_Caixa = Campo_Divisor;
                
                                Qtd_Cartuchos_Caixa_Frente = Math.round(Qtd_Frente_Caixa * Qtd_Lateral_Caixa * Qtd_Altura_Caixa);
                                Peso_Caixa_Frente = Math.round((Largura / 1000) * (Altura / 1000) * (Gramatura / 1000) * Qtd_Cartuchos_Caixa_Frente*100)/100;
                                Calcular_Perdas_Caixas();
        //                      *****************************************************************************************************
        //                      *****************************************************************************************************
                            
                            
                            
                            
        //                      *****************************************************************************************************
        //                      ***********************[ CALCULANDO O CARTUCHO PELA LATERAL DA CAIXA ]*************************
        //                              ************************** QTD CARTUCHOS NA LATERAL ****************************
                                Var_Frente_Lateral = 'LATERAL';
                                Campo_Divisor = Math.round(Lateral_Caixa / Altura_Cartucho);
                                Campo_Divisor_com_Decimal = Math.round((Lateral_Caixa / Altura_Cartucho)*10000)/10000;
                                if (Campo_Divisor > Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor - Campo_Divisor_com_Decimal)*10000)/10000;
                                    Resultado_Campo_Divisor = 1 - Resultado_Campo_Divisor;
                                } else if (Campo_Divisor < Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor_com_Decimal - Campo_Divisor)*10000)/10000;
                                    Res_2 = Campo_Divisor * Altura_Cartucho;
                                } else if (Campo_Divisor == Campo_Divisor_com_Decimal) {
                                    Var_Iguais = true;
                                }
                            
                                if (Var_Iguais == false) {
                                    if (Resultado_Campo_Divisor >= 0.5) {
                                        
        //                                ** QTD CARTUCHOS NA LATERAL
                                        Qtd_Lateral_Caixa = (Campo_Divisor_com_Decimal - Resultado_Campo_Divisor);
                                    } else if (Resultado_Campo_Divisor >= 0 && Resultado_Campo_Divisor < 0.5) {
                                        
        //                                ** QTD CARTUCHOS NA LATERAL
                                        Qtd_Lateral_Caixa = Campo_Divisor;
                                    }
                                } else {
                                    Qtd_Lateral_Caixa = Campo_Divisor;
                                    Var_Iguais = false;
                                }
                                
        //                              ************************** QTD CARTUCHOS NA FRENTE ****************************
                                Campo_Divisor = Math.round(Frente_Caixa / Med_Espessura_Cartucho);
                                
        //                      ** QTD CARTUCHOS NA FRENTE
                                Qtd_Frente_Caixa = Campo_Divisor;
                                
                                Qtd_Cartuchos_Caixa_Lateral = Math.round(Qtd_Frente_Caixa * Qtd_Lateral_Caixa * Qtd_Altura_Caixa);
                                Peso_Caixa_Lateral = Math.round((Largura / 1000) * (Altura / 1000) * (Gramatura / 1000) *  Qtd_Cartuchos_Caixa_Lateral * 100)/100;
                            } else {
								document.getElementById('txtCodigoMontagem').value = '';
								Mensagem_Erro = 'A altura da Caixa ' + document.getElementById('cx_ncx').value +
											' que possui uma altura de ' +  Altura_Caixa +  ' mm é inferior à medida da Base do Cartucho de '
											+ Base_Cartucho + ' mm + o mín. de ' +  document.getElementById('txtMinimoEspaco').value + ' mm.';
                                //document.getElementById('txtMensagemErro').innerHTML = Mensagem_Erro;
								$('#txtmsg').text(Mensagem_Erro);
								dialogFMsg.dialog('open');
								
								sel_imageMontagem('');
								document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
								document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
                                Var_Continue = false;
                                return;
                            }
                            Calcular_Perdas_Caixas();
        //                  *****************************************************************************************************
        //                  *****************************************************************************************************
                        } else {
							document.getElementById('txtCodigoMontagem').value = '';
							Mensagem_Erro = 'A altura da Caixa ' + document.getElementById('cx_ncx').value +
										' que possui uma altura de ' +  Altura_Caixa +  ' mm é inferior à medida da Base do Cartucho de '
										+ Base_Cartucho + ' mm + o mín. de ' +  document.getElementById('txtMinimoEspaco').value + ' mm.';
                            //document.getElementById('txtMensagemErro').innerHTML = Mensagem_Erro;
							$('#txtmsg').text(Mensagem_Erro);
							dialogFMsg.dialog('open');
							sel_imageMontagem('');
							document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
							document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
                            Var_Continue = false;
                            return
                        }
                    } else {
                        document.getElementById('cx_pallet').value = '';
                        document.getElementById('cx_xanton').value = '';
                        document.getElementById('txtQtdCartuchoF').value = '';
                        document.getElementById('txtPesoF').value = '';
                        document.getElementById('txtQtdCartuchoL').value = '';
                        document.getElementById('txtPesoL').value = '';
                        Var_Continue = false;
                        return;
                    }
                    Var_Continue = false;
                }
                Var_Continue = true;
        //  *****************************************************************************************************
        //  *****************************************************************************************************
                
        //  *****************************************************************************************************
        //  *         ************************** SENTIDO DO CARTUCHO NO RETRATO  ************************       *
        //  *****************************************************************************************************
            } else if (Sentido_Cartucho == 'RETRATO') {
                Var_Continue = true;
                
                while (Var_Continue) {
                    if (Altura_Cartucho != 0) {
                        if (Altura_Cartucho != 0 && Altura_Cartucho <= Altura_Caixa) {
                            if ((Altura_Caixa - Altura_Cartucho) >= Min_Esp) {
                                
        //                      *****************************************************************************************************
        //                              ************************** QTD CARTUCHOS NA ALTURA ****************************
                                Campo_Divisor = Math.round(Altura_Caixa / Altura_Cartucho);
                                Campo_Divisor_com_Decimal = Math.round((Altura_Caixa / Altura_Cartucho)*10000)/10000;
                                if (Campo_Divisor > Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor - Campo_Divisor_com_Decimal)*10000)/10000;
                                    Resultado_Campo_Divisor = 1 - Resultado_Campo_Divisor;
                                } else if (Campo_Divisor < Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor_com_Decimal - Campo_Divisor)*10000)/10000;
                                    Res_22 = Campo_Divisor * Altura_Cartucho;
                                } else if (Campo_Divisor == Campo_Divisor_com_Decimal) {
                                    Var_Iguais = true;
                                }
                                    
                                if (Var_Iguais == false) {
                                    if ((Altura_Caixa - Res_22) < Min_Esp) 
										Campo_Divisor = Campo_Divisor - 1;
                                    
                                    
                                    if (Resultado_Campo_Divisor >= 0.5) {
                                            
                                        //** QTD CARTUCHOS NA ALTURA
                                        Qtd_Altura_Caixa = (Campo_Divisor_com_Decimal - Resultado_Campo_Divisor);
                                    } else if (Resultado_Campo_Divisor > 0 && Resultado_Campo_Divisor < 0.5) {
                                            
                                        //** QTD CARTUCHOS NA ALTURA
                                        Qtd_Altura_Caixa = Campo_Divisor;
                                    }
                                } else {
                                    Qtd_Altura_Caixa = Campo_Divisor;
                                    Var_Iguais = false;
                                }
        
        //                      *****************************************************************************************************
        //                      ***********************[ CALCULANDO O CARTUCHO PELA FRENTE DA CAIXA ]*************************
                    
        //                              ************************** QTD CARTUCHOS NA FRENTE ****************************
                                Var_Frente_Lateral = 'FRENTE';
                                Campo_Divisor = Math.round(Frente_Caixa / Base_Cartucho);
                                Campo_Divisor_com_Decimal = Math.round((Frente_Caixa / Base_Cartucho)*10000)/10000;
                                if (Campo_Divisor > Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor - Campo_Divisor_com_Decimal)*10000)/10000;
                                    Resultado_Campo_Divisor = 1 - Resultado_Campo_Divisor;
                                } else if (Campo_Divisor < Campo_Divisor_com_Decimal) {
                                    Resultado_Campo_Divisor = Math.round((Campo_Divisor_com_Decimal - Campo_Divisor)*10000)/10000;
                                    Res_22 = Campo_Divisor * Base_Cartucho
                                } else if (Campo_Divisor == Campo_Divisor_com_Decimal) {
                                    Var_Iguais = true;
                                }
                                    
                                if (Var_Iguais == false) {
                               
                                    if (Resultado_Campo_Divisor > 0.5) {
                                            
                                        //'** QTD CARTUCHOS NA FRENTE
                                        Qtd_Frente_Caixa = (Campo_Divisor_com_Decimal - Resultado_Campo_Divisor);
                                    } else if (Resultado_Campo_Divisor >= 0 && Resultado_Campo_Divisor < 0.5) {
                                            
                                        //'** QTD CARTUCHOS NA FRENTE
                                        Qtd_Frente_Caixa = Campo_Divisor;
                                    }
                                } else {
                                    Qtd_Frente_Caixa = Campo_Divisor;
                                    Var_Iguais = false;
                                }
                                    
        //                                ************************** QTD CARTUCHOS NA LATERAL ****************************
                                Campo_Divisor = Math.round(Lateral_Caixa / Med_Espessura_Cartucho);
                                
        //                      ** QTD CARTUCHOS NA LATERAL
                                Qtd_Lateral_Caixa = Campo_Divisor;
                
                                Qtd_Cartuchos_Caixa_Frente = Math.round(Qtd_Frente_Caixa * Qtd_Lateral_Caixa * Qtd_Altura_Caixa);
                                Peso_Caixa_Frente = Math.round((Largura / 1000) * (Altura / 1000) * (Gramatura / 1000) *  Qtd_Cartuchos_Caixa_Frente * 100)/100;
                                Calcular_Perdas_Caixas();
        //                      *****************************************************************************************************
        //                      *****************************************************************************************************
                                    
        //                      *****************************************************************************************************
        //                         ***********************[ CALCULANDO O CARTUCHO PELA LATERAL DA CAIXA ]*************************
        //                               ************************** QTD CARTUCHOS NA LATERAL ****************************
                                if (Altura_Cartucho != 0) {
                                    Var_Frente_Lateral = 'LATERAL';
                                
                                    if (Altura_Cartucho != 0 && Altura_Cartucho <= Lateral_Caixa) {
                                        if ((Lateral_Caixa - Altura_Cartucho) >= Min_Esp) {
                                            Campo_Divisor = Math.round(Lateral_Caixa / Base_Cartucho);
                                            Campo_Divisor_com_Decimal = Math.round((Lateral_Caixa / Base_Cartucho)*10000)/10000;
                                            if (Campo_Divisor > Campo_Divisor_com_Decimal) {
                                                Resultado_Campo_Divisor = Math.round((Campo_Divisor - Campo_Divisor_com_Decimal)*10000)/10000;
                                                Resultado_Campo_Divisor = 1 - Resultado_Campo_Divisor;
                                            } else if (Campo_Divisor < Campo_Divisor_com_Decimal) {
                                                Resultado_Campo_Divisor = Math.round((Campo_Divisor_com_Decimal - Campo_Divisor)*10000)/10000;
                                                Res_22 = Campo_Divisor * Base_Cartucho;
                                            } else if (Campo_Divisor == Campo_Divisor_com_Decimal) {
                                                Var_Iguais = True
                                            }
                                                
                                            if (Var_Iguais == false) {
                                                if (Resultado_Campo_Divisor >= 0.5) {
                                                    
                    //                              ** QTD CARTUCHOS NA LATERAL
                                                    Qtd_Lateral_Caixa = (Campo_Divisor_com_Decimal - Resultado_Campo_Divisor);
                                                } else if (Resultado_Campo_Divisor >= 0 && Resultado_Campo_Divisor < 0.5) {
                                                    
                    //                              ** QTD CARTUCHOS NA LATERAL
                                                    Qtd_Lateral_Caixa = Campo_Divisor;
                                                }
                                            } else {
                                                Qtd_Lateral_Caixa = Campo_Divisor;
                                                Var_Iguais = false;
                                            } 
                                        } else {
											Mensagem_Erro = 'A Largura da Caixa ' +  document.getElementById('cx_ncx').value + 
																' que possui uma Largura de ' + Lateral_Caixa + ' mm é inferior à medida da Altura do Cartucho de '
															   + Altura_Cartucho + ' mm + o mín. de ' + document.getElementById('txtMinimoEspaco').value + ' mm.'
                                            //document.getElementById('txtMensagemErro').innerHTML = Mensagem_Erro;
								            $('#txtmsg').text(Mensagem_Erro);
								            dialogFMsg.dialog('open');
											sel_imageMontagem('');
            								document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
			            					document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
                                            Var_Continue = false;
                                            return;
                                        }
                                    } else {
										Mensagem_Erro = 'A Largura da Caixa ' +  document.getElementById('cx_ncx').value + 
															' que possui uma Largura de ' + Lateral_Caixa + ' mm é inferior à medida da Altura do Cartucho de '
														   + Altura_Cartucho + ' mm + o mín. de ' + document.getElementById('txtMinimoEspaco').value + ' mm.'
                                        //document.getElementById('txtMensagemErro').innerHTML = Mensagem_Erro;
								        $('#txtmsg').text(Mensagem_Erro);
								        dialogFMsg.dialog('open');
										sel_imageMontagem('');
								        document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
								        document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
                                        Var_Continue = false;
                                        return;
                                    }
                                } else {
									document.getElementById('cx_pallet').value = '';
									document.getElementById('cx_canton').value = '';
									document.getElementById('txtQtdCartuchoF').value = '';
									document.getElementById('txtPesoF').value = '';
									document.getElementById('txtQtdCartuchoL').value = '';
									document.getElementById('txtPesoL').value = '';
                                    Var_Continue = false;
                                    return;
                                }
                                Var_Continue = false;
                                    
        //                              ************************** QTD CARTUCHOS NA FRENTE ****************************
                                Campo_Divisor = Math.round(Frente_Caixa / Med_Espessura_Cartucho);
                               
        //                      ** QTD CARTUCHOS NA FRENTE
                                Qtd_Frente_Caixa = Campo_Divisor;
                                
                                Qtd_Cartuchos_Caixa_Lateral = Math.round(Qtd_Frente_Caixa * Qtd_Lateral_Caixa * Qtd_Altura_Caixa);
                                Peso_Caixa_Lateral = Math.round((Largura / 1000) * (Altura / 1000) * (Gramatura / 1000) * Qtd_Cartuchos_Caixa_Lateral * 100) / 100;
                            } else {
							    Mensagem_Erro = 'A altura da Caixa ' +  document.getElementById('cx_ncx').value + 
								 			   ' que possui uma altura de ' + Altura_Caixa + ' mm é inferior à medida da Altura do Cartucho de '
												 + Altura_Cartucho + ' mm + o mín. de ' + document.getElementById('txtMinimoEspaco').value + ' mm.'
								sel_imageMontagem('');


								document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
								document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
								document.getElementById('txtQtdCartuchoF').value = '';
								document.getElementById('txtPesoF').value = '';
								document.getElementById('txtQtdCartuchoL').value = '';
								document.getElementById('txtPesoL').value = '';
								document.getElementById('txtPercentF').value = '';
								document.getElementById('txtPercentL').value = '';
                             
                                //document.getElementById('txtMensagemErro').innerHTML = Mensagem_Erro;
								$('#txtmsg').text(Mensagem_Erro);
								dialogFMsg.dialog('open');
                                Var_Continue = false;
                                return;
                            }
                            Calcular_Perdas_Caixas();
        //                  *****************************************************************************************************
        //                  *****************************************************************************************************
                        } else {
                             
							Mensagem_Erro = 'A altura da Caixa ' +  document.getElementById('cx_ncx').value + 
							 			   ' que possui uma altura de ' + Altura_Caixa + ' mm é inferior à medida da Altura do Cartucho de '
											 + Altura_Cartucho + ' mm + o mín. de ' + document.getElementById('txtMinimoEspaco').value + ' mm.'
							sel_imageMontagem('');


							document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
							document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
							document.getElementById('txtQtdCartuchoF').value = '';
							document.getElementById('txtPesoF').value = '';
							document.getElementById('txtQtdCartuchoL').value = '';
							document.getElementById('txtPesoL').value = '';
							document.getElementById('txtPercentF').value = '';
							document.getElementById('txtPercentL').value = '';
                             
                            //document.getElementById('txtMensagemErro').innerHTML = Mensagem_Erro;
							$('#txtmsg').text(Mensagem_Erro);
							dialogFMsg.dialog('open');
                            Var_Continue = false;
                            return;
                        }
                    } else {
						document.getElementById('cx_pallet').value = '';
						document.getElementById('cx_canton').value = '';
						document.getElementById('txtQtdCartuchoF').value = '';
						document.getElementById('txtPesoF').value = '';
						document.getElementById('txtQtdCartuchoL').value = '';
						document.getElementById('txtPesoL').value = '';

                        Var_Continue = false;
                        return;
                    }
                    Var_Continue = false;
                }
                Var_Continue = true;
            }

        if (Qtd_Cartuchos_Caixa_Frente > Qtd_Cartuchos_Caixa_Lateral) {
            Var_Frente_ou_Lateral = 'FRENTE';
  	        document.getElementById('fieldsetFrente').setAttribute('style','background-color:#7FFFD4');
	        document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
  	        document.getElementById('fs03').setAttribute('style','background-color:#7FFFD4');
			document.getElementById('montaFrente1').checked = true;
			document.getElementById('montaLateral1').checked = false;
	        document.getElementById('fs04').setAttribute('style','background-color:white');
            Opt_1_Click(); 
			
            //FRM_CAIXA_EMBARQUE.Opt_1.Value = True
            //FRM_CAIXA_EMBARQUE.Opt_2.Value = False
        } else {
            Var_Frente_ou_Lateral = 'LATERAL';
	        document.getElementById('fieldsetLateral').setAttribute('style','background-color:#7FFFD4');
	        document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
	        document.getElementById('fs04').setAttribute('style','background-color:#7FFFD4');
			document.getElementById('montaFrente1').checked = false;
			document.getElementById('montaLateral1').checked = true;
	        document.getElementById('fs03').setAttribute('style','background-color:white');
            Opt_2_Click();
            //FRM_CAIXA_EMBARQUE.Opt_1.Value = False
            //FRM_CAIXA_EMBARQUE.Opt_2.Value = True
        }
        Definindo_pela_Frente_ou_Lateral();

        if (Qtd_Cartuchos_Caixa_Frente != 0)
           document.getElementById('txtQtdCartuchoF').value = Qtd_Cartuchos_Caixa_Frente;
        if (Peso_Caixa_Frente != 0) 
           document.getElementById('txtPesoF').value = Peso_Caixa_Frente;
        if (Qtd_Cartuchos_Caixa_Lateral != 0)
           document.getElementById('txtQtdCartuchoL').value = Qtd_Cartuchos_Caixa_Lateral;
        if (Peso_Caixa_Lateral != 0)
           document.getElementById('txtPesoL').value = Peso_Caixa_Lateral
    }
    
	
   function Definindo_pela_Frente_ou_Lateral() {
      if (Var_Frente_ou_Lateral=='FRENTE') {
        if (document.getElementById('fechamentos').value == 'COMUM')
            codigoMontagemCaixaEmbarque = 'ACFC';
        else if (document.getElementById('fechamentos').value == 'HOTMELT')
            codigoMontagemCaixaEmbarque = 'AHFC';
        else if (document.getElementById('fechamentos').value == 'AUTOMATICO') {
                if (document.getElementById('cboSentidoCartucho').value == 'RETRATO')
                    codigoMontagemCaixaEmbarque = 'BFAF';
                else if (document.getElementById('cboSentidoCartucho').value == 'PAISAGEM')
                    codigoMontagemCaixaEmbarque = 'AFAF';
		}	
        else if (document.getElementById('fechamentos').value == 'Outros')
            codigoMontagemCaixaEmbarque = 'AOFC';
	  }
	  else if (Var_Frente_ou_Lateral == 'LATERAL') {
        if (document.getElementById('fechamentos').value == 'COMUM')
            codigoMontagemCaixaEmbarque = 'ACLC';
        else if (document.getElementById('fechamentos').value == 'HOTMELT')
            codigoMontagemCaixaEmbarque = 'AHLC';
        else if (document.getElementById('fechamentos').value == 'AUTOMATICO')  {
                if (document.getElementById('cboSentidoCartucho').value == 'RETRATO')
                   codigoMontagemCaixaEmbarque = 'BFAL';
                else if (document.getElementById('cboSentidoCartucho').value == 'PAISAGEM')
                   codigoMontagemCaixaEmbarque = 'AFAL';
		}	
        else if (document.getElementById('fechamentos').value == 'OUTROS')
                codigoMontagemCaixaEmbarque  = 'AOLC';
	  }
	  sel_imageMontagem(codigoMontagemCaixaEmbarque);
   } 
   function Calcular_Perdas_Caixas() {
      if (document.getElementById('cboSentidoCartucho').value == 'PAISAGEM') {
	     if (Var_Frente_Lateral == 'FRENTE') {
	         let AM13 = Number(document.getElementById('medida_altura').value) * Qtd_Frente_Caixa;
             let AO13 = Number(document.getElementById('media_espessura').value) * Qtd_Lateral_Caixa;			 
		     let AQ13 = Number(document.getElementById('medida_base').value) * Qtd_Altura_Caixa;
             let AS13 = (AM13/10)*(AO13/10)*(AQ13/10);
			 let AR13 = varCubagem;
             let AT13 = (AS13/AR13)*100;			 
			 document.getElementById('txtPercentF').value = AT13;
		 }
	     else if (Var_Frente_Lateral == 'LATERAL') {
	         let AM14 = Number(document.getElementById('media_espessura').value) * Qtd_Frente_Caixa;
             let AO14 = Number(document.getElementById('medida_altura').value) * Qtd_Lateral_Caixa;			 
		     let AQ14 = Number(document.getElementById('medida_base').value) * Qtd_Altura_Caixa;
             let AS14 = (AM14/10)*(AO14/10)*(AQ14/10);
			 let AR14 = varCubagem;
             let AT14 = (AS14/AR14)*100;			 
			 document.getElementById('txtPercentL').value = AT14;
		 }
	  }  
      else if (document.getElementById('cboSentidoCartucho').value == 'RETRATO') {
	     if (Var_Frente_Lateral == 'FRENTE') {
	         let AM13 = Number(document.getElementById('medida_altura').value) * Qtd_Frente_Caixa;
             let AO13 = Number(document.getElementById('media_espessura').value) * Qtd_Lateral_Caixa;			 
		     let AQ13 = Number(document.getElementById('medida_base').value) * Qtd_Altura_Caixa;
             let AS13 = (AM13/10)*(AO13/10)*(AQ13/10);
			 let AR13 = varCubagem;
             let AT13 = (AS13/AR13)*100;			 
			 document.getElementById('txtPercentF').value = AT13;
		 }
	     else if (Var_Frente_Lateral == 'LATERAL') {
	         let AM14 = Number(document.getElementById('media_espessura').value) * Qtd_Frente_Caixa;
             let AO14 = Number(document.getElementById('medida_altura').value) * Qtd_Lateral_Caixa;			 
		     let AQ14 = Number(document.getElementById('medida_base').value) * Qtd_Altura_Caixa;
             let AS14 = (AM14/10)*(AO14/10)*(AQ14/10);
			 let AR14 = varCubagem;
             let AT14 = (AS14/AR14)*100;			 
			 document.getElementById('txtPercentL').value = AT14;
		 }
	  }
   }
	
	
	
    var Fim = new Date();
	
    const diff = Fim.getTime() - Inicio.getTime();

	let msec = diff;
	const hh = Math.floor(msec / 1000 / 60 / 60);
	msec -= hh * 1000 * 60 * 60;
	const mm = Math.floor(msec / 1000 / 60);
	msec -= mm * 1000 * 60;
	const ss = Math.floor(msec / 1000);
	msec -= ss * 1000;	
    document.getElementById('txtTempoProcess').value=hh+':'+mm+':'+ss;
    return;	
}


function Opt_1_Click() {
    Codigo_Montagem_Caixa_Embarque = '';
    if (document.getElementById('fechamentos').value == 'COMUM')
        Codigo_Montagem_Caixa_Embarque = 'ACFC';
    else if (document.getElementById('fechamentos').value == 'HOTMELT')
            Codigo_Montagem_Caixa_Embarque = 'AHFC';
    else if (document.getElementById('fechamentos').value == 'AUTOMATICO') {
            if (document.getElementById('cboSentidoCartucho').value == 'RETRATO') 
                Codigo_Montagem_Caixa_Embarque = 'BFAF';
            else if (document.getElementById('cboSentidoCartucho').value == 'PAISAGEM')
                Codigo_Montagem_Caixa_Embarque = 'AFAF';
    } else if (document.getElementById('fechamentos').value == 'OUTROS')
            Codigo_Montagem_Caixa_Embarque = 'AOFC';
    
    if (Codigo_Montagem_Caixa_Embarque != '') {
        //Gerando_Imagens_Caixas_Embarque();
  	    sel_imageMontagem(Codigo_Montagem_Caixa_Embarque);
        document.getElementById('txtCodigoMontagem').value = Codigo_Montagem_Caixa_Embarque;
        Mensagem_Codigo_Montagem(Codigo_Montagem_Caixa_Embarque);
    }
}

function Opt_2_Click() {
    Codigo_Montagem_Caixa_Embarque = '';
    if (document.getElementById('fechamentos').value == 'COMUM')
        Codigo_Montagem_Caixa_Embarque = 'ACLC';
    else if (document.getElementById('fechamentos').value == 'HOTMELT')
            Codigo_Montagem_Caixa_Embarque = 'AHLC';
    else if (document.getElementById('fechamentos').value == 'AUTOMATICO') {
            if (document.getElementById('cboSentidoCartucho').value == 'RETRATO')
                Codigo_Montagem_Caixa_Embarque = 'BFAL';
            else if (document.getElementById('cboSentidoCartucho').value == 'PAISAGEM')
                Codigo_Montagem_Caixa_Embarque = 'AFAL';
    } else if (document.getElementById('fechamentos').value == 'OUTROS')
            Codigo_Montagem_Caixa_Embarque = 'AOLC';
    
    if (Codigo_Montagem_Caixa_Embarque != '') {
        //Gerando_Imagens_Caixas_Embarque();
  	    sel_imageMontagem(Codigo_Montagem_Caixa_Embarque);
        document.getElementById('txtCodigoMontagem').value = Codigo_Montagem_Caixa_Embarque;
        Mensagem_Codigo_Montagem(Codigo_Montagem_Caixa_Embarque);
    }
}

function Mensagem_Codigo_Montagem(pcodigoMontagemCaixaEmbarque) {

    for (var i=0; i<tbmontagem.length;i++) {
	   if (pcodigoMontagemCaixaEmbarque == tbmontagem[i][1]) {
	      document.getElementById('txtCodDescricaoColagem').innerHTML = tbmontagem[i][2];
	      document.getElementById('txtCodSentidoCartucho').innerHTML = tbmontagem[i][3];
		  //console.log(tbmontagem[i][1]);
		  break;
	   }
	}
}

$(function () {
  $('.decimal').inputmask('currency', {'autoUnmask': true,
		    radixPoint:',',
            groupSeparator: '.',
		    allowMinus: true,
		    rightAlign: true,
		    inputtype:'text',
			prefix:'',
		    digits: 2,
			unmaskAsNumber: true,
  });

  $('.decimalf').inputmask('currency', {'autoUnmask': true,
		    radixPoint:',',
            groupSeparator: '.',
		    allowMinus: true,
		    rightAlign: true,
		    inputtype:'text',
			prefix:'',
		    digits: 4,
			unmaskAsNumber: true,
  });

  $('.decimal0').inputmask('currency', {'autoUnmask': true,
		    radixPoint:',',
            groupSeparator: '.',
		    allowMinus: true,
		    rightAlign: true,
		    inputtype:'text',
			prefix:'',
		    digits: 0,
			unmaskAsNumber: true,
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
});
  
var dialogFCard,
    dialogFCardDetail,
	dialogFDel,
	dialogFMsg,
	dialogFCardGram,
	dialogFCardGramDetail,
	dialogFCaixa,
	dialogFCaixaDetail,
	dialogFMontagem,
	dialogFMontagemDetail,
	dialogFPDF,
	dialogFCaixaEmb,
	dialogFTutorial;
	
var vTypeDel;
  
$(document).ready(function() {

   function addCard() {
     vOper = 'Insert';
     $('#txtRowCard').val('0');
     $('#txtPkCard').val('0');
     $('#txtTpCard').val('');
     $('#txtTpCard').removeAttr('disabled');
	 
	 $('#txtDescrCard').val('');
	 $('#txtDescrCard').removeAttr('disabled');
     dialogFCardDetail.dialog('open');
   }
   function updCard() {
     vOper = 'Update';
     //$('#txtRowCard').val('0');
     //$('#txtPkCard').val('0');
     //$('#txtTpCard').val('');
     $('#txtTpCard').attr('disabled','disabled');
	 
	 //$('#txtDescrCard').val('');
	 $('#txtDescrCard').removeAttr('disabled');
     dialogFCardDetail.dialog('open');
   
   }
   function delCard() {
     vOper = 'Del';
	 $('#delItem').text($('#txtTpCard').val());
	 vTypeDel = 'Card';
	 dialogFDel.dialog('open');
   }
   function saveCard() {
	 let vrowCard = Number($('#txtRowCard').val());
	 let vpk = Number($('#txtPkCard').val());
	 let vtp = $('#txtTpCard').val();
	 let vdescr = $('#txtDescrCard').val();
	 let qtrans='{';
	 qtrans = qtrans+'"pk":'+vpk+',';
	 if (vOper == 'Insert')
	    qtrans = qtrans+'"transaction":"ins",';
	 else if (vOper == 'Update')
	    qtrans = qtrans+'"transaction":"upd",';
     else 
	    qtrans = qtrans+'"transaction":"del",';
	 
	 qtrans = qtrans+'"table":"Card",';
	 qtrans = qtrans+'"tp":"'+vtp+'",';
	 qtrans = qtrans+'"descr":"'+vdescr+'"';
	 qtrans = qtrans+'}';
	 //qtrans = JSON.stringify(qtrans);
	 //console.log(qtrans);
	 $.post('setData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
			   tbcartao[vrowCard][1] = $('#txtTpCard').val();
			   tbcartao[vrowCard][2] = $('#txtDescrCard').val();
			   tableCard.cell(vrowCard, 0).data($('#txtTpCard').val());
			   tableCard.cell(vrowCard, 1).data($('#txtDescrCard').val());
	           dialogFCardDetail.dialog('close');
	           tableCard.cell(':eq('+(vrowCard*2)+')').focus();	
			} else if (vOper == 'Insert') { 
			   let j = tbcartao.length;
			   tbcartao.push([]);
			   tbcartao[j].push(new Array(3));
			   tbcartao[j][0] = obj.error;
			   tbcartao[j][1] = $('#txtTpCard').val();
			   tbcartao[j][2] = $('#txtDescrCard').val();
		       tableCard.row.add([tbcartao[j][1],tbcartao[j][2]]).draw();
	           dialogFCardDetail.dialog('close');
			   let vrowCount = tableCard.rows().count()-1;
	           tableCard.cell(':eq('+(vrowCount*2)+')').focus();	
               //tableMontagem1.scroller.toPosition(vrowCount);			   
               tableCard.row(vrowCount).scrollTo();			   
			}   
			else {
			   let spliced = tbcartao.splice(vrowCard,1);
			   //console.log(spliced);
			   tableCard.row(vrowCard).remove().draw();
	           tableCard.cell(':eq('+((vrowCard-1)*2)+')').focus();	
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   
   }
   
   dialogFCard = $('#frmCard').dialog({
     autoOpen: false,
     height: 400,
     width: 'auto',
     modal: true,
     buttons: {
	   'Incluir': addCard,
	   'Alterar': updCard,
	   'Deletar': delCard,
       Cancel: function() {
	      dialogFCard.dialog('close');
	   }  
	 },
	 close: function() {
		//alert('close'); 
		loadCard(); 
	 }
   });

   dialogFCardDetail = $('#frmCardDetail').dialog({
     autoOpen: false,
	 height: 400, 
	 width: 'auto',
     modal: true,
	 buttons: {
	   'Gravar': saveCard,
       Cancel: function() {
	      dialogFCardDetail.dialog('close');
	   }	   
	 },
   })
   
   dialogFDel = $('#dialog-delete').dialog({
      autoOpen: false,
	  resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Delete": function() {
          $( this ).dialog( "close" );
		  if (vTypeDel == 'Card')
   	          saveCard();
		  if (vTypeDel == 'Cardg')
   	          saveCardGram();
		  if (vTypeDel == 'Cx')
   	          saveCaixa();
		  if (vTypeDel == 'Montag')
   	          saveMontagem();
		  if (vTypeDel == 'CaixaEmb')
   	          saveCaixaEmb();
        },
        Cancel: function() {
		  if (vTypeDel == 'Card')
	          tableCard.cell(':eq('+(rowCard*2)+')').focus();	
		  if (vTypeDel == 'Cardg')
	          tableCardg.cell(':eq('+(rowCard*4)+')').focus();	
		  if (vTypeDel == 'Cx')
	          tableCaixa1.cell(':eq('+(rowCard*8)+')').focus();	
		  if (vTypeDel == 'Montag')
	          tableMontagem1.cell(':eq('+(rowCard*3)+')').focus();	
          $( this ).dialog( "close" );
        }
      }
   });
   dialogFMsg = $( "#dialog-message" ).dialog({
      autoOpen: false,
	  modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
   });   

   dialogFTutorial = $( "#tutorial" ).dialog({
      autoOpen: false,
	  modal: true,
	  height: 500, 
	  width: 600,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
   });   

   function addCardGram() {
     if (empty($('#selCard1').val())) {
	    $('#txtmsg').text('Selecione o cartão');
		dialogFMsg.dialog('open');
		return;
	 }
	 
     vOper = 'Insert';
     $('#txtRowCardGram').val('-1');
     $('#txtPkCardGram').val('0');
     $('#txtCardGram').val($('#selCard1').val());
	 
	 $('#txtGram').val('');
	 $('#txtGram').removeAttr('disabled');
	 $('#txtEspessuraGram').val('');
	 $('#txtEspessuraGram').removeAttr('disabled');
     dialogFCardGramDetail.dialog('open');
   }
   function updCardGram() {
     if (empty($('#selCard1').val())) {
	    $('#txtmsg').text('Selecione o cartão');
		dialogFMsg.dialog('open');
		return;
	 }
	 if ($('#txtRowCardGram').val() == '-1') {
	     tableCardg.cell(':eq(0)').focus();	
	 }
	 
	 
     vOper = 'Update';
     //$('#txtRowCard').val('0');
     //$('#txtPkCard').val('0');
     //$('#txtTpCard').val('');
     //$('#txtGram').attr('disabled','disabled');
	 $('#txtGram').removeAttr('disabled');
	 $('#txtEspessuraGram').removeAttr('disabled');
	 
	 //$('#txtDescrCard').val('');
	 //$('#txtDescrCard').removeAttr('disabled');
     dialogFCardGramDetail.dialog('open');
   
   }
   function delCardGram() {
     if (empty($('#selCard1').val())) {
	    $('#txtmsg').text('Selecione o cartão');
		dialogFMsg.dialog('open');
		return;
	 }
	 if ($('#txtRowCardGram').val() == '-1') {
	     tableCardg.cell(':eq(0)').focus();	
	 }
     vOper = 'Del';
	 $('#delItem').text($('#txtGram').val());
	 vTypeDel = 'Cardg';
	 dialogFDel.dialog('open');
   }
   function saveCardGram() {
	 let vrowCard = Number($('#txtRowCardGram').val());
	 let vindCard = Number($('#txtIndCardGram').val());
	 let vpk = Number($('#txtPkCardGram').val());
	 let vCardGram = $('#txtCardGram').val();
	 let vgram = Number($('#txtGram').val());
	 let vespessura = Number($('#txtEspessuraGram').val());
	 let qtrans='{';
	 qtrans = qtrans+'"pk":'+vpk+',';
	 if (vOper == 'Insert')
	    qtrans = qtrans+'"transaction":"ins",';
	 else if (vOper == 'Update')
	    qtrans = qtrans+'"transaction":"upd",';
     else 
	    qtrans = qtrans+'"transaction":"del",';
	 
	 qtrans = qtrans+'"table":"Cardg",';
	 qtrans = qtrans+'"tpcard":"'+vCardGram+'",';
	 qtrans = qtrans+'"gramatura":"'+vgram+'",';
	 qtrans = qtrans+'"espessura":"'+vespessura+'"';
	 qtrans = qtrans+'}';
	 //qtrans = JSON.stringify(qtrans);
	 //console.log(qtrans);
	 $.post('setData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
			   tbcartaogram[vindCard][2] = $('#txtGram').val();
			   tbcartaogram[vindCard][3] = $('#txtEspessuraGram').val();
			   tableCardg.cell(vrowCard, 1).data($('#txtGram').val());
			   tableCardg.cell(vrowCard, 2).data($('#txtEspessuraGram').val());
	           dialogFCardGramDetail.dialog('close');
	           tableCardg.cell(':eq('+(vrowCard*4)+')').focus();	
			} else if (vOper == 'Insert') { 
			   let j = tbcartaogram.length;
			   tbcartaogram.push([]);
			   tbcartaogram[j].push(new Array(3));
			   tbcartaogram[j][0] = obj.error;
			   tbcartaogram[j][1] = $('#txtCardGram').val();
			   tbcartaogram[j][2] = $('#txtGram').val();
			   tbcartaogram[j][3] = $('#txtEspessuraGram').val();
		       tableCardg.row.add([tbcartaogram[j][1],tbcartaogram[j][2],tbcartaogram[j][3],j]).draw();
	           dialogFCardGramDetail.dialog('close');
			   let vrowCount = tableCardg.rows().count()-1;
	           tableCardg.cell(':eq('+(vrowCount*4)+')').focus();	
               //tableMontagem1.scroller.toPosition(vrowCount);			   
               tableCardg.row(vrowCount).scrollTo();			   
			}   
			else {
			   let spliced = tbcartaogram.splice(vrowCard,1);
			   //console.log(spliced);
			   tableCardg.row(vrowCard).remove().draw();
	           tableCardg.cell(':eq('+((vrowCard-1)*4)+')').focus();	
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   
   }

   
   dialogFCardGram = $('#frmCardGram').dialog({
     autoOpen: false,
     height: 500,
     width: 'auto',
     modal: true,
     buttons: {
	   'Incluir': addCardGram,
	   'Alterar': updCardGram,
	   'Deletar': delCardGram,
       Cancel: function() {
	      dialogFCardGram.dialog('close');
	   }  
	 },
   });
   dialogFCardGramDetail = $('#frmCardGramDetail').dialog({
     autoOpen: false,
	 height: 400, 
	 width: 'auto',
     modal: true,
	 buttons: {
	   'Gravar': saveCardGram,
       Cancel: function() {
	      dialogFCardGramDetail.dialog('close');
	      tableCardg.cell(':eq('+(rowCard*3)+')').focus();	
	   }	   
	 },
   })
   

   function addCaixa() {
	 
     vOper = 'Insert';
     $('#txtRowCaixa').val('-1');
     $('#txtPkCaixa').val('0');
	 
	 $('#txtNCX').val('');
	 $('#txtCol').val('');
	 $('#txtgm2').val('');
	 $('#txtComp').val('');
	 $('#txtLarg').val('');
	 $('#txtAlt').val('');
	 $('#txtPallet').val('');
	 $('#txtCanton').val('');
     dialogFCaixaDetail.dialog('open');
   }
   function updCaixa() {
	 if ($('#txtRowCaixa').val() == '-1') {
	     tableCaixa1.cell(':eq(0)').focus();	
	 }
	 
	 
     vOper = 'Update';
	 
     dialogFCaixaDetail.dialog('open');
   
   }
   function delCaixa() {
	 if ($('#txtRowCaixa').val() == '-1') {
	     tableCaixa1.cell(':eq(0)').focus();	
	 }
     vOper = 'Del';
	 $('#delItem').text($('#txtNCX').val());
	 vTypeDel = 'Cx';
	 dialogFDel.dialog('open');
   }
   function saveCaixa() {
	 let vrowCaixa = Number($('#txtRowCaixa').val());
	 let vpk = Number($('#txtPkCaixa').val());
	 let vNCX = $('#txtNCX').val();
	 let vcol = Number($('#txtCol').val());
	 let vgm2 = Number($('#txtgm2').val());
	 let vComp = Number($('#txtComp').val());
	 let vLarg = Number($('#txtLarg').val());
	 let vAlt = Number($('#txtAlt').val());
	 let vPallet = $('#txtPallet').val();
	 let vCanton = $('#txtCanton').val();

	 let qtrans='{';
	 qtrans = qtrans+'"pk":'+vpk+',';
	 if (vOper == 'Insert')
	    qtrans = qtrans+'"transaction":"ins",';
	 else if (vOper == 'Update')
	    qtrans = qtrans+'"transaction":"upd",';
     else 
	    qtrans = qtrans+'"transaction":"del",';
	 
	 qtrans = qtrans+'"table":"Cx",';
	 qtrans = qtrans+'"ncx":"'+vNCX+'",';
	 qtrans = qtrans+'"col":"'+vcol+'",';
	 qtrans = qtrans+'"gm2":"'+vgm2+'",';
	 qtrans = qtrans+'"comp":"'+vComp+'",';
	 qtrans = qtrans+'"larg":"'+vLarg+'",';
	 qtrans = qtrans+'"alt":"'+vAlt+'",';
	 qtrans = qtrans+'"pallet":"'+vPallet+'",';
	 qtrans = qtrans+'"canton":"'+vCanton+'"';
	 qtrans = qtrans+'}';
	 //qtrans = JSON.stringify(qtrans);
	 //console.log(qtrans);
	 $.post('setData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
			   tbcaixas[vrowCaixa][1] = $('#txtNCX').val();
			   tbcaixas[vrowCaixa][2] = $('#txtCol').val();
			   tbcaixas[vrowCaixa][3] = $('#txtgm2').val();
			   tbcaixas[vrowCaixa][4] = $('#txtComp').val();
			   tbcaixas[vrowCaixa][6] = $('#txtLarg').val();
			   tbcaixas[vrowCaixa][8] = $('#txtAlt').val();
			   tbcaixas[vrowCaixa][9] = $('#txtPallet').val();
			   tbcaixas[vrowCaixa][10] = $('#txtCanton').val();

			   tableCaixa1.cell(vrowCaixa, 0).data($('#txtNCX').val());
			   tableCaixa1.cell(vrowCaixa, 1).data($('#txtCol').val());
			   tableCaixa1.cell(vrowCaixa, 2).data($('#txtgm2').val());
			   tableCaixa1.cell(vrowCaixa, 3).data($('#txtComp').val());
			   tableCaixa1.cell(vrowCaixa, 4).data($('#txtLarg').val());
			   tableCaixa1.cell(vrowCaixa, 5).data($('#txtAlt').val());
			   tableCaixa1.cell(vrowCaixa, 6).data($('#txtPallet').val());
			   tableCaixa1.cell(vrowCaixa, 7).data($('#txtCanton').val());
	           dialogFCaixaDetail.dialog('close');
  	           tableCaixa1.cell(':eq('+(vrowCaixa*8)+')').focus();	
			} else if (vOper == 'Insert') { 
			   let j = tbcaixas.length;
			   tbcaixas.push([]);
			   tbcaixas[j].push(new Array(12));
			   tbcaixas[j][0] = obj.error;
			   tbcaixas[j][1] = $('#txtNCX').val();
			   tbcaixas[j][2] = $('#txtCol').val();
			   tbcaixas[j][3] = $('#txtgm2').val();
			   tbcaixas[j][4] = $('#txtComp').val();
			   tbcaixas[j][5] = 'x';
			   tbcaixas[j][6] = $('#txtLarg').val();
			   tbcaixas[j][7] = 'x';
			   tbcaixas[j][8] = $('#txtAlt').val();
			   tbcaixas[j][9] = $('#txtPallet').val();
			   tbcaixas[j][10] = $('#txtCanton').val();
			   tbcaixas[j][11] = 0.0;
  	           tableCaixa1.row.add([tbcaixas[j][1],tbcaixas[j][2],tbcaixas[j][3],
	                        tbcaixas[j][4],tbcaixas[j][6],
							tbcaixas[j][8],
							tbcaixas[j][9],tbcaixas[j][10]]).draw();
	           dialogFCaixaDetail.dialog('close');
			   let vrowCount = tableCaixa1.rows().count()-1;
	           tableCaixa1.cell(':eq('+(vrowCount*8)+')').focus();	
               //tableMontagem1.scroller.toPosition(vrowCount);			   
               tableCaixa1.row(vrowCount).scrollTo();			   
			}   
			else {
			   let spliced = tbcaixas.splice(vrowCaixa,1);
			   //console.log(spliced);
			   tableCaixa1.row(vrowCaixa).remove().draw();
	           tableCaixa1.cell(':eq('+((vrowCaixa-1)*8)+')').focus();	
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   
   }

   
   dialogFCaixa = $('#frmCaixa').dialog({
     autoOpen: false,
     height: 500,
     width: 'auto',
     modal: true,
     buttons: {
	   'Incluir': addCaixa,
	   'Alterar': updCaixa,
	   'Deletar': delCaixa,
       Cancel: function() {
	      dialogFCaixa.dialog('close');
	   }  
	 },
	 close: function() {
		//alert('close'); 
		loadCaixaUpd(); 
	 }
   });
   dialogFCaixaDetail = $('#frmCaixaDetail').dialog({
     autoOpen: false,
	 height: 500, 
	 width: 'auto',
     modal: true,
	 buttons: {
	   'Gravar': saveCaixa,
       Cancel: function() {
	      dialogFCaixaDetail.dialog('close');
	      tableCaixa1.cell(':eq('+(rowCard*8)+')').focus();	
	   }	   
	 },
   })
   

   function addMontagem() {
	 
     vOper = 'Insert';
     $('#txtRowMontagem').val('-1');
     $('#txtPkMontagem').val('0');
	 
	 $('#txtCodMontagem1').val('');
	 $('#txtDescrMontagem').val('');
	 $('#txtSentMontagem').val('');
     dialogFMontagemDetail.dialog('open');
   }
   function updMontagem() {
	 if ($('#txtRowMontagem').val() == '-1') {
	     tableMontagem1.cell(':eq(0)').focus();	
	 }
	 
	 
     vOper = 'Update';
	 
     dialogFMontagemDetail.dialog('open');
   
   }
   function delMontagem() {
	 if ($('#txtRowMontagem').val() == '-1') {
	     tableMontagem1.cell(':eq(0)').focus();	
	 }
     vOper = 'Del';
	 $('#delItem').text($('#txtCodMontagem1').val());
	 vTypeDel = 'Montag';
	 dialogFDel.dialog('open');
   }
   function saveMontagem() {
	 let vrowMontagem = Number($('#txtRowMontagem').val());
	 let vpk = Number($('#txtPkMontagem').val());
	 let vCodigoMontagem = $('#txtCodMontagem1').val();
	 let vDescrMontagem = $('#txtDescrMontagem').val();
	 let vSentMontagem = $('#txtSentMontagem').val();

	 let qtrans='{';
	 qtrans = qtrans+'"pk":'+vpk+',';
	 if (vOper == 'Insert')
	    qtrans = qtrans+'"transaction":"ins",';
	 else if (vOper == 'Update')
	    qtrans = qtrans+'"transaction":"upd",';
     else 
	    qtrans = qtrans+'"transaction":"del",';
	 
	 qtrans = qtrans+'"table":"Montag",';
	 qtrans = qtrans+'"Codigo":"'+vCodigoMontagem+'",';
	 qtrans = qtrans+'"Descricao":"'+vDescrMontagem+'",';
	 qtrans = qtrans+'"Sentido":"'+vSentMontagem+'"';
	 qtrans = qtrans+'}';
	 //qtrans = JSON.stringify(qtrans);
	 //console.log(qtrans);
	 $.post('setData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
			   tbmontagem[vrowMontagem][1] = $('#txtCodMontagem1').val();
			   tbmontagem[vrowMontagem][2] = $('#txtDescrMontagem').val();
			   tbmontagem[vrowMontagem][3] = $('#txtSentMontagem').val();

			   tableMontagem1.cell(vrowMontagem, 0).data($('#txtCodMontagem1').val());
			   tableMontagem1.cell(vrowMontagem, 1).data($('#txtDescrMontagem').val());
			   tableMontagem1.cell(vrowMontagem, 2).data($('#txtSentMontagem').val());
	           dialogFMontagemDetail.dialog('close');
	           tableMontagem1.cell(':eq('+(vrowMontagem*3)+')').focus();	
			} else if (vOper == 'Insert') { 
			   let j = tbmontagem.length;
			   tbmontagem.push([]);
			   tbmontagem[j].push(new Array(4));
			   tbmontagem[j][0] = obj.error;
			   tbmontagem[j][1] = $('#txtCodMontagem1').val();
			   tbmontagem[j][2] = $('#txtDescrMontagem').val();
			   tbmontagem[j][3] = $('#txtSentMontagem').val();
			   //console.log(tbmontagem);
  	           tableMontagem1.row.add([tbmontagem[j][1],tbmontagem[j][2],tbmontagem[j][3]]).draw();
	           dialogFMontagemDetail.dialog('close');
			   let vrowCount = tableMontagem1.rows().count()-1;
	           tableMontagem1.cell(':eq('+(vrowCount*3)+')').focus();	
               //tableMontagem1.scroller.toPosition(vrowCount);			   
               tableMontagem1.row(vrowCount).scrollTo();			   
			}   
			else {
			   let spliced = tbmontagem.splice(vrowMontagem,1);
			   //console.log(spliced);
			   tableMontagem1.row(vrowMontagem).remove().draw();
	           tableMontagem1.cell(':eq('+((vrowMontagem-1)*3)+')').focus();	
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   
   }

   
   dialogFMontagem = $('#frmMontagem').dialog({
     autoOpen: false,
     height: 500,
     width: 'auto',
     modal: true,
     buttons: {
	   'Incluir': addMontagem,
	   'Alterar': updMontagem,
	   'Deletar': delMontagem,
       Cancel: function() {
	      dialogFMontagem.dialog('close');
	   }  
	 },
   });
   dialogFMontagemDetail = $('#frmMontagemDetail').dialog({
     autoOpen: false,
	 height: 500, 
	 width: 'auto',
     modal: true,
	 buttons: {
	   'Gravar': saveMontagem,
       Cancel: function() {
	      dialogFMontagemDetail.dialog('close');
	      tableMontagem1.cell(':eq('+(rowCard*3)+')').focus();	
	   }	   
	 },
   })
 
    
   function makePDF() { 
 	    let vdata = document.getElementById('txtDataRec_PDF').value+' 00:00:00';
 	    let vnumero = document.getElementById('txtPkRec_PDF').value;
		//console.log(vdata);
         
 	    vdata = new Date(vdata);
		//console.log(vdata);
		vdata = vdata.toLocaleString('pt-BR');
	    vdata = vdata.substring(0,10);
		
		
		var pdf = new jsPDF('p', 'mm', 'a4');
		pdf.text('CAIXA EMBARQUE',100,10,'center');
		pdf.setFontSize(9);
		pdf.text('DATA: '+vdata,150,10);
		pdf.text('Num.: '+vnumero,15,10);
        
		let headers = ['Frente','Lateral','Altura'];
		let vFrente = document.getElementById('txtFrente_PDF').value;
		let vLateral = document.getElementById('txtLateral_PDF').value;
		let vAltura = document.getElementById('txtAltura_PDF').value;

		let data = [[vFrente.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
		             vLateral.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
		             vAltura.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2})],
		             ];
		let y = 15;

		// Set the column widths
		let columnWidths = [17, 17, 17];

		// Set the table styles
		const headerStyle = { fillColor: "#000000", textColor: "#ffffff" };
		const rowStyle = { fillColor: "#f2f2f2" };

		// Draw the table headers
		headers.forEach((header, index) => {
		  //pdf.setFillColor(headerStyle.fillColor);
		  //pdf.setTextColor(headerStyle.textColor);
		  pdf.setFontStyle("bold");
		  pdf.rect(y, 20, columnWidths[index], 20, "S");
		  pdf.text(header, y + 2, 25);
		  y += columnWidths[index];
		});
		y = 15;

		// Draw the table rows
		data.forEach((row) => {
		  row.forEach((cell, index) => {
			//pdf.setFillColor(rowStyle.fillColor);
			//pdf.setTextColor(0, 0, 0);
			pdf.setFontStyle("normal");
			pdf.rect(y, 30, columnWidths[index], 10, "S");
			pdf.text(cell, y + 2, 35);
			y += columnWidths[index];
		  });
		  y = 15;
		});

		headers = ['Fechamento Cartucho','Base Cartucho','Altura Cartucho','Acrescimo Espess. em %'];
		columnWidths = [36, 28, 28,40];
		let vMedidaBase = document.getElementById('txtMedidaBase_PDF').value;
		let vMedidaAltura = document.getElementById('txtMedidaAltura_PDF').value;
		let vAcrescimoEspessura = document.getElementById('txtAcrescimoEspessura_PDF').value;

		data = [[$('#txtTipoFechamento_PDF').val(),
		         vMedidaBase.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
				 vMedidaAltura.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
				 vAcrescimoEspessura.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2})
				],
			   ];

	    y = 70;		   
		headers.forEach((header, index) => {
		  //pdf.setFillColor(headerStyle.fillColor);
		  //pdf.setTextColor(headerStyle.textColor);
		  pdf.setFontStyle("bold");
		  pdf.rect(y, 20, columnWidths[index], 20, "S");
		  pdf.text(header, y + 2, 25);
		  y += columnWidths[index];
		});
		y = 70;

		// Draw the table rows
		data.forEach((row) => {
		  row.forEach((cell, index) => {
			//pdf.setFillColor(rowStyle.fillColor);
			//pdf.setTextColor(0, 0, 0);
			pdf.setFontStyle("normal");
			pdf.rect(y, 30, columnWidths[index], 10, "S");
			pdf.text(cell, y + 2, 35);
			y += columnWidths[index];
		  });
		  y = 70;
		});
			   
		
		headers = ['N.CX','Col','g/m2','C x L x A','Pallet','Canton.'];
		columnWidths = [15, 15, 15, 25, 15, 15];
		let vCol = document.getElementById('txtColCX_PDF').value;
		let vGM2 = document.getElementById('txtgm2CX_PDF').value;

		data = [[$('#txtNumCX_PDF').val(),
		         vCol.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
				 vGM2.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
				 $('#txtCLACX_PDF').val(),
				 $('#txtPallet_PDF').val(),
				 $('#txtCantoneira_PDF').val()
				],
			   ];

	    y = 15;		   
		headers.forEach((header, index) => {
		  //pdf.setFillColor(headerStyle.fillColor);
		  //pdf.setTextColor(headerStyle.textColor);
		  pdf.setFontStyle("bold");
		  pdf.rect(y, 50, columnWidths[index], 20, "S");
		  pdf.text(header, y + 2, 55);
		  y += columnWidths[index];
		});
		y = 15;

		// Draw the table rows
		data.forEach((row) => {
		  row.forEach((cell, index) => {
			//pdf.setFillColor(rowStyle.fillColor);
			//pdf.setTextColor(0, 0, 0);
			pdf.setFontStyle("normal");
			pdf.rect(y, 60, columnWidths[index], 10, "S");
			pdf.text(cell, y + 2, 65);
			y += columnWidths[index];
		  });
		  y = 15;
		});


		headers = ['Qtd Calculada','Peso Kg','%','Qtd Real'];
		columnWidths = [30, 30, 30, 30];
		
		let vQtdeCartucho = 0;
		let vPeso = 0;
		let vAproveitamento = 0;
		let vQtdeReal = 0;
		let vOptReal = 0;
		if (document.getElementById('montaFrente1').checked) {
            vQtdeCartucho = document.getElementById('txtQtdCartuchosFrente_PDF').value;			
            vPeso = document.getElementById('txtPesoCaixaFrente_PDF').value;			
            vAproveitamento = document.getElementById('txtAproveitamentoFrente_PDF').value;			
            vQtdeReal = Number(document.getElementById('txtQtdeRealFrente_PDF').value);			
		}
		else {
            vQtdeCartucho = document.getElementById('txtQtdCartuchosLateral_PDF').value;			
            vPeso = document.getElementById('txtPesoCaixaLateral_PDF').value;			
            vAproveitamento = document.getElementById('txtAproveitamentoLateral_PDF').value;			
            vQtdeReal = Number(document.getElementById('txtQtdeRealLateral_PDF').value);			
			vOptReal = 1;
		}
		data = [[vQtdeCartucho.toLocaleString('pt-BR',{minimumFractionDigits: 0,maximumFractionDigits: 0}),
				 vPeso.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
				 vAproveitamento.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}),
				 vQtdeReal.toLocaleString('pt-BR',{minimumFractionDigits: 0,maximumFractionDigits: 0}),
				],
			   ];

	    y = 15;		   
		headers.forEach((header, index) => {
		  //pdf.setFillColor(headerStyle.fillColor);
		  //pdf.setTextColor(headerStyle.textColor);
		  pdf.setFontStyle("bold");
		  pdf.rect(y, 80, columnWidths[index], 20, "S");
		  pdf.text(header, y + 2, 85);
		  y += columnWidths[index];
		});
		y = 15;

		// Draw the table rows
		data.forEach((row) => {
		  row.forEach((cell, index) => {
			//pdf.setFillColor(rowStyle.fillColor);
			//pdf.setTextColor(0, 0, 0);
			pdf.setFontStyle("normal");
			pdf.rect(y, 90, columnWidths[index], 10, "S");
			pdf.text(cell, y + 2, 95);
			y += columnWidths[index];
		  });
		  y = 15;
		});
		
		
		pdf.text(15,110,'CODIGO DA MONTAGEM');
		pdf.setFontStyle('bold');
		pdf.text(15,115,$('#txtCodigoMontagem_PDF').val());
	
        pdf.text(15,190,$('#txtCodDescricaoColagem_PDF').text());
        pdf.text(15,195,$('#txtCodSentidoCartucho_PDF').text());
	
	
		var getImageFromUrl = function(url, callback) {
			var img = new Image();

			img.onError = function() {
				alert('Cannot load image: "'+url+'"');
			};
			img.onload = function() {
				callback(img);
			};
			img.src = url;
		}	
		var drawImg = function(imgData) {

			//doc.addImage(imgData, 'JPEG', 10, 10, 50, 50, 'monkey'); // Cache the image using the alias 'monkey'
			//doc.addImage('monkey', 70, 10, 100, 120); // use the cached 'monkey' image, JPEG is optional regardless
			// As you can guess, using the cached image reduces the generated PDF size by 50%!

			// Rotate Image - new feature as of 2014-09-20
			pdf.addImage({
				imageData : imgData,
				angle     : 0,
				x         : 15,
				y         : 120,
				w         : 100,
				h         : 50
			});
		    //pdf.addPage();
		    //pdf.save('caixaembarque.pdf');
			//pdf.output('dataurlnewwindow');
		    

			if (navigator.userAgent.indexOf('Firefox')!=-1) {
		 	   var spdf = pdf.output('datauristring');
		 	   document.getElementById('pdfView').src = spdf;
			   dialogFPDFView.dialog('open');
			}
            else { 
		      pdf.save('caixaembarque_'+vnumero+'.pdf');
              $('#txtmsg').text('Veja o PDF no Download.');
	          dialogFMsg.dialog('open');
			}
			saveQtdeReal(vQtdeReal,vOptReal);

		}	
	    getImageFromUrl(document.getElementById('getImageMontagem_PDF').src, drawImg);	
   }

   function saveQtdeReal(vQtdeReal,vOptReal) {
	 let vpk = Number($('#txtPkRec_PDF').val());
     if (vpk == 0) {
	    return;
	 }
	 
	 let qtrans='{';
	 qtrans = qtrans+'"pk":'+vpk+',';
     qtrans = qtrans+'"transaction":"upd",';
 	 
	 qtrans = qtrans+'"table":"caixaembupd",';
	 qtrans = qtrans+'"qtdereal":"'+vQtdeReal+'",';
	 qtrans = qtrans+'"opt_qtdereal":"'+vOptReal+'"';
	 qtrans = qtrans+'}';
	 //qtrans = JSON.stringify(qtrans);
	 //console.log(qtrans);
	 $.post('setData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
			
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   
   }
   
/*

const doc = new jsPDF();

// Define the table headers and data
const headers = ["Name", "Age", "Country"];
const data = [
  ["John Doe", "30", "USA"],
  ["Jane Smith", "25", "Canada"],
  ["Bob Johnson", "40", "UK"],
];

// Set the table starting position
let y = 20;

// Set the column widths
const columnWidths = [60, 20, 40];

// Set the table styles
const headerStyle = { fillColor: "#000000", textColor: "#ffffff" };
const rowStyle = { fillColor: "#f2f2f2" };

// Draw the table headers
headers.forEach((header, index) => {
  doc.setFillColor(headerStyle.fillColor);
  doc.setTextColor(headerStyle.textColor);
  doc.setFontStyle("bold");
  doc.rect(y, 10, columnWidths[index], 10, "F");
  doc.text(header, y + 2, 15);
  y += columnWidths[index];
});

y = 20;

// Draw the table rows
data.forEach((row) => {
  row.forEach((cell, index) => {
    doc.setFillColor(rowStyle.fillColor);
    doc.setTextColor(0, 0, 0);
    doc.setFontStyle("normal");
    doc.rect(y, 20, columnWidths[index], 10, "F");
    doc.text(cell, y + 2, 25);
    y += columnWidths[index];
  });
  y = 20;
});

// Save the PDF
doc.save("table.pdf");


*/    
   
   
   dialogFPDF = $('#frmPDF').dialog({
     autoOpen: false,
	 height: 600, 
	 width: 'auto',
     modal: true,
	 buttons: {
	   'Gerar': makePDF,
       Cancel: function() {
	      dialogFPDF.dialog('close');
	   }	   
	 },
   })
   dialogFPDFView = $('#frmPDFView').dialog({
     autoOpen: false,
	 height: 800, 
	 width: 'auto',
     modal: true,
	 buttons: {
       Cancel: function() {
	      dialogFPDFView.dialog('close');
	   }	   
	 },
   })
   
   
   function updCaixaEmb() {
      //get data
	 let vpk = Number($('#txtPkRec').val());
     if (vpk == 0) {
	    return;
	 }
	 $.post('getData.php',
	 {
	   q : 'caixaemb',
	   s : vpk
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);

			let obj1 = JSON.parse(data); 
			let vdata = new Date(obj1.caixaemb[0].data);
            vdata  = formatDate(vdata);
			
			//vdata = vdata.toLocaleString('pt-BR');
			//vdata = vdata.substring(0,10);
			document.getElementById('txtDataRec').value = vdata;
			document.getElementById('txtDataRec_PDF').value = vdata;
			document.getElementById('fechamentos').value = obj1.caixaemb[0].fechamento;
			document.getElementById('fechamentos').disabled = true;
			sel_image();
			document.getElementById('cartoes').value = obj1.caixaemb[0].cartao;
			document.getElementById('cartoes').disabled = true;
			
			sel_gramatura();
			document.getElementById('gramaturas').value = Number(obj1.caixaemb[0].gramatura);
			document.getElementById('gramaturas').disabled = true;
			sel_peso();
			document.getElementById('frente').value = Number(obj1.caixaemb[0].frente);
			document.getElementById('lateral').value = Number(obj1.caixaemb[0].lateral);
			document.getElementById('altura').value = Number(obj1.caixaemb[0].altura);
			document.getElementById('desc_lat').value = Number(obj1.caixaemb[0].desc_lat);
			document.getElementById('med_f_aut').value = Number(obj1.caixaemb[0].med_f_aut);
			document.getElementById('frente_lateral').value = obj1.caixaemb[0].frente_lateral;
			document.getElementById('aba_cola').value = Number(obj1.caixaemb[0].aba_cola);
			document.getElementById('aba_superior').value = Number(obj1.caixaemb[0].aba_superior);
			document.getElementById('aba_inferior').value = Number(obj1.caixaemb[0].aba_inferior);
			document.getElementById('acrescimo_espessura').value = Number(obj1.caixaemb[0].acrescimo_espessura);

			document.getElementById('frente').disabled = true;
			document.getElementById('lateral').disabled = true;
			document.getElementById('altura').disabled = true;
			document.getElementById('desc_lat').disabled = true;
			document.getElementById('med_f_aut').disabled = true;
			document.getElementById('frente_lateral').disabled = true;
			document.getElementById('aba_cola').disabled = true;
			document.getElementById('aba_superior').disabled = true;
			document.getElementById('aba_inferior').disabled = true;
			document.getElementById('acrescimo_espessura').disabled = true;
			
      	    document.getElementById('btnCalc').disabled = true;
			
			document.getElementById('txtMinimoEspaco').value = Number(obj1.caixaemb[0].minimo_espaco);
			document.getElementById('txtMinimoEspaco').disabled = true;
			let vqtdereal = Number(obj1.caixaemb[0].qtdereal);
			let vopt_qtdereal = Number(obj1.caixaemb[0].opt_qtdereal);
			if (vopt_qtdereal == 0) {
				document.getElementById('txtQtdeRealFrente_PDF').value = vqtdereal;
			} else {
				document.getElementById('txtQtdeRealLateral_PDF').value = vqtdereal;
			}

			calcular();
			  
			document.getElementById('cx_ncx').value = obj1.caixaemb[0].cx_ncx;
            tableCaixaEmb
				.column(0)
				.data()
				.each(function (value, index) {
					//console.log('Data in index: ' + index + ' is: ' + value);
					if (value == obj1.caixaemb[0].cx_ncx) {
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
			  
			document.getElementById('cboSentidoCartucho').value = obj1.caixaemb[0].sentidoCartucho;
			document.getElementById('cboSentidoCartucho').disabled = true;
			getSentidoImage();
            document.getElementById("tbcaixaEmb").style.display = "none";
			
			//vdata = vdata.toLocaleString('pt-BR');
			//vdata = vdata.substring(0,10);
            dialogFCaixaEmb.dialog('close');
            document.getElementById('txtPkRec').value = vpk;
			document.getElementById('txtDataRec').value = vdata;
            document.getElementById('txtPkRec_PDF').value = vpk;
			document.getElementById('txtDataRec_PDF').value = vdata;
		    document.getElementById('txtQtdeRealFrente_PDF').disabled = true;
			document.getElementById('txtQtdeRealLateral_PDF').disabled = true;

			if (vopt_qtdereal == 0) {
				document.getElementById('montaFrente1').checked = true;
			    document.getElementById('montaLateral1').checked = false;
			} else {
				document.getElementById('montaFrente1').checked = false;
			    document.getElementById('montaLateral1').checked = true;
			}

			query_mode = true;
  	        document.getElementById('btnPDF').disabled = false;
	        document.getElementById('btnSave').disabled = true;
			  
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   
   
   }
   function delCaixaEmb() {
	 let vpk = Number($('#txtPkRec').val());
     if (vpk == 0) {
	    return;
	 }

     vOper = 'Del';
	 $('#delItem').text($('#txtPkRec').val());
	 vTypeDel = 'CaixaEmb';
	 dialogFDel.dialog('open');
   }
   function saveCaixaEmb() {
	 let vpk = Number($('#txtPkRec').val());
     if (vpk == 0) {
	    return;
	 }
	 document.getElementById('txtPkRec').value = 0;
	 document.getElementById('txtDataRec').value = '';
	 
	 let qtrans='{';
	 qtrans = qtrans+'"pk":'+vpk+',';
	 if (vOper == 'Insert')
	    qtrans = qtrans+'"transaction":"ins",';
	 else if (vOper == 'Update')
	    qtrans = qtrans+'"transaction":"upd",';
     else 
	    qtrans = qtrans+'"transaction":"del",';
	 
	 qtrans = qtrans+'"table":"caixaemb",';
	 qtrans = qtrans+'"data":"",';
	 qtrans = qtrans+'"fechamento":"",';
	 qtrans = qtrans+'"cartao":"",';
	 qtrans = qtrans+'"gramatura":"",';
	 qtrans = qtrans+'"frente":"",';
	 qtrans = qtrans+'"lateral":"",';
	 qtrans = qtrans+'"altura":"",';
	 qtrans = qtrans+'"desc_lat":"",';
	 qtrans = qtrans+'"med_f_aut":"",';
	 qtrans = qtrans+'"frente_lateral":"",';
	 qtrans = qtrans+'"aba_cola":"",';
	 qtrans = qtrans+'"aba_superior":"",';
	 qtrans = qtrans+'"aba_inferior":"",';
	 qtrans = qtrans+'"acrescimo_espessura":"",';
	 qtrans = qtrans+'"cx_ncx":"",';
	 qtrans = qtrans+'"sentidoCartucho":""';
	 qtrans = qtrans+'}';
	 //qtrans = JSON.stringify(qtrans);
	 //console.log(qtrans);
	 $.post('setData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
			
			} else if (vOper == 'Insert') { 
			}   
			else {
			   tableCaixaEmb1.row(rowCaixaEmb).remove().draw();
	           tableCaixaEmb1.cell(':eq('+((rowCaixaEmb-1)*3)+')').focus();	
			
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   
   }

   
   dialogFCaixaEmb = $('#frmCaixaEmb').dialog({
     autoOpen: false,
     height: 500,
     width: 'auto',
     modal: true,
     buttons: {
	   'Consultar': updCaixaEmb,
	   'Deletar': delCaixaEmb,
       Cancel: function() {
	      dialogFCaixaEmb.dialog('close');
	   }  
	 },
   });


   
}); 
  
  function resetField() {
    document.getElementById("tbcaixaEmb").style.display = "none";
    document.getElementById("minSpace").style.display = "none"; 
    document.getElementById("btnAction").style.display = "none";  
    document.getElementById("montagemCartucho").style.display = "none";  
    document.getElementById("sentidoCartucho").style.display = "none";  
    $('#fechamentos').get(0).selectedIndex = -1;
    $('#cartoes').get(0).selectedIndex = -1;
	document.getElementById('getImageCard').src = '';
	$('#descricao_cartao').text('');
    $('#gramaturas').get(0).selectedIndex = -1;
    $('#frente_lateral').get(0).selectedIndex = 0;
    $('#cboSentidoCartucho').get(0).selectedIndex = 0;
	
	document.getElementById('frente').value = '';
	document.getElementById('lateral').value = '';
	document.getElementById('altura').value = '';
	document.getElementById('desc_lat').value = 0.50;
	document.getElementById('med_f_aut').value = 10.00;
	document.getElementById('aba_cola').value = 10.00;
	document.getElementById('aba_superior').value = 10.00;
	document.getElementById('aba_inferior').value = 10.00;
	document.getElementById('acrescimo_espessura').value = 0;
	document.getElementById('espessura_cartao').value = 0;
  
    $('#txtCodigoMontagem').val('');
    $('#txtCodDescricaoColagem').text('');
    $('#txtCodSentidoCartucho').text('');
    $('#txtMensagemErro').text('');
	document.getElementById('getImageMontagem').src = '';
	document.getElementById('getImageSentido').src = '';
	
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
	
    document.getElementById('fieldsetLateral').setAttribute('style','background-color:white');
    document.getElementById('fieldsetFrente').setAttribute('style','background-color:white');
	
	document.getElementById('txtMinimoEspaco').value = 0;
	
	document.getElementById('txtPkRec').value = 0;
	document.getElementById('txtDataRec').value = '';
	
    query_mode = false;
	document.getElementById('btnPDF').disabled = true;
	document.getElementById('btnSave').disabled = false;
	
	document.getElementById('fechamentos').disabled = false;
	document.getElementById('cartoes').disabled = false;
	document.getElementById('gramaturas').disabled = false;
	document.getElementById('frente').disabled = false;
	document.getElementById('lateral').disabled = false;
	document.getElementById('altura').disabled = false;
	document.getElementById('desc_lat').disabled = false;
	document.getElementById('med_f_aut').disabled = false;
	document.getElementById('frente_lateral').disabled = false;
	document.getElementById('aba_cola').disabled = false;
	document.getElementById('aba_superior').disabled = false;
	document.getElementById('aba_inferior').disabled = false;
	document.getElementById('acrescimo_espessura').disabled = false;
	document.getElementById('txtMinimoEspaco').disabled = false;
	document.getElementById('cboSentidoCartucho').disabled = false;
	document.getElementById('txtQtdeRealFrente_PDF').disabled = false;
	document.getElementById('txtQtdeRealLateral_PDF').disabled = false;
	document.getElementById('btnCalc').disabled = false;

	
  }
  function saveRec() {
	 if (empty(document.getElementById('cx_ncx').value)) {
	    $('#txtmsg').text('Falta escolher caixa');
		dialogFMsg.dialog('open');
		return;
	 }
  
     let data  = formatDate(new Date());
	 if (empty(document.getElementById('txtDataRec').value)) { 
 	     document.getElementById('txtDataRec').value = data;
 	     document.getElementById('txtDataRec_PDF').value = data;
	 }	 
	 let vpk = Number($('#txtPkRec').val());
     let vOper = '';
	 if (vpk == 0)
	     vOper = 'Insert';
	 else {
	     if (data == document.getElementById('txtDataRec').value) {
            vOper = 'Update';
		 }
		 else {
           vOper = 'None';
		   $('#txtmsg').text('Modo Consulta');
		   dialogFMsg.dialog('open');
           return;
         }		   
	 }
	 let qtrans='{';
	 qtrans = qtrans+'"pk":'+vpk+',';
	 if (vOper == 'Insert')
	    qtrans = qtrans+'"transaction":"ins",';
	 else if (vOper == 'Update')
	    qtrans = qtrans+'"transaction":"upd",';
	 
	 
	 qtrans = qtrans+'"table":"caixaemb",';
     qtrans = qtrans+'"data":"'+data+'",';
	 qtrans = qtrans+'"fechamento":"'+document.getElementById('fechamentos').value+'",';
	 qtrans = qtrans+'"cartao":"'+document.getElementById('cartoes').value+'",';
	 qtrans = qtrans+'"gramatura":"'+document.getElementById('gramaturas').value+'",';
	 qtrans = qtrans+'"frente":"'+document.getElementById('frente').value+'",';
	 qtrans = qtrans+'"lateral":"'+document.getElementById('lateral').value+'",';
	 qtrans = qtrans+'"altura":"'+document.getElementById('altura').value+'",';
	 qtrans = qtrans+'"desc_lat":"'+document.getElementById('desc_lat').value+'",';
	 qtrans = qtrans+'"med_f_aut":"'+document.getElementById('med_f_aut').value+'",';
	 qtrans = qtrans+'"frente_lateral":"'+document.getElementById('frente_lateral').value+'",';
	 qtrans = qtrans+'"aba_cola":"'+document.getElementById('aba_cola').value+'",';
	 qtrans = qtrans+'"aba_superior":"'+document.getElementById('aba_superior').value+'",';
	 qtrans = qtrans+'"aba_inferior":"'+document.getElementById('aba_inferior').value+'",';
	 qtrans = qtrans+'"acrescimo_espessura":"'+document.getElementById('acrescimo_espessura').value+'",';
	 qtrans = qtrans+'"cx_ncx":"'+document.getElementById('cx_ncx').value+'",';
	 qtrans = qtrans+'"sentidoCartucho":"'+document.getElementById('cboSentidoCartucho').value+'",';
	 qtrans = qtrans+'"minimo_espaco":"'+document.getElementById('txtMinimoEspaco').value+'",';
	 let vid_user = <?php echo "'".$vid_user."'" ?>;
	 let vusuario = <?php echo "'".$vusuario."'" ?>;
	 qtrans = qtrans+'"id_user":"'+vid_user+'",';
	 qtrans = qtrans+'"usuario":"'+vusuario+'"';
	 qtrans = qtrans+'}';
	 //qtrans = JSON.stringify(qtrans);
	 //console.log(qtrans);
	 $.post('setData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
   		       //$('#txtmsg').text('Operação Efetuada com Sucesso');
			   //dialogFMsg.dialog('open');
			   showFPDF();
			
			} else if (vOper == 'Insert') { 
			   document.getElementById('txtPkRec').value = obj.error;
			   document.getElementById('txtPkRec_PDF').value = obj.error;
			   
			   
   		       //$('#txtmsg').text('Operação Efetuada com Sucesso');
			   //dialogFMsg.dialog('open');
			   showFPDF();
			}   
			else {
			
			}
			resetField();
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
      
  
  
  } 
  function formatDate(date) {
	var d = new Date(date),
		month = '' + (d.getMonth() + 1),
		day = '' + d.getDate(),
		year = d.getFullYear();

	if (month.length < 2) 
		month = '0' + month;
	if (day.length < 2) 
		day = '0' + day;

	return [year, month, day].join('-');
  }  
  
  
  function showDataCxEmb() { 
    //console.log(document.getElementById('txtData1').value);
    //let data  = document.getElementById('txtData1').value;
    var dateTypeVar = $('#txtData1').datepicker('getDate');
    let data = $.datepicker.formatDate('yy-mm-dd', new Date(dateTypeVar));	
    //console.log(data); 

	 $.post('getData.php',
	 {
	   q : 'caixaembdata',
	   s : data
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		    //console.log(data);
			tableCaixaEmb1.clear().draw();

			let obj1 = JSON.parse(data); 
			for (let i in obj1.caixaemb) {
			  //console.log(obj1.caixaemb[i].data);
			  let vdata = new Date(obj1.caixaemb[i].data);
			  vdata = vdata.toLocaleString('pt-BR');
			  vdata = vdata.substring(0,10);
			  tableCaixaEmb1.row.add([obj1.caixaemb[i].pk,vdata,obj1.caixaemb[i].fechamento,
			                          obj1.caixaemb[i].cartao,
			                          obj1.caixaemb[i].gramatura,
									  obj1.caixaemb[i].frente,
									  obj1.caixaemb[i].lateral,
									  obj1.caixaemb[i].altura,
									  obj1.caixaemb[i].usuario]).draw();
			}
            tableCaixaEmb1.cell(':eq(0)').focus();	
			
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
  
  }


  
</script>


</head>

<body>
<div class='header' id='top_header'>
 <p style='width:10vw;float:left;color:blue;'>Usuario:<?php echo $vusuario ?></p>

 <button type='button' id='btnTutorial'  title='Tutorial' style='width:8vw' onclick='tutorialon()'>Tutorial</button>
 <button type='button' id='btnCartao'  title='CARTÃO' style='width:8vw' onclick='showCard()'>Cartão</button>
 <button type='button' id='btnGram'  title='GRAMATURA' style='width:8vw' onclick='showCardg()'>Gramatura</button>
 <button type='button' id='btnCaixa'  title='CAIXA'  style='width:8vw' onclick='showCaixa()'>Caixas</button>
 <button type='button' id='btnMontagem'  title='MONTAGEM' style='width:8vw' onclick='showMontagem()'>Montagem</button>
 <button type='button' id='btnCaixaEmb'  title='CAIXA EMBARQUE' style='width:8vw' onclick='showCaixaEmb()'>Caixa Embarque</button>
 <button type='button' id='btnExit'  title='SAIR' style='width:8vw;float:right;color:red;' onclick='fsair()'>Sair</button>
 <!-- <li><a href='../saircx.php' style='width:8vw;float:right;color:red;'>SAIR</a></li> -->
 
 
 
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
<select id='fechamentos' name='fechamentos' onchange='sel_image()'>
  <option value='COMUM'>Comum</option>
  <option value='AUTOMATICO'>Automatico</option>
  <option value='HOTMELT'>Hotmelt</option>
  <option value='OUTROS'>Outros</option>
</select>

</td>
<td>
<select id='cartoes' name='cartoes'  onchange='sel_gramatura()'>
  <option value='DP'>DP</option>
  <option value='TP'>TP</option>
</select>

</td>
<td>
<select id='gramaturas' name='gramaturas' onchange='sel_peso()'>
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
<img src='' id='getImageCard' style='max-width:50%;object-fit:contain;' ></td>
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
	<select id='cboSentidoCartucho' style='font-size:1vw;width:8vw;font-weight:bold;' onchange='getSentidoImage()'>
	  <option value='PAISAGEM'>Paisagem</option>
	  <option value='RETRATO'>Retrato</option>
	</select>
	<script>
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
					if (value == document.getElementById('cx_ncx').value) {
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
<button type='button' id='btnSave' style='width:8vw;font-weight:bold;' onclick='saveRec()' disabled>Gravar</button>
<br><input type='text' id='txtPkRec' value='0'  disabled />
<input type='text' id='txtDataRec' value=''  disabled /><br><br>  
<button type='button' id='btnPDF' style='width:8vw;font-weight:bold;' onclick='showFPDF()' disabled>Gerar PDF</button><br><br>
<button type='button' id='btnReset' style='width:8vw;font-weight:bold;' onclick='resetField()'>Limpar/Resetar campos</button>
<!--<button type='button' id='btnClose' style='width:50px;'>Sair</button>-->
<div>


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
			unmaskAsNumber: true,
  });

  $('.decimalf').inputmask('currency', {'autoUnmask': true,
		    radixPoint:',',
            groupSeparator: '.',
		    allowMinus: true,
		    rightAlign: true,
		    inputtype:'text',
			prefix:'',
		    digits: 4,
			unmaskAsNumber: true,
  });
  $('.decimal0').inputmask('currency', {'autoUnmask': true,
		    radixPoint:',',
            groupSeparator: '.',
		    allowMinus: true,
		    rightAlign: true,
		    inputtype:'text',
			prefix:'',
		    digits: 0,
			unmaskAsNumber: true,
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
	function tutorialon() {
	  dialogFTutorial.dialog('open'); 
	}
	
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
	<select id='selCard1' onchange='sel_card()'>
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
    <label for = 'txtData1' style='display: inline-block;width:5vw;text-align:right;'>Data Pesquisa</label>
    <input type='text' id='txtData1' style='width:6vw;'></input>
	<button type='button' id='btnPesq' onclick='showDataCxEmb()'>Pesquisar</button><br><br>
    
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
   <input type='radio' id='montaFrente1' name='montaF1' value='FRENTE_CAIXA' onclick='setMontagemPDF(name)'>   
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
   <input type='radio' id='montaLateral1' name='montaL1' value='LATERAL_CAIXA' onclick='setMontagemPDF(name)'>   
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
function fsair() { location='../saircx.php' ; }

function setMontagemPDF(name) {
    //console.log(name);
	if (name == 'montaF1') {
  	    document.getElementById('fs03').setAttribute('style','background-color:#7FFFD4');
        document.getElementById('fs04').setAttribute('style','background-color:white');
		document.getElementById('montaFrente1').checked = true;
	    document.getElementById('montaLateral1').checked = false;
    } else {
        document.getElementById('fs03').setAttribute('style','background-color:white');
	    document.getElementById('fs04').setAttribute('style','background-color:#7FFFD4');
		document.getElementById('montaFrente1').checked = false;
	    document.getElementById('montaLateral1').checked = true;
    }
}

function showFPDF() {
   if (empty(document.getElementById('cx_ncx').value)) {
      $('#txtmsg').text('Falta escolher caixa');
      dialogFMsg.dialog('open');
      return;
   }
   
   document.getElementById('txtFrente_PDF').value = Number($('#frente').val());
   document.getElementById('txtLateral_PDF').value = Number($('#lateral').val());
   document.getElementById('txtAltura_PDF').value = Number($('#altura').val());
   $('#txtTipoFechamento_PDF').val($('#tipo_fechamento').val());
   document.getElementById('txtMedidaBase_PDF').value = Number($('#medida_base').val());
   document.getElementById('txtMedidaAltura_PDF').value = Number($('#medida_altura').val());
   document.getElementById('txtAcrescimoEspessura_PDF').value = Number($('#acrescimo_espessura').val());
   
   $('#txtNumCX_PDF').val($('#cx_ncx').val());
   document.getElementById('txtColCX_PDF').value = Number($('#cx_col').val());
   document.getElementById('txtgm2CX_PDF').value = Number($('#cx_gm2').val());
   $('#txtCLACX_PDF').val($('#cx_cla').val());
   $('#txtPallet_PDF').val($('#cx_pallet').val());
   $('#txtCantoneira_PDF').val($('#cx_canton').val());

   document.getElementById('txtQtdCartuchosFrente_PDF').value = Number($('#txtQtdCartuchoF').val());
   document.getElementById('txtPesoCaixaFrente_PDF').value = Number($('#txtPesoF').val());
   document.getElementById('txtAproveitamentoFrente_PDF').value = Number($('#txtPercentF').val());
   if (!query_mode)
      document.getElementById('txtQtdeRealFrente_PDF').value = '';


   document.getElementById('txtQtdCartuchosLateral_PDF').value = Number($('#txtQtdCartuchoL').val());
   document.getElementById('txtPesoCaixaLateral_PDF').value = Number($('#txtPesoL').val());
   document.getElementById('txtAproveitamentoLateral_PDF').value = Number($('#txtPercentL').val());
   if (!query_mode)
      document.getElementById('txtQtdeRealLateral_PDF').value = '';
   
   $('#txtCodigoMontagem_PDF').val($('#txtCodigoMontagem').val());
   document.getElementById('getImageMontagem_PDF').src = document.getElementById('getImageMontagem').src;
   
   
   $('#txtCodDescricaoColagem_PDF').text($('#txtCodDescricaoColagem').text());
   $('#txtCodSentidoCartucho_PDF').text($('#txtCodSentidoCartucho').text());
   

   dialogFPDF.dialog('open');

}

var vType;
var vOper;
var vModal;
var vSpanModal;
function showCard() {
    if (tableCard.rows().count() == 0) {
		for (let i=0;i<tbcartao.length;i++) {
		  tableCard.row.add([tbcartao[i][1],tbcartao[i][2]]).draw();
		}
	}
    dialogFCard.dialog('open');
    tableCard.columns.adjust().draw();	
	
}

var tableCard;
var rowCard;
makeTableCard();   

function makeTableCard() {
	tableCard = new DataTable('#tbCard1', {
		keys: true,
		paging:true,
		info:false,
		ordering:false,
		scrollX: false,
		scroller: true,
		scrollY: 200,
		searching: false,        
	});
	 
	tableCard
		//.on('click', 'tbody tr', function (e) {
		//    let data = tableCaixaEmb.row(this).data();
		//    console.log('You clicked on ' + data[0] + "'s row");
		//})
		.on('key', function (e, datatable, key, cell, originalEvent) {
			//console.log('Key press: ' + key + ' for cell <i>' + cell.data() + '</i>');
			
		})
		.on('key-focus', function (e, datatable, cell) {
		    rowCard = cell.index().row;
            document.getElementById('txtPkCard').value = tbcartao[rowCard][0];  			
            document.getElementById('txtRowCard').value = rowCard;  			
            document.getElementById('txtTpCard').value = tbcartao[rowCard][1];  			
            document.getElementById('txtDescrCard').value = tbcartao[rowCard][2]; 			
	        document.getElementById('txtDescrCard').disabled = true;
		});
		//.on('key-blur', function (e, datatable, cell) {
		//    console.log('Cell blur: <i>' + cell.data() + '</i>');
		//});
}


function showCardg() {
    $('#selCard1').empty();
	for (let i=0;i<tbcartao.length;i++) {
	   let optText = tbcartao[i][1];
	   let optValue = tbcartao[i][1];
	   $('#selCard1').append(new Option(optText, optValue));		
	}
	$('#selCard1').get(0).selectedIndex = -1;
    tableCardg.clear().draw();
	
    dialogFCardGram.dialog('open');
}

function sel_card() {
    if (empty(tableCardg))
    	makeTableCardg();
    if (!empty(tableCardg)) {
       tableCardg.clear().draw();
    }	   
    for (let i=0;i<tbcartaogram.length;i++) {
      if (tbcartaogram[i][1] == document.getElementById('selCard1').value) {
		  tableCardg.row.add([tbcartaogram[i][1],tbcartaogram[i][2],tbcartaogram[i][3],i]).draw();
 	  }
	}
    tableCardg.cell(':eq(0)').focus();	
}

makeTableCardg();
function makeTableCardg() {
	tableCardg = new DataTable('#tbCardg1', {
		keys: true,
		paging:true,
		info:false,
		ordering:false,
		scrollX: false,
		scroller: true,
		scrollY: 270,
		searching: false,        
	});
	 
	tableCardg
		//.on('click', 'tbody tr', function (e) {
		//    let data = tableCaixaEmb.row(this).data();
		//    console.log('You clicked on ' + data[0] + "'s row");
		//})
		.on('key', function (e, datatable, key, cell, originalEvent) {
			//console.log('Key press: ' + key + ' for cell <i>' + cell.data() + '</i>');
			
		})
		.on('key-focus', function (e, datatable, cell) {
		    rowCard = cell.index().row;
            let data = tableCardg.row(cell.index().row).data();			
			let x = data[3]; 
            document.getElementById('txtPkCardGram').value = tbcartaogram[x][0];  			
            document.getElementById('txtRowCardGram').value = rowCard;  			
            document.getElementById('txtIndCardGram').value = x;  			
            document.getElementById('txtCardGram').value = tbcartaogram[x][1];  			
            document.getElementById('txtGram').value = tbcartaogram[x][2]; 			
	        document.getElementById('txtGram').disabled = true;
            document.getElementById('txtEspessuraGram').value = tbcartaogram[x][3]; 			
	        document.getElementById('txtEspessuraGram').disabled = true;
			
		});
		//.on('key-blur', function (e, datatable, cell) {
		//    console.log('Cell blur: <i>' + cell.data() + '</i>');
		//});
}



function showCaixa() {
    if (tableCaixa1.rows().count() == 0) {
		for (let i=0;i<tbcaixas.length;i++) {
	    tableCaixa1.row.add([tbcaixas[i][1],tbcaixas[i][2],tbcaixas[i][3],
	                        tbcaixas[i][4],tbcaixas[i][6],
							tbcaixas[i][8],
							tbcaixas[i][9],tbcaixas[i][10]]).draw();
		}
	}
    dialogFCaixa.dialog('open');
    tableCaixa1.columns.adjust().draw();	
}

var tableCaixa1;
makeTableCaixa1();   

function makeTableCaixa1() {
	tableCaixa1 = new DataTable('#tbCaixa1', {
		keys: true,
		paging:true,
		info:false,
		ordering:false,
		scrollX: false,
		scroller: true,
		scrollY: 270,
		searching: false,        
	});
	 
	tableCaixa1
		//.on('click', 'tbody tr', function (e) {
		//    let data = tableCaixaEmb.row(this).data();
		//    console.log('You clicked on ' + data[0] + "'s row");
		//})
		.on('key', function (e, datatable, key, cell, originalEvent) {
			//console.log('Key press: ' + key + ' for cell <i>' + cell.data() + '</i>');
			
		})
		.on('key-focus', function (e, datatable, cell) {
		    rowCard = cell.index().row;
            document.getElementById('txtPkCaixa').value = tbcaixas[rowCard][0];  			
            document.getElementById('txtRowCaixa').value = rowCard;  			
            document.getElementById('txtNCX').value = tbcaixas[rowCard][1];  			
            document.getElementById('txtCol').value = tbcaixas[rowCard][2]; 			
            document.getElementById('txtgm2').value = tbcaixas[rowCard][3]; 			
            document.getElementById('txtComp').value = tbcaixas[rowCard][4]; 			
            document.getElementById('txtLarg').value = tbcaixas[rowCard][6]; 			
            document.getElementById('txtAlt').value = tbcaixas[rowCard][8]; 			
            document.getElementById('txtPallet').value = tbcaixas[rowCard][9]; 			
            document.getElementById('txtCanton').value = tbcaixas[rowCard][10]; 			
		});
		//.on('key-blur', function (e, datatable, cell) {
		//    console.log('Cell blur: <i>' + cell.data() + '</i>');
		//});
}


function showMontagem() {
    if (tableMontagem1.rows().count() == 0) {
		for (let i=0;i<tbmontagem.length;i++) {
	      tableMontagem1.row.add([tbmontagem[i][1],tbmontagem[i][2],tbmontagem[i][3]]).draw();
		}
	}
    dialogFMontagem.dialog('open');
    tableMontagem1.columns.adjust().draw();	
}

var tableMontagem1;
makeTableMontagem1();   

function makeTableMontagem1() {
	tableMontagem1 = new DataTable('#tbMontagem1', {
		keys: true,
        //keys: {
        //    keys: [38, 40]
        //},
		paging:true,
		info:false,
		ordering:false,
		scrollX: false,
		scroller: true,
		scrollY: 270,
		searching: false,        
        select: false,		
	});
	 
	tableMontagem1
		//.on('click', 'tbody tr', function (e) {
		//    let data = tableCaixaEmb.row(this).data();
		//    console.log('You clicked on ' + data[0] + "'s row");
		//})
		.on('key', function (e, datatable, key, cell, originalEvent) {
			//console.log('Key press: ' + key + ' for cell <i>' + cell.data() + '</i>');
			
		})
		.on('key-focus', function (e, datatable, cell) {
		    rowCard = cell.index().row;
			//console.log(rowCard);
            document.getElementById('txtPkMontagem').value = tbmontagem[rowCard][0];  			
            document.getElementById('txtRowMontagem').value = rowCard;  			
            document.getElementById('txtCodMontagem1').value = tbmontagem[rowCard][1];  			
            document.getElementById('txtDescrMontagem').value = tbmontagem[rowCard][2]; 			
            document.getElementById('txtSentMontagem').value = tbmontagem[rowCard][3]; 			
			let classList = e.currentTarget.classList;
			//console.log(classList);
	 
			if (classList.contains('selected')) {
				classList.remove('selected');
			}
			else {
				tableMontagem1.rows('.selected').nodes().each((row) => row.classList.remove('selected'));
				classList.add('selected');
			}		
			
		});
		//.on('key-blur', function (e, datatable, cell) {
		//    console.log('Cell blur: <i>' + cell.data() + '</i>');
		//});
}



function showCaixaEmb() {
    dialogFCaixaEmb.dialog('open');
    tableCaixaEmb1.columns.adjust().draw();	
	
}

var tableCaixaEmb1;
var rowCaixaEmb;
makeTableCaixaEmb1();

function makeTableCaixaEmb1() {
	tableCaixaEmb1 = new DataTable('#tbCaixaEmb1', {
		keys: true,
		paging:true,
		info:false,
		ordering:false,
		scrollX: false,
		scroller: true,
		scrollY: 270,
		searching: false,        
	});
	 
	tableCaixaEmb1
		//.on('click', 'tbody tr', function (e) {
		//    let data = tableCaixaEmb1.row(this).data();
		//    console.log('You clicked on ' + data[0] + "'s row");
		//})
		.on('key', function (e, datatable, key, cell, originalEvent) {
			//console.log('Key press: ' + key + ' for cell <i>' + cell.data() + '</i>');
			
		})
		.on('key-focus', function (e, datatable, cell) {
		    rowCaixaEmb = cell.index().row;
            let data = tableCaixaEmb1.row(cell.index().row).data();			
			let x = data[0]; 
            document.getElementById('txtPkRec').value = x;  			
		});
		//.on('key-blur', function (e, datatable, cell) {
		//    console.log('Cell blur: <i>' + cell.data() + '</i>');
		//});
}

$(document).ready(function() {
  loadCard();
  loadCardg();
  loadCaixa();
  loadMontagem();
});


function loadCard() {
	 $.post('getData.php',
	 {
	   q : 'Card'
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
			let obj = JSON.parse(data);
			let j = 0;
			tbcartao = [];
			for (let i in obj.cartao) { 
			   tbcartao.push([]);
			   tbcartao[j].push(new Array(3));
			   tbcartao[j][0] = obj.cartao[i].pk;
			   tbcartao[j][1] = obj.cartao[i].tpCartao;
			   tbcartao[j][2] = obj.cartao[i].descricao;
			   j++;
			}
            let x = document.getElementById('cartoes');
			while (x.options.length>0)
			   x.remove(0);
			for (let i = 0;i < tbcartao.length;i++) {
			  let option = document.createElement('option');
			  option.text = tbcartao[i][1];
			  x.add(option);
			}
            $('#cartoes').get(0).selectedIndex = -1;
			
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });

}


function loadCardg() {
	 $.post('getData.php',
	 {
	   q : 'Cardg'
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		   let obj1 = JSON.parse(data); 
		   let j = 0;
		   for (let i in obj1.cartaogram) {   
			 tbcartaogram.push([]);
			 tbcartaogram[j].push(new Array(4));
			 tbcartaogram[j][0] = obj1.cartaogram[i].pk;
			 tbcartaogram[j][1] = obj1.cartaogram[i].tpCartao;
			 tbcartaogram[j][2] = Number(obj1.cartaogram[i].gram);
			 tbcartaogram[j][3] = Number(obj1.cartaogram[i].espessura);
			 j++;
		   } 	 
		   //console.log(tbcartaogram);   
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });

}


function loadCaixa() {
	 $.post('getData.php',
	 {
	   q : 'Caixa'
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		   //console.log(data);
		   let obj1 = JSON.parse(data); 
		   let j = 0;
		   tbcaixas = [];
		   for (let i in obj1.caixa) {   
		  	 tbcaixas.push([]);
			 tbcaixas[j].push(new Array(12));
			 tbcaixas[j][0] = obj1.caixa[i].pk;
			 tbcaixas[j][1] = obj1.caixa[i].ncx;
			 tbcaixas[j][2] = Number(obj1.caixa[i].col);
			 tbcaixas[j][3] = Number(obj1.caixa[i].gm2);
			 tbcaixas[j][4] = Number(obj1.caixa[i].c);
			 tbcaixas[j][5] = 'x';
			 tbcaixas[j][6] = Number(obj1.caixa[i].l);
			 tbcaixas[j][7] = 'x';
			 tbcaixas[j][8] = Number(obj1.caixa[i].a);
			 tbcaixas[j][9] = Number(obj1.caixa[i].pallet);
			 tbcaixas[j][10] = obj1.caixa[i].cantoneira;
			 tbcaixas[j][11] = 0.0;
			 j++;
		   }
		   mountBox();	  
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
}

function loadCaixaUpd() {
	 $.post('getData.php',
	 {
	   q : 'Caixa'
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		   //console.log(data);
		   let obj1 = JSON.parse(data); 
		   let j = 0;
		   tbcaixas = [];
		   for (let i in obj1.caixa) {   
		  	 tbcaixas.push([]);
			 tbcaixas[j].push(new Array(12));
			 tbcaixas[j][0] = obj1.caixa[i].pk;
			 tbcaixas[j][1] = obj1.caixa[i].ncx;
			 tbcaixas[j][2] = Number(obj1.caixa[i].col);
			 tbcaixas[j][3] = Number(obj1.caixa[i].gm2);
			 tbcaixas[j][4] = Number(obj1.caixa[i].c);
			 tbcaixas[j][5] = 'x';
			 tbcaixas[j][6] = Number(obj1.caixa[i].l);
			 tbcaixas[j][7] = 'x';
			 tbcaixas[j][8] = Number(obj1.caixa[i].a);
			 tbcaixas[j][9] = Number(obj1.caixa[i].pallet);
			 tbcaixas[j][10] = obj1.caixa[i].cantoneira;
			 tbcaixas[j][11] = 0.0;
			 j++;
		   }
		   for (let i=0;i<tbcaixas.length;i++) {
			   let vNCX = tbcaixas[i][1];
			   let vCol = tbcaixas[i][2];
			   let vGm = tbcaixas[i][3];
			   let vC = tbcaixas[i][4];
			   let vX1 = tbcaixas[i][5];
			   let vL = tbcaixas[i][6];
			   let vX2 = tbcaixas[i][7];
			   let vA = tbcaixas[i][8];
			   let vPallet = tbcaixas[i][9];
			   let vCanton = tbcaixas[i][10];
			   let vCubagem = tbcaixas[i][11];

			   tableCaixaEmb.row.add([tbcaixas[i][1],tbcaixas[i][2],tbcaixas[i][3],
									  tbcaixas[i][4],tbcaixas[i][5],tbcaixas[i][6],
									  tbcaixas[i][7],tbcaixas[i][8]]).draw();
			   
		   }
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
}


function loadMontagem() {
	 $.post('getData.php',
	 {
	   q : 'Montagem'
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		   let obj1 = JSON.parse(data); 
		   let j = 0;
		   for (let i in obj1.montagem) {   
		 	 tbmontagem.push([]);
			 tbmontagem[j].push(new Array(12));
			 tbmontagem[j][0] = obj1.montagem[i].pk;
			 tbmontagem[j][1] = obj1.montagem[i].codigo;
			 tbmontagem[j][2] = obj1.montagem[i].descricao;
			 tbmontagem[j][3] = obj1.montagem[i].sentido;
			 j++;
		   }	 
		   //console.log(tbmontagem);   
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });


}


var tableCaixaEmb;
var varAltura;
var varComprimento;
var varLargura; 
var varCubagem;

function mountBox() {  
	tableCaixaEmb = new DataTable('#tbcaixaEmbarque', {
		keys: true,
		paging:false,
		info:false,
		ordering:false,
		scrollX: true,
		scrollY: 300,
		searching: false,  
        select: false,		
	});
	 
	tableCaixaEmb
		//.on('click', 'tbody tr', function (e) {
		//    let data = tableCaixaEmb.row(this).data();
		//    console.log('You clicked on ' + data[0] + "'s row");
		//})
		//.on('key', function (e, datatable, key, cell, originalEvent) {
		//    console.log('Key press: ' + key + ' for cell <i>' + cell.data() + '</i>');
		//})
		.on('key-focus', function (e, datatable, cell) {
			//console.log('Cell focus: <i>' + cell.data() + '</i>');
			let data = tableCaixaEmb.row(cell.index().row).data();
			let row = cell.index().row;
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

			let classList = e.currentTarget.classList;
			//console.log(classList);
	 
			if (classList.contains('selected')) {
				classList.remove('selected');
			}
			else {
				tableCaixaEmb.rows('.selected').nodes().each((row) => row.classList.remove('selected'));
				classList.add('selected');
			}		
			
			
			Identificando_Caixas();
			//console.log(data[0]);   
			//console.log(cell.index().row);
			  
				// FOR DEMONSTRATION ONLY
			//$("#example-console").html(data.join(', '));
			//e.currentTarget.classList.toggle('selected');
			
		})
		//.on('key-blur', function (e, datatable, cell) {
		//    console.log('Cell blur: <i>' + cell.data() + '</i>');
		//});
		
	for (let i=0;i<tbcaixas.length;i++) {
	   let vNCX = tbcaixas[i][1];
	   let vCol = tbcaixas[i][2];
	   let vGm = tbcaixas[i][3];
	   let vC = tbcaixas[i][4];
	   let vX1 = tbcaixas[i][5];
	   let vL = tbcaixas[i][6];
	   let vX2 = tbcaixas[i][7];
	   let vA = tbcaixas[i][8];
	   let vPallet = tbcaixas[i][9];
	   let vCanton = tbcaixas[i][10];
	   let vCubagem = tbcaixas[i][11];

	   //let dynamicRowHTML = '<tr><td>'+vNCX+'</td><td>'+vCol+'</td><td>'+vGm+
							'</td><td>'+vC+'</td><td>'+vX1+'</td><td>'+vL+
							'</td><td>'+vX2+'</td><td>'+vA+'</td></tr>';
	   //$('#tbody').append(dynamicRowHTML);
	   tableCaixaEmb.row.add([tbcaixas[i][1],tbcaixas[i][2],tbcaixas[i][3],
	                          tbcaixas[i][4],tbcaixas[i][5],tbcaixas[i][6],
							  tbcaixas[i][7],tbcaixas[i][8]]).draw();
	   
	}
		
}



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
