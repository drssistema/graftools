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
	if(empty($_SESSION['id'])){
		$_SESSION['msg'] = "Área restrita";
		header("Location: index.php");	
		return;
	}
	$vid_user = $_SESSION['id'];
	$vusuario = $_SESSION['nome'];
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Hot Stamping</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='jquery-3.7.1.min.js'></script>
<script src='jquery-ui.js'></script>
<link rel='stylesheet' href='jquery-ui.css'>
<script src='jquery.inputmask.js'></script>
<script src='jspdf.min.js'></script>
<script src='module1_hs.js'></script>

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
  z-index: 10;
}

.main {
  position:absolute;
  top: 3vw;
  left: 0vw;
  padding: 0px;
  height: 100%;
  width: 100%;
}




.div1 {
  position: absolute;
  top: 0vw;
  left: 2vw;
  width: auto;
  height: auto;
}
.div1a {
  position: absolute;
  top: 8vw;
  left: 2vw;
  width: auto;
  height: auto;
}

.div2 {
  position: absolute;
  top: 12vw;
  left: 2vw;
  width: 25vw;
  height:20vw;
}

.div3 {
  position:absolute;
  top: 0vw; 
  left: 18vw;
  width: 45vw;
  height:20vw;
}
.div4 {
  position: absolute;
  top: 0vw;
  left: 48vw;
  width: 32vw;
  height: 30vw;
}

.div5 {
  position:absolute;
  top: 12vw;
  left: 18vw;
  width: 70vw;
  height:10vw;
}


input[type=text]:focus {
   background-color: yellow;
}

input[type=checkbox] {
   font-size: 0.6vw;
}
input[type=radio] {
   font-size: 0.6vw;
}

table {
  font-size: 0.8vw;
}


table th {
  font-size: 0.6vw;
}
table td {
  fonte-size: 0.6vw;
}
legend {
  fonte-size: 0.6vw;
}
label {
  fonte-size: 0.6vw;
}
p {
  fonte-size: 0.6vw;
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
var dialogFTutorial,
    dialogFMsg;

$(function() {
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
	  
	/*  
	$('input').on('keydown',function(e) {
		let keyCode = e.keyCode || e.which;
		if (e.keyCode === 13) {
			e.preventDefault();
			try {
 		         //$('input')[$('input').index(this)+1].focus();
 		         var next = $('input')[$('input').index(this)+1];
			     if (!next.disabled)
				     next.focus();
			} catch (ex) {
			}         
		}
	  
	});
	*/
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
	
});

function nextField(event,vfield) {
   if (event.key == 'Enter') {
      document.getElementById(vfield).focus();
   }

}

function NovoCalculo() {
    $('#Lbl_Min_Compra').text('');
    Resto_Bobina = 0;
    document.getElementById('Text_Puxada_Longa').value='';
    Intervalo_Puxada = 0;
    document.getElementById('Text_Total_Folhas').value='';
    document.getElementById('LBL_Larg_Bob_Fornec').value='';
    document.getElementById('Lbl_Min_Lineares').value='';
    document.getElementById('Lbl_Max_Lineares').value='';
    //$('#Lbl_Tot_Rolos').text('');
    $('#Lbl_Tot_Rolos_2').text('');
    document.getElementById('Text_Res_A').value='';
    document.getElementById('Text_Res_B').value='';
    document.getElementById('Text_Res_C').value='';
    document.getElementById('Text_Res_D').value='';
    document.getElementById('Text_Res_E').value='';
    document.getElementById('Text_Res_F').value='';
    document.getElementById('Text_Res_G').value='';
    $('#Lbl_Opcao_Calculo').text('');
    Opcao_Bobina = false;
    Opcao_Rolo = false;
    Limpar_Campos_J1_Prim();
    Limpar_Campos_J1_Seg();
    Limpar_Campos_J2_Prim();
    Limpar_Campos_J2_Seg();
    //Frame1.Enabled = True
    //Frame2.Enabled = False
    //Frame3.Enabled = False
    //Frame4.Enabled = False
    $('#Lbl_Msg_1').text('');
    $('#Lbl_Msg_2').text('');
    $('#Lbl_Msg_3').text('');
	
    $('#Lbl_Tot_Rolos_2').text(' ');
    $('#Lbl_Larg_Produzir_Hot').text(' ');
    $('#Lbl_Resto_Bobina').text(' ');
	
    
    Larg_Normal_Crown_MP = 0.64;
    Larg_Duplo_Crown_MP = Larg_Normal_Crown_MP * 2;
    Larg_Normal_Kurz = 0.61;
    Larg_Duplo_Kurz = Larg_Normal_Kurz * 2;
    Larg_Bob_Fornec = '';
    Min_Lineares = 61;
    Max_Lineares = 2440;
    Min_Mts_Lin = 244;
    
    document.getElementById('J1_Prim_Opt_Ativo_Sim').checked = false;
    document.getElementById('J1_Prim_Opt_Ativo_Nao').checked = false;

    document.getElementById('J1_Seg_Opt_Ativo_Sim').checked = false;
    document.getElementById('J1_Seg_Opt_Ativo_Nao').checked = false;
    
    document.getElementById('J2_Prim_Opt_Ativo_Sim').checked = false;
    document.getElementById('J2_Prim_Opt_Ativo_Nao').checked = false;
    
    document.getElementById('J2_Seg_Opt_Ativo_Sim').checked = false;
    document.getElementById('J2_Seg_Opt_Ativo_Nao').checked = false;
    
    document.getElementById('J1_Prim_Opt_Ativo_Sim').checked = true;
    document.getElementById('J1_Seg_Opt_Ativo_Nao').checked = true;
    document.getElementById('J2_Prim_Opt_Ativo_Nao').checked = true;
    document.getElementById('J2_Seg_Opt_Ativo_Nao').checked = true;
    
    Chk_J2_Prim = 0;
    Chk_J2_Seg = 0;
    
    Frame_Puxar_J1.style.display = 'none';
    Gerar_Combo_Fornecedor();
    document.getElementById('Opt_Normal').checked = false;
    document.getElementById('Opt_Duplo').checked = false;
    document.getElementById('Opt_Duplo').disabled = true;
    document.getElementById('Opt_Normal').disabled = true;
    //document.getElementById('Opt_Duplo').style.display = 'none';
    //document.getElementById('Opt_Normal').style.display = 'none';
	document.getElementById('Text_J1_Seg_LARG_ROLO').disabled = true;
	document.getElementById('Text_J2_Prim_LARG_ROLO').disabled = true;
	document.getElementById('Text_J2_Seg_LARG_ROLO').disabled = true;
	
	document.getElementById('Text_J1_Seg_Puxada_Limpeza').disabled = true;
	document.getElementById('Text_J2_Prim_Puxada_Limpeza').disabled = true;
	document.getElementById('Text_J2_Seg_Puxada_Limpeza').disabled = true;
	
	document.getElementById('Text_J1_Seg_BAT_CURTA').disabled = true;
	document.getElementById('Text_J2_Prim_BAT_CURTA').disabled = true;
	document.getElementById('Text_J2_Seg_BAT_CURTA').disabled = true;
	
	document.getElementById('Text_J1_Seg_N_BAT_CURTA').disabled = true;
	document.getElementById('Text_J2_Prim_N_BAT_CURTA').disabled = true;
	document.getElementById('Text_J2_Seg_N_BAT_CURTA').disabled = true;
	
	document.getElementById('Text_J1_Seg_BAT_CURTA_2').disabled = true;
	document.getElementById('Text_J2_Prim_BAT_CURTA_2').disabled = true;
	document.getElementById('Text_J2_Seg_BAT_CURTA_2').disabled = true;
	
	document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').disabled = true;
	document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').disabled = true;
	document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').disabled = true;
	
	document.getElementById('Text_J1_Seg_BAT_LONGA').disabled = true;
	document.getElementById('Text_J2_Prim_BAT_LONGA').disabled = true;
	document.getElementById('Text_J2_Seg_BAT_LONGA').disabled = true;
	
	document.getElementById('Text_J1_Seg_PUXADA').disabled = true;
	document.getElementById('Text_J2_Prim_PUXADA').disabled = true;
	document.getElementById('Text_J2_Seg_PUXADA').disabled = true;
	
	document.getElementById('Text_J1_Seg_TOT_BAT').disabled = true;
	document.getElementById('Text_J2_Prim_TOT_BAT').disabled = true;
	document.getElementById('Text_J2_Seg_TOT_BAT').disabled = true;
	
    document.getElementById('Text_Total_Folhas').focus();

    $('#Cmb_Fornecedor').get(0).selectedIndex = -1;
    document.getElementById('Btn_Calcular').disabled = true;
	
}
function selFornec() {
    //document.getElementById('Opt_Normal').style.display = 'block';
    //document.getElementById('Opt_Duplo').style.display = 'block';
    document.getElementById('Opt_Normal').disabled = false;
    document.getElementById('Opt_Duplo').disabled = false;
    document.getElementById('Opt_Normal').checked = false;
    document.getElementById('Opt_Duplo').checked = false;
    document.getElementById('LBL_Larg_Bob_Fornec').value = '';
    document.getElementById('Lbl_Min_Lineares').value = '';
    document.getElementById('Lbl_Max_Lineares').value = '';
	//document.getElementById('Opt_Normal').focus();
}
function setPuxadaLonga() {
    document.getElementById('Text_J1_Prim_BAT_LONGA').value = document.getElementById('Text_Puxada_Longa').value;
    document.getElementById('Cmb_Fornecedor').focus(); 
}
function Opt_Duplo_Click() {
    
    let Var_Larg_Normal;
    let Var_Larg_Duplo;
    let Min_Lineares;
    let Max_Lineares;
    //$("input[type='radio'][name='rate']:checked").val()   
    if (document.getElementById('Cmb_Fornecedor').value == "Crown") {
        Var_Larg_Normal = Larg_Normal_Crown_MP;
        Var_Larg_Duplo = Larg_Duplo_Crown_MP;
        //document.getElementById('Opt_Normal').style.display = 'block';
        //document.getElementById('Opt_Duplo').style.display = 'block';
    }    
    else if (document.getElementById('Cmb_Fornecedor').value == "Kurz") {
        Var_Larg_Normal = Larg_Normal_Kurz;
        Var_Larg_Duplo = Larg_Duplo_Kurz;
        //document.getElementById('Opt_Normal').style.display = 'block';
        //document.getElementById('Opt_Duplo').style.display = 'block';
	}	
    else  {
        Var_Larg_Normal = 0;
        Var_Larg_Duplo = 0;
        document.getElementById('Opt_Normal').checked = true;
        document.getElementById('Opt_Duplo').checked = true;
        //document.getElementById('Opt_Normal').style.display = 'none';
        //document.getElementById('Opt_Duplo').style.display = 'none';
        document.getElementById('Opt_Normal').disabled = true;
        document.getElementById('Opt_Duplo').disabled = true;
    }
    
    //if (Opt_Duplo.Value == true) {
        Larg_Bob_Fornec = Var_Larg_Duplo;
        Min_Lineares = 61;
        Max_Lineares = 2440;
    document.getElementById('LBL_Larg_Bob_Fornec').value = Larg_Bob_Fornec;
    document.getElementById('Lbl_Min_Lineares').value = Min_Lineares;
    document.getElementById('Lbl_Max_Lineares').value = Max_Lineares.toFixed(0);
    
    //' Crown / MP
    //LBL_Larg_Bob_Fornec.BackColor = &H80000005  'Cor Branca
    //LBL_Larg_Bob_Fornec.ForeColor = &HFF&       'Fonte Vermelha
    //Lbl_Min_Lineares.BackColor = &H80000005  'Cor Branca
    //Lbl_Min_Lineares.ForeColor = &HFF&       'Fonte Vermelha
    //Lbl_Max_Lineares.BackColor = &H80000005  'Cor Branca
    //Lbl_Max_Lineares.ForeColor = &HFF&       'Fonte Vermelha
	
	
    Btn_Atualiza_Tot_Rolos_Click();
	document.getElementById('Text_J1_Prim_LARG_ROLO').focus();
}
function Opt_Normal_Click() {
    let Var_Larg_Normal;
    let Var_Larg_Duplo;
    let Min_Lineares;
    let Max_Lineares;
    
    if (document.getElementById('Cmb_Fornecedor').value == "Crown") {
        Var_Larg_Normal = Larg_Normal_Crown_MP;
        Var_Larg_Duplo = Larg_Duplo_Crown_MP;
        //document.getElementById('Opt_Normal').style.display = 'block';
        //document.getElementById('Opt_Duplo').style.display = 'block';
    }    
    else if (document.getElementById('Cmb_Fornecedor').value == "Kurz") {
        Var_Larg_Normal = Larg_Normal_Kurz;
        Var_Larg_Duplo = Larg_Duplo_Kurz;
        //document.getElementById('Opt_Normal').style.display = 'block';
        //document.getElementById('Opt_Duplo').style.display = 'block';
	}	
    else  {
        Var_Larg_Normal = 0;
        Var_Larg_Duplo = 0;
        document.getElementById('Opt_Normal').checked = true;
        document.getElementById('Opt_Duplo').checked = true;
        //document.getElementById('Opt_Normal').style.display = 'none';
        //document.getElementById('Opt_Duplo').style.display = 'none';
        document.getElementById('Opt_Normal').disabled = true;
        document.getElementById('Opt_Duplo').disabled = true;
    }
    
    //If Opt_Normal.Value = True Then
        Larg_Bob_Fornec = Var_Larg_Normal;
        Min_Lineares = 61;
        Max_Lineares = 2440;
    document.getElementById('LBL_Larg_Bob_Fornec').value = Larg_Bob_Fornec;
    document.getElementById('Lbl_Min_Lineares').value = Min_Lineares;
    document.getElementById('Lbl_Max_Lineares').value = Number(Max_Lineares.toFixed(0));
    
    //' Crown / MP
    //LBL_Larg_Bob_Fornec.BackColor = &H80000005  'Cor Branca
    //LBL_Larg_Bob_Fornec.ForeColor = &HFF&       'Fonte Vermelha
    //Lbl_Min_Lineares.BackColor = &H80000005  'Cor Branca
    //Lbl_Min_Lineares.ForeColor = &HFF&       'Fonte Vermelha
    //Lbl_Max_Lineares.BackColor = &H80000005  'Cor Branca
    //Lbl_Max_Lineares.ForeColor = &HFF&       'Fonte Vermelha
    
    Btn_Atualiza_Tot_Rolos_Click();
	document.getElementById('Text_J1_Prim_LARG_ROLO').focus();
}

function Btn_Atualiza_Tot_Rolos_Click() {
    document.getElementById('Text_Res_A').value='';
    document.getElementById('Text_Res_B').value='';
    document.getElementById('Text_Res_C').value='';
    document.getElementById('Text_Res_D').value='';
    document.getElementById('Text_Res_E').value='';
    document.getElementById('Text_Res_F').value='';
    document.getElementById('Text_Res_G').value='';
    $('#Lbl_Msg_1').text('');
    $('#Lbl_Msg_2').text('');
    $('#Lbl_Msg_3').text('');
    
    //If ChkBox_J1_Prim_Nenhum.Value = False And _
    //        ChkBox_J1_Prim_J1_Seg.Value = False And _
    //        ChkBox_J1_Prim_J2_Prim.Value = False And _
    //        ChkBox_J1_Prim_Todos.Value = True Then
	//if ($("input[type='radio'][name='ChkBox_J1']:checked").val()=='4') {
	if (document.getElementById('ChkBox_J1_Prim_Todos').checked) {
        document.getElementById('Text_J2_Seg_LARG_ROLO').disabled = false;
        if ($('#Text_J2_Seg_LARG_ROLO').val() == "")
 		    document.getElementById('Text_J2_Seg_LARG_ROLO').value = document.getElementById('Text_J2_Prim_LARG_ROLO').value;
//'       Text_J2_Seg_LARG_ROLO.Value = Text_J2_Prim_LARG_ROLO
        document.getElementById('Text_J2_Seg_Puxada_Limpeza').value = document.getElementById('Text_J2_Prim_Puxada_Limpeza').value;
        document.getElementById('Text_J2_Seg_BAT_CURTA').value = document.getElementById('Text_J2_Prim_BAT_CURTA').value;
        document.getElementById('Text_J2_Seg_N_BAT_CURTA').value = document.getElementById('Text_J2_Prim_N_BAT_CURTA').value;
        document.getElementById('Text_J2_Seg_BAT_CURTA_2').value = document.getElementById('Text_J2_Prim_BAT_CURTA_2').value;
        document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').value = document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value;
        document.getElementById('Text_J2_Seg_BAT_LONGA').value = document.getElementById('Text_J2_Prim_BAT_LONGA').value;
        document.getElementById('Text_J2_Seg_PUXADA').value = document.getElementById('Text_J2_Prim_PUXADA').value;
        document.getElementById('Text_J2_Seg_TOT_BAT').value = document.getElementById('Text_J2_Prim_TOT_BAT').value;
    }
    
    
    let Var1, Var2, Var3, Var4, Var5, Total;
    let soma=0;
    let Tot_Larg_Rolos_Ativos;
    soma = 0;
    Tot_Larg_Rolos_Ativos = 0;
    Var1 = 1;
    Var2 = 1;
    Var3 = 1;
    Var4 = 1;
    Var5 = 1;
//'   Var6 = 1
    Total = 0;
    
    //if (J1_Prim_Opt_Ativo_Sim.Value == true) {
    if (document.getElementById('J1_Prim_Opt_Ativo_Sim').checked) {
        soma = soma + 1;
        if (document.getElementById('Text_J1_Prim_LARG_ROLO').value != "")
  		    Tot_Larg_Rolos_Ativos = Tot_Larg_Rolos_Ativos + Number(Number(document.getElementById('Text_J1_Prim_LARG_ROLO').value).toFixed(0));
    }
    //if (J2_Prim_Opt_Ativo_Sim.Value == true) {
    if (document.getElementById('J2_Prim_Opt_Ativo_Sim').checked) {
        soma = soma + 1;
        if (document.getElementById('Text_J2_Prim_LARG_ROLO').value != "")
		    Tot_Larg_Rolos_Ativos = Tot_Larg_Rolos_Ativos + Number(Number(document.getElementById('Text_J2_Prim_LARG_ROLO').value).toFixed(0));
    }
    //if (J1_Seg_Opt_Ativo_Sim.Value == true) {
    if (document.getElementById('J1_Seg_Opt_Ativo_Sim').checked) {
        soma = soma + 1;
        if (document.getElementById('Text_J1_Seg_LARG_ROLO').value != "")
 		    Tot_Larg_Rolos_Ativos = Tot_Larg_Rolos_Ativos + Number(Number(document.getElementById('Text_J1_Seg_LARG_ROLO').value).toFixed(0));
    }
    //if (J2_Seg_Opt_Ativo_Sim.Value == true) {
    if (document.getElementById('J2_Seg_Opt_Ativo_Sim').checked) {
        soma = soma + 1;
        if (document.getElementById('Text_J2_Seg_LARG_ROLO').value != "")
		   Tot_Larg_Rolos_Ativos = Tot_Larg_Rolos_Ativos + Number(Number(document.getElementById('Text_J2_Seg_LARG_ROLO').value).toFixed(0));
    }
    //document.getElementById('Lbl_Tot_Rolos').innerHtml = soma;
    $('#Lbl_Tot_Rolos_2').text(soma);
    $('#Lbl_Larg_Produzir_Hot').text(Tot_Larg_Rolos_Ativos);
    if (document.getElementById('LBL_Larg_Bob_Fornec').value != "") {
        Larg_Bob_Fornec = document.getElementById('LBL_Larg_Bob_Fornec').value;
        Resto_Bobina = (Larg_Bob_Fornec * 1000) - Tot_Larg_Rolos_Ativos;
    }
    
    $('#Lbl_Resto_Bobina').text(Resto_Bobina);
    
    Chk_J2_Prim = 0;
    //if (ChkBox_J1_Prim_J2_Prim.Value == True || ChkBox_J1_Prim_Todos.Value == true) {
    //if (ChkBox_J1_Prim_J2_Prim.Value == True || ChkBox_J1_Prim_Todos.Value == true) {
    if (document.getElementById('ChkBox_J1_Prim_J2_Prim').checked || document.getElementById('ChkBox_J1_Prim_Todos').checked) {
        //if (Opt_Puxar_J1.Value == true && Opt_N_Puxar_J1.Value == false)
        if (document.getElementById('Opt_Puxar_J1').checked && document.getElementById('Opt_N_Puxar_J1').checked)
            Chk_J2_Prim = 4;
        else {
            Chk_J2_Prim = Chk_J2_Prim + 1;
            if (document.getElementById('Text_J2_Prim_LARG_ROLO').value != "")
			   Chk_J2_Prim = Chk_J2_Prim + 1;
            if (document.getElementById('Text_J2_Prim_PUXADA').value != "")
			    Chk_J2_Prim = Chk_J2_Prim + 1;
            if (document.getElementById('Text_J2_Prim_TOT_BAT').value != "")
 			    Chk_J2_Prim = Chk_J2_Prim + 1;
        }
	}	
    else {
	     //if (ChkBox_J1_Prim_Nenhum.Value == true || ChkBox_J1_Prim_J1_Seg.Value == true)
	     //if ($("input[type='radio'][name='ChkBox_J1_Prim_Nenhum']:checked") 
         //     || $("input[type='radio'][name='ChkBox_J1_Prim_J1_Seg']:checked"))
	     if (document.getElementById('ChkBox_J1_Prim_Nenhum').checked 
              || document.getElementById('ChkBox_J1_Prim_J1_Seg').checked)
            Chk_J2_Prim = 4;
         else
            Chk_J2_Prim = 0;
    }
    
    if (document.getElementById('Text_Total_Folhas').value != "")
   	   Var1 = 0;
    if (document.getElementById('LBL_Larg_Bob_Fornec').value != "")
	   Var2 = 0;
    if ($('#Lbl_Tot_Rolos_2').text() != "")
 	   Var3 = 0;
    if ($('#Lbl_Larg_Produzir_Hot').text != "")
       Var4 = 0;
    if (Chk_J2_Prim == 4)
 	   Var5 = 0;
//'   If Opt_Rolo.Value = True Or Opt_Bobina.Value = True Then Var6 = 0
    
    Total = Var1 + Var2 + Var3 + Var4 + Var5;
    if (Total == 0) 
        document.getElementById('Btn_Calcular').disabled = false;
    else
        document.getElementById('Btn_Calcular').disabled = true;
}

function Btn_Atualiza_Tot_Rolos_Enter() {
    document.getElementById('Btn_Atualiza_Tot_Rolos').style.backgroundColor = 'green';
}
function Btn_Atualiza_Tot_Rolos_Exit() {
    document.getElementById('Btn_Atualiza_Tot_Rolos').style.backgroundColor = 'white';
} 


function Opcao_Calcular() {
    let Var_Resto_Bobina;
    let Var_Larg_Produzir_Hot;
    let Var_Tot_Rolos_2;
    let Var_Resultado;
    let Var_Opc_Bobina;
    let Var_Opc_Rolo;
    
    Var_Opc_Bobina = "CALCULADO PELA LARG DA BOBINA DO FORNECEDOR";
    Var_Opc_Rolo = "CALCULADO PELA LARG DO(S) ROLO(S) A PRODUZIR";
    
    Var_Resto_Bobina = Number($('#Lbl_Resto_Bobina').text());
    Var_Larg_Produzir_Hot = Number($('#Lbl_Larg_Produzir_Hot').text());
    Var_Tot_Rolos_2 = Number($('#Lbl_Tot_Rolos_2').text());
    Var_Resultado = Var_Larg_Produzir_Hot / Var_Tot_Rolos_2;
        
    $('#Lbl_Opcao_Calculo').text('')//;Empty
    
    if (Var_Resto_Bobina == 0) {
        Opcao_Rolo = true;
        Opcao_Bobina = false;
    }		
    else if (Var_Resto_Bobina >= Var_Resultado) {
        Opcao_Rolo = false;
        Opcao_Bobina = true;
	}	
    else if (Var_Resto_Bobina < Var_Resultado) {
        Opcao_Rolo = false;
        Opcao_Bobina = true;
    }
    if (Opcao_Bobina == true)
	    $('#Lbl_Opcao_Calculo').text(Var_Opc_Bobina);
    if (Opcao_Rolo == true) 
	   $('#Lbl_Opcao_Calculo').text(Var_Opc_Rolo);
    Larg_mm_Bob_Fornec = Larg_Bob_Fornec * 1000;
    Total_Rolos = Number(Number($('#Lbl_Tot_Rolos_2').text()).toFixed(0));
}

function BTN_CALCULAR_Click() {
    Limpar_Var_Res();
    Btn_Atualiza_Tot_Rolos_Click();
    Opcao_Calcular();
    Resultado_A();
    Resultado_B();
    Resultado_C();
    Resultado_D();
}
function Btn_Calcular_Enter() {
    document.getElementById('Btn_Calcular').style.backgroundColor = 'green';
}

function Btn_Calcular_Exit() {
    document.getElementById('Btn_Calcular').style.backgroundColor = 'white';
}


function Btn_Novo_Calc_Click() {
    NovoCalculo();
    document.getElementById('Text_Total_Folhas').focus();
}
function ChkBox_J1_Prim_Nenhum_Click() {
    Checar_J1_Nenhum();
    Btn_Atualiza_Tot_Rolos_Click();
}
function ChkBox_J1_Prim_J1_Seg_Click() {
    Checar_J1_J1_Seg();
    Limpar_Campos_J2_Prim();
    Limpar_Campos_J2_Seg();
    document.getElementById('Frame_Puxar_J1').disabled = true;
    document.getElementById('Opt_Puxar_J1').checked = false;
    document.getElementById('Opt_N_Puxar_J1').checked = false;
    Btn_Atualiza_Tot_Rolos_Click();
}
function ChkBox_J1_Prim_J2_Prim_Click() {
    Checar_J2_Prim();
    Btn_Atualiza_Tot_Rolos_Click();
}
function ChkBox_J1_Prim_Todos_Click() {
    Checar_J1_Todos();
    Btn_Atualiza_Tot_Rolos_Click();
}

function Checar_J1_Nenhum() {
    //if (ChkBox_J1_Prim_Nenhum.Value == true) {
    //if ($("input[type='radio'][name='ChkBox_J1_Prim_Nenhum']:checked")) {
    if (document.getElementById('ChkBox_J1_Prim_Nenhum').checked) {
        //ChkBox_J1_Prim_Nenhum.Value = True
        //ChkBox_J1_Prim_J2_Prim.Value = False
        //ChkBox_J1_Prim_J1_Seg.Value = False
        //ChkBox_J1_Prim_Todos.Value = False
        
        document.getElementById('J2_Prim_Opt_Ativo_Sim').checked = true;
        document.getElementById('J2_Prim_Opt_Ativo_Nao').checked = false;
        
        Desabilita_J1_Espelho();
        Desabilita_J2_Principal();
        Desabilita_J2_Espelho();
        Limpar_Campos_J2_Prim();
        Limpar_Campos_J1_Seg();
        Limpar_Campos_J2_Seg();
        //Frame2.Enabled = False
        //Frame3.Enabled = False
        //Frame4.Enabled = False
        document.getElementById('Frame_Puxar_J1').style.display = 'none';
        document.getElementById('Opt_Puxar_J1').checked = false;
        document.getElementById('Opt_N_Puxar_J1').checked = false;
        
    }
}

function Checar_J2_Prim() {
    //If ChkBox_J1_Prim_J2_Prim.Value = True Then
    //if ($("input[type='radio'][name='ChkBox_J1_Prim_J2_Prim']:checked")) {
    if (document.getElementById('ChkBox_J1_Prim_J2_Prim').checked) {
        //ChkBox_J1_Prim_Nenhum.Value = False
        //ChkBox_J1_Prim_J1_Seg.Value = False
        //ChkBox_J1_Prim_J2_Prim.Value = True
        //ChkBox_J1_Prim_Todos.Value = False
        
        document.getElementById('J1_Seg_Opt_Ativo_Sim').checked = true;
        document.getElementById('J1_Seg_Opt_Ativo_Nao').checked = false;
        
        Limpar_Campos_J2_Prim();
        
        document.getElementById('J2_Prim_Opt_Ativo_Sim').checked = true;
        document.getElementById('J2_Prim_Opt_Ativo_Nao').checked = false;
        
        //Frame_JOB1_Seg.Enabled = True
        document.getElementById('Text_J1_Seg_LARG_ROLO').disabled = false;
        document.getElementById('Text_J1_Seg_Puxada_Limpeza').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_CURTA').disabled = true;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_LONGA').disabled = true;
        document.getElementById('Text_J1_Seg_PUXADA').disabled = true;
        document.getElementById('Text_J1_Seg_TOT_BAT').disabled = true;
        
        //Frame_JOB2_Prim.Enabled = True
        document.getElementById('Text_J2_Prim_LARG_ROLO').disabled = false;
        document.getElementById('Text_J2_Prim_Puxada_Limpeza').disabled = false;
        document.getElementById('Text_J2_Prim_BAT_CURTA').disabled = false;
        document.getElementById('Text_J2_Prim_N_BAT_CURTA').disabled = false;
        document.getElementById('Text_J2_Prim_BAT_CURTA_2').disabled = false;
        document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').disabled = false;
        document.getElementById('Text_J2_Prim_BAT_LONGA').disabled = false;
        document.getElementById('Text_J2_Prim_PUXADA').disabled = false;
        document.getElementById('Text_J2_Prim_TOT_BAT').disabled = false;
        
        document.getElementById('Frame_Puxar_J1').style.display = 'block';
        //document.getElementById('Opt_Puxar_J1').style.display = 'block';
        //document.getElementById('Opt_N_Puxar_J1').style.display = 'block';
        document.getElementById('Opt_Puxar_J1').disabled = false;
        document.getElementById('Opt_N_Puxar_J1').disabled = false;
        document.getElementById('Opt_Puxar_J1').checked = false;
        document.getElementById('Opt_N_Puxar_J1').checked = false;
        
        //Frame2.Enabled = False
        //Frame3.Enabled = False
        //Frame4.Enabled = False
        
        document.getElementById('Text_J1_Seg_LARG_ROLO').value = document.getElementById('Text_J1_Prim_LARG_ROLO').value;
        document.getElementById('Text_J1_Seg_Puxada_Limpeza').value = document.getElementById('Text_J1_Prim_Puxada_Limpeza').value;
        document.getElementById('Text_J1_Seg_BAT_CURTA').value = document.getElementById('Text_J1_Prim_BAT_CURTA').value;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA').value;
        document.getElementById('Text_J1_Seg_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_BAT_CURTA_2').value;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').value;
        document.getElementById('Text_J1_Seg_BAT_LONGA').value = document.getElementById('Text_J1_Prim_BAT_LONGA').value;
        document.getElementById('Text_J1_Seg_PUXADA').value = document.getElementById('Text_J1_Prim_PUXADA').value;
        document.getElementById('Text_J1_Seg_TOT_BAT').value = document.getElementById('Text_J1_Prim_TOT_BAT').value;
        
        Desabilita_J2_Espelho();
        Limpar_Campos_J2_Seg();
        
    }
}

function Checar_J1_J1_Seg() {
    //if (ChkBox_J1_Prim_J1_Seg.Value == true) {
    //if ($("input[type='radio'][name='ChkBox_J1_Prim_J1_Seg']:checked")) {
    if (document.getElementById('ChkBox_J1_Prim_J1_Seg').checked) {
        //ChkBox_J1_Prim_Nenhum.Value = False
        //ChkBox_J1_Prim_J1_Seg.Value = True
        //ChkBox_J1_Prim_J2_Prim.Value = False
        //ChkBox_J1_Prim_Todos.Value = False
        document.getElementById('J1_Seg_Opt_Ativo_Sim').checked = true;
        document.getElementById('J1_Seg_Opt_Ativo_Nao').checked = false;
        
        //Frame_JOB1_Seg.Enabled = True
        document.getElementById('Text_J1_Seg_LARG_ROLO').disabled = false;
        document.getElementById('Text_J1_Seg_Puxada_Limpeza').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_CURTA').disabled = true;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_LONGA').disabled = true;
        document.getElementById('Text_J1_Seg_PUXADA').disabled = true;
        document.getElementById('Text_J1_Seg_TOT_BAT').disabled = true;
        
        //Frame2.Enabled = False
        //Frame3.Enabled = False
        //Frame4.Enabled = False
        
        Desabilita_J2_Principal();
        Desabilita_J2_Espelho();
        
        document.getElementById('Text_J1_Seg_LARG_ROLO').value = document.getElementById('Text_J1_Prim_LARG_ROLO').value;
        document.getElementById('Text_J1_Seg_Puxada_Limpeza').value = document.getElementById('Text_J1_Prim_Puxada_Limpeza').value;
        document.getElementById('Text_J1_Seg_BAT_CURTA').value = document.getElementById('Text_J1_Prim_BAT_CURTA').value;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA').value;
        document.getElementById('Text_J1_Seg_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_BAT_CURTA_2').value;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').value;
        document.getElementById('Text_J1_Seg_BAT_LONGA').value = document.getElementById('Text_J1_Prim_BAT_LONGA').value;
        document.getElementById('Text_J1_Seg_PUXADA').value = document.getElementById('Text_J1_Prim_PUXADA').value;
        document.getElementById('Text_J1_Seg_TOT_BAT').value = document.getElementById('Text_J1_Prim_TOT_BAT').value;
    }
}

function Checar_J1_Todos() {
    //if (ChkBox_J1_Prim_Todos.Value == true) {
    //if ($("input[type='radio'][name='ChkBox_J1_Prim_Todos']:checked")) {
    if (document.getElementById('ChkBox_J1_Prim_Todos').checked) {
        //ChkBox_J1_Prim_Todos.Value = True
        //ChkBox_J1_Prim_J2_Prim.Value = False
        //ChkBox_J1_Prim_Nenhum.Value = False
        //ChkBox_J1_Prim_J1_Seg.Value = False
      
        document.getElementById('J1_Seg_Opt_Ativo_Sim').checked = true;
        document.getElementById('J1_Seg_Opt_Ativo_Nao').checked = false;
        
        document.getElementById('J2_Prim_Opt_Ativo_Sim').checked = true;
        document.getElementById('J2_Prim_Opt_Ativo_Nao').checked = false;
        
        document.getElementById('J2_Seg_Opt_Ativo_Sim').checked = true;
        document.getElementById('J2_Seg_Opt_Ativo_Nao').checked = false;
        
        //Frame_JOB1_Seg.Enabled = True
        document.getElementById('Text_J1_Seg_LARG_ROLO').disabled = false;
        document.getElementById('Text_J1_Seg_Puxada_Limpeza').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_CURTA').disabled = true;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J1_Seg_BAT_LONGA').disabled = true;
        document.getElementById('Text_J1_Seg_PUXADA').disabled = true;
        document.getElementById('Text_J1_Seg_TOT_BAT').disabled = true;
        
        //Frame_JOB2_Prim.Enabled = True
        document.getElementById('Text_J2_Prim_LARG_ROLO').disabled = false;
        document.getElementById('Text_J2_Prim_Puxada_Limpeza').disabled = false;
        document.getElementById('Text_J2_Prim_BAT_CURTA').disabled = false;
        document.getElementById('Text_J2_Prim_N_BAT_CURTA').disabled = false;
        document.getElementById('Text_J2_Prim_BAT_CURTA_2').disabled = false;
        document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').disabled = false;
        document.getElementById('Text_J2_Prim_BAT_LONGA').disabled = false;
        document.getElementById('Text_J2_Prim_PUXADA').disabled = false;
        document.getElementById('Text_J2_Prim_TOT_BAT').disabled = false;
        
        //Frame_JOB2_Seg.Enabled = True
        document.getElementById('Text_J2_Seg_LARG_ROLO').disabled = false;
        document.getElementById('Text_J2_Seg_Puxada_Limpeza').disabled = true;
        document.getElementById('Text_J2_Seg_BAT_CURTA').disabled = true;
        document.getElementById('Text_J2_Seg_N_BAT_CURTA').disabled = true;
        document.getElementById('Text_J2_Seg_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').disabled = true;
        document.getElementById('Text_J2_Seg_BAT_LONGA').disabled = true;
        document.getElementById('Text_J2_Seg_PUXADA').disabledc= true;
        document.getElementById('Text_J2_Seg_TOT_BAT').disabled = true;
        
        document.getElementById('Text_J2_Prim_LARG_ROLO').value = '';
        document.getElementById('Text_J2_Seg_LARG_ROLO').value = '';
        document.getElementById('Text_J2_Prim_BAT_CURTA').value = '';
        document.getElementById('Text_J2_Seg_BAT_CURTA').value = '';
        document.getElementById('Text_J2_Prim_N_BAT_CURTA').value = '';
        document.getElementById('Text_J2_Seg_N_BAT_CURTA').value = '';
        document.getElementById('Text_J2_Prim_BAT_CURTA_2').value = '';
        document.getElementById('Text_J2_Seg_BAT_CURTA_2').value = '';
        document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value = '';
        document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').value = '';
        document.getElementById('Text_J2_Prim_BAT_LONGA').value = '';
        document.getElementById('Text_J2_Seg_BAT_LONGA').value = '';
        document.getElementById('Text_J2_Prim_PUXADA').value = '';
        document.getElementById('Text_J2_Seg_PUXADA').value = '';
        document.getElementById('Text_J2_Prim_TOT_BAT').value = '';
        document.getElementById('Text_J2_Seg_TOT_BAT').value = '';
        document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = '';
        document.getElementById('Text_J2_Seg_Puxada_Limpeza').value = '';
        
        //Frame_Puxar_J1.Visible = True
        document.getElementById('Frame_Puxar_J1').style.display = 'block';
        //document.getElementById('Opt_Puxar_J1').style.display = 'block';
        //document.getElementById('Opt_N_Puxar_J1').style.display = 'block';
        document.getElementById('Opt_Puxar_J1').disabled = false;
        document.getElementById('Opt_N_Puxar_J1').disabled = false;
        document.getElementById('Opt_Puxar_J1').checked = false;
        document.getElementById('Opt_N_Puxar_J1').checked = false;
        
        //Frame2.Enabled = False
        //Frame3.Enabled = False
        //Frame4.Enabled = False
        
        document.getElementById('Text_J1_Seg_LARG_ROLO').value = document.getElementById('Text_J1_Prim_LARG_ROLO').value;
        document.getElementById('Text_J1_Seg_Puxada_Limpeza').value = document.getElementById('Text_J1_Prim_Puxada_Limpeza').value;
        document.getElementById('Text_J1_Seg_BAT_CURTA').value = document.getElementById('Text_J1_Prim_BAT_CURTA').value;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA').value;
        document.getElementById('Text_J1_Seg_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_BAT_CURTA_2').value;
        document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').value;
        document.getElementById('Text_J1_Seg_BAT_LONGA').value = document.getElementById('Text_J1_Prim_BAT_LONGA').value;
        document.getElementById('Text_J1_Seg_PUXADA').value = document.getElementById('Text_J1_Prim_PUXADA').value;
        document.getElementById('Text_J1_Seg_TOT_BAT').value = document.getElementById('Text_J1_Prim_TOT_BAT').value;
    }
}

function Opt_Puxar_J1_Click() {
    //If ChkBox_J1_Prim_Nenhum.Value = False And _
    //if ($("input[type='radio'][name='ChkBox_J1_Prim_J2_Prim']:checked")) {
    if (document.getElementById('ChkBox_J1_Prim_J2_Prim').checked) {
        //ChkBox_J1_Prim_J1_Seg.Value = False And _
        //ChkBox_J1_Prim_J2_Prim.Value = True And _
        //ChkBox_J1_Prim_Todos.Value = False Then
        //if  (Opt_Puxar_J1.Value == true) {
        //if  (Opt_Puxar_J1.Value == true) {
        //if ($("input[type='radio'][name='Opt_Puxar_J1']:checked")) {
        if (document.getElementById('Opt_Puxar_J1').checked) {
            document.getElementById('Text_J2_Seg_LARG_ROLO').disabled = false;
            document.getElementById('Text_J2_Prim_LARG_ROLO').disabled = false;
            document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = document.getElementById('Text_J1_Prim_Puxada_Limpeza').value;
            document.getElementById('Text_J2_Prim_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_BAT_CURTA_2').value;
            document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').value;
            document.getElementById('Text_J2_Prim_BAT_LONGA').value = document.getElementById('Text_J1_Prim_BAT_LONGA').value;
            document.getElementById('Text_J2_Prim_BAT_CURTA').value = document.getElementById('Text_J1_Prim_BAT_CURTA').value;
            document.getElementById('Text_J2_Prim_N_BAT_CURTA').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA').value;
            document.getElementById('Text_J2_Prim_PUXADA').value = document.getElementById('Text_J1_Prim_PUXADA').value;
            document.getElementById('Text_J2_Prim_TOT_BAT').value = document.getElementById('Text_J1_Prim_TOT_BAT').value;
            document.getElementById('Text_J2_Prim_LARG_ROLO').value = document.getElementById('Text_J1_Prim_LARG_ROLO').value;
		}	
        else {
            document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = '';
            document.getElementById('Text_J2_Prim_BAT_CURTA_2').value = '';
            document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value = '';
            document.getElementById('Text_J2_Prim_BAT_LONGA').value = '';
            document.getElementById('Text_J2_Prim_BAT_CURTA').value = '';
            document.getElementById('Text_J2_Prim_N_BAT_CURTA').value = '';
            document.getElementById('Text_J2_Prim_PUXADA').value = '';
            document.getElementById('Text_J2_Prim_TOT_BAT').value = '';
            document.getElementById('Text_J2_Prim_LARG_ROLO').value = '';
        }
	}	
    //else if (ChkBox_J1_Prim_Nenhum.Value = False And _
    //        ChkBox_J1_Prim_J1_Seg.Value = False And _
    //        ChkBox_J1_Prim_J2_Prim.Value = False And _
    //        ChkBox_J1_Prim_Todos.Value = True Then
    //else if ($("input[type='radio'][name='ChkBox_J1_Prim_Todos']:checked")) {
    else if (document.getElementById('ChkBox_J1_Prim_Todos').checked) {
            document.getElementById('Text_J2_Seg_LARG_ROLO').disabled = false;
            document.getElementById('Text_J2_Prim_LARG_ROLO').disabled = false;
            document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = document.getElementById('Text_J1_Prim_Puxada_Limpeza').value;
            document.getElementById('Text_J2_Prim_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_BAT_CURTA_2').value;
            document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').value;
            document.getElementById('Text_J2_Prim_BAT_LONGA').value = document.getElementById('Text_J1_Prim_BAT_LONGA').value;
            document.getElementById('Text_J2_Prim_BAT_CURTA').value = document.getElementById('Text_J1_Prim_BAT_CURTA').value;
            document.getElementById('Text_J2_Prim_N_BAT_CURTA').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA').value;
            document.getElementById('Text_J2_Prim_PUXADA').value = document.getElementById('Text_J1_Prim_PUXADA').value;
            document.getElementById('Text_J2_Prim_TOT_BAT').value = document.getElementById('Text_J1_Prim_TOT_BAT').value;
            document.getElementById('Text_J2_Prim_LARG_ROLO').value = document.getElementById('Text_J1_Prim_LARG_ROLO').value;
            
            document.getElementById('Text_J2_Seg_Puxada_Limpeza').value = document.getElementById('Text_J2_Prim_Puxada_Limpeza').value;
            document.getElementById('Text_J2_Seg_BAT_CURTA_2').value = document.getElementById('Text_J2_Prim_BAT_CURTA_2').value;
            document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').value = document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value;
            document.getElementById('Text_J2_Seg_BAT_LONGA').value = document.getElementById('Text_J2_Prim_BAT_LONGA').value;
            document.getElementById('Text_J2_Seg_BAT_CURTA').value = document.getElementById('Text_J2_Prim_BAT_CURTA').value;
            document.getElementById('Text_J2_Seg_N_BAT_CURTA').value = document.getElementById('Text_J2_Prim_N_BAT_CURTA').value;
            document.getElementById('Text_J2_Seg_PUXADA').value = document.getElementById('Text_J2_Prim_PUXADA').value;
            document.getElementById('Text_J2_Seg_TOT_BAT').value = document.getElementById('Text_J2_Prim_TOT_BAT').value;
            document.getElementById('Text_J2_Seg_LARG_ROLO').value = document.getElementById('Text_J2_Prim_LARG_ROLO').value
    }
}

function Opt_N_Puxar_J1_Click() {
    //if (Opt_N_Puxar_J1.Value == true) {
    //if ($("input[type='radio'][name='Opt_N_Puxar_J1']:checked")) {
    if (document.getElementById('Opt_N_Puxar_J1').checked) {
        document.getElementById('Text_J2_Prim_LARG_ROLO').value = '';
        document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = '';
        document.getElementById('Text_J2_Prim_BAT_CURTA').value = '';
        document.getElementById('Text_J2_Prim_N_BAT_CURTA').value = '';
        document.getElementById('Text_J2_Prim_BAT_CURTA_2').value = '';
        document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value = '';
        document.getElementById('Text_J2_Prim_BAT_LONGA').value = '';
        document.getElementById('Text_J2_Prim_PUXADA').value = '';
        document.getElementById('Text_J2_Prim_TOT_BAT').value = '';
        document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = '';
        Limpar_Campos_J2_Seg();
        //If ChkBox_J1_Prim_Nenhum.Value = False And _
        //    ChkBox_J1_Prim_J1_Seg.Value = False And _
        //    ChkBox_J1_Prim_J2_Prim.Value = True And _
        //    ChkBox_J1_Prim_Todos.Value = False Then
        //if ($("input[type='radio'][name='ChkBox_J1_Prim_J2_Prim']:checked")) {
        if (document.getElementById('ChkBox_J1_Prim_J2_Prim').checked) {
            document.getElementById('J2_Seg_Opt_Ativo_Sim').checked = false;
            document.getElementById('J2_Seg_Opt_Ativo_Nao').checked = true;
        //ElseIf ChkBox_J1_Prim_Nenhum.Value = False And _
        //    ChkBox_J1_Prim_J1_Seg.Value = False And _
        //    ChkBox_J1_Prim_J2_Prim.Value = False And _
        //    ChkBox_J1_Prim_Todos.Value = True Then
		}
        //else if ($("input[type='radio'][name='ChkBox_J1_Prim_Todos']:checked")) {
        else if (document.getElementById('ChkBox_J1_Prim_Todos').checked) {

            document.getElementById('J2_Seg_Opt_Ativo_Sim').checked = true;
            document.getElementById('J2_Seg_Opt_Ativo_Nao').checked = false;
            
            document.getElementById('Text_J2_Seg_Puxada_Limpeza').disabled = true;
            document.getElementById('Text_J2_Seg_BAT_CURTA').disabled = true;
            document.getElementById('Text_J2_Seg_N_BAT_CURTA').disabled = true;
            document.getElementById('Text_J2_Seg_BAT_CURTA_2').disabled = true;
            document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').disabled = true;
            document.getElementById('Text_J2_Seg_BAT_LONGA').disabled = true;
            document.getElementById('Text_J2_Seg_PUXADA').disabled = true;
            document.getElementById('Text_J2_Seg_TOT_BAT').disabled = true;
            
        }
	}	
    else {
        document.getElementById('Text_J2_Prim_LARG_ROLO').value = document.getElementById('Text_J1_Prim_LARG_ROLO').value;
        document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = document.getElementById('Text_J1_Prim_Puxada_Limpeza').value;
        document.getElementById('Text_J2_Prim_BAT_CURTA').value = document.getElementById('Text_J1_Prim_BAT_CURTA').value;
        document.getElementById('Text_J2_Prim_N_BAT_CURTA').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA').value;
        document.getElementById('Text_J2_Prim_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_BAT_CURTA_2').value;
        document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value = document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').value;
        document.getElementById('Text_J2_Prim_BAT_LONGA').value = document.getElementById('Text_J1_Prim_BAT_LONGA').value;
        document.getElementById('Text_J2_Prim_PUXADA').value = document.getElementById('Text_J1_Prim_PUXADA').value;
        document.getElementById('Text_J2_Prim_TOT_BAT').value = document.getElementById('Text_J1_Prim_TOT_BAT').value;
    }
}

function J1_Prim_Opt_Ativo_Sim_Click() {
    Habilita_J1_Principal();
}
function J1_Prim_Opt_Ativo_Nao_Click() {
    Desabilita_J1_Principal();
}
function J1_Seg_Opt_Ativo_Sim_Click() {
    Habilita_J1_Espelho();
}
function J1_Seg_Opt_Ativo_Nao_Click() {
    Desabilita_J1_Espelho();
}
function J2_Prim_Opt_Ativo_Sim_Click() {
    Habilita_J2_Principal();
}
function J2_Prim_Opt_Ativo_Nao_Click() {
    Desabilita_J2_Principal();
}
function J2_Seg_Opt_Ativo_Sim_Click() {
    Habilita_J2_Espelho();
}
function J2_Seg_Opt_Ativo_Nao_Click() {
    Desabilita_J2_Espelho();
}
function Btn_Limpar_JOB1_Prim_Click() {
    Intervalo_Puxada = 0;
    Limpar_Campos_J1_Prim();
    Limpar_Campos_J1_Seg();
}
function Btn_Limpar_JOB1_Seg_Click() {
    Intervalo_Puxada = 0;
    Limpar_Campos_J2_Prim();
}
function Btn_Limpar_JOB2_Prim_Click() {
    Intervalo_Puxada = 0;
    Limpar_Campos_J2_Prim();
    document.getElementById('Opt_N_Puxar_J1').checked = true;
    document.getElementById('Opt_Puxar_J1').checked = false;
}
function Btn_Limpar_JOB2_Seg_Click() {
    Intervalo_Puxada = 0;
    Limpar_Campos_J2_Seg();
}
function Text_J1_Prim_Puxada_Limpeza_Change() {
    let Var_Puxada_Total;
    if (document.getElementById('Text_J1_Prim_BAT_LONGA').value != "") {
        Intervalo_Puxada = 5;
        Var_Puxada_Total = Number(Number(document.getElementById('Text_J1_Prim_BAT_LONGA').value).toFixed(0));
        document.getElementById('Text_J1_Prim_Puxada_Limpeza').value = Var_Puxada_Total + Intervalo_Puxada;
        Intervalo_Puxada = 0;
	}	
    else {
        Intervalo_Puxada = 0;
    }
}

function Text_J1_Prim_PUXADA_Enter() {
    Text_J1_Prim_PUXADA_Change()
}

function Text_J1_Prim_PUXADA_Change() {
    let Var_Puxada_Total;
    let Var_Num_Batidas_Curtas;
    let Var_Batida_Curta;
    if (document.getElementById('Text_J1_Prim_BAT_LONGA').value != "")
  	    Var_Puxada_Total = Number(Number(document.getElementById('Text_J1_Prim_BAT_LONGA').value).toFixed(0));
    if (document.getElementById('Text_J1_Prim_N_BAT_CURTA').value != "")
 	   Var_Num_Batidas_Curtas = Number(Number(document.getElementById('Text_J1_Prim_N_BAT_CURTA').value).toFixed(0));
    if (document.getElementById('Text_J1_Prim_BAT_CURTA').value != "")
	   Var_Batida_Curta = Number(Number(document.getElementById('Text_J1_Prim_BAT_CURTA').value).toFixed(0));
    if (Var_Puxada_Total != 0 && Var_Batida_Curta != 0 && Var_Num_Batidas_Curtas == 0 && Var_Puxada_Total == Var_Batida_Curta)
        Text_J1_Prim_PUXADA.Text = Var_Puxada_Total;
    else if (Var_Puxada_Total + (Var_Num_Batidas_Curtas * Var_Batida_Curta) == 0) 
        document.getElementById('Text_J1_Prim_PUXADA').value = '';
    else
        document.getElementById('Text_J1_Prim_PUXADA').value = Var_Puxada_Total + (Var_Num_Batidas_Curtas * Var_Batida_Curta);
    
//'   If Text_J1_Prim_PUXADA.Text = "" Then Exit Sub
}
function Text_J1_Prim_TOT_BAT_Change() {
    let Var_Num_Batidas_Curtas;
    if (document.getElementById('Text_J1_Prim_N_BAT_CURTA').value != "")
  	    Var_Num_Batidas_Curtas = Number(Number(document.getElementById('Text_J1_Prim_N_BAT_CURTA').value).toFixed(0));
    if (document.getElementById('Text_J1_Prim_N_BAT_CURTA').value != "")
  	    document.getElementById('Text_J1_Prim_TOT_BAT').value = (Var_Num_Batidas_Curtas + 1);
}

function Text_J2_Prim_Puxada_Limpeza_Change() {
    let Var_Puxada_Total =0.0;
    if (document.getElementById('Text_J2_Prim_BAT_LONGA').value != "") {
        Intervalo_Puxada = 5;
        Var_Puxada_Total = Number(Number(document.getElementById('Text_J2_Prim_BAT_LONGA').value).toFixed(0));
        document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = Var_Puxada_Total + Intervalo_Puxada;
        Intervalo_Puxada = 0;
	}	
    else {
        Intervalo_Puxada = 0;
    }
}
function Text_J2_Prim_PUXADA_Change() {
    let Var_Puxada_Total = 0.0;
    let Var_Num_Batidas_Curtas =0.0;
    let Var_Batida_Curta = 0.0;
    if (document.getElementById('Text_J2_Prim_BAT_LONGA').value != "")
 	   Var_Puxada_Total = Number(Number(document.getElementById('Text_J2_Prim_BAT_LONGA').value).toFixed(0));
    if (document.getElementById('Text_J2_Prim_N_BAT_CURTA').value != "")
	   Var_Num_Batidas_Curtas = Number(Number(document.getElementById('Text_J2_Prim_N_BAT_CURTA').value).toFixed(0));
    if (document.getElementById('Text_J2_Prim_BAT_CURTA').value != "")
	    Var_Batida_Curta = Number(Number(document.getElementById('Text_J2_Prim_BAT_CURTA').value).toFixed(0));
    if (Var_Puxada_Total != 0 && Var_Batida_Curta != 0 && Var_Num_Batidas_Curtas != 0 && Var_Puxada_Total == Var_Batida_Curta)
        document.getElementById('Text_J2_Prim_PUXADA').value = Var_Puxada_Total;
    else if (Var_Puxada_Total + (Var_Num_Batidas_Curtas * Var_Batida_Curta) == 0)
        document.getElementById('Text_J2_Prim_PUXADA').value = '';
    else
        document.getElementById('Text_J2_Prim_PUXADA').value = Var_Puxada_Total + (Var_Num_Batidas_Curtas * Var_Batida_Curta);
//'   If Text_J2_Prim_PUXADA.Text = "" Then Exit Sub
}
function Text_J2_Prim_TOT_BAT_Change() {
    let Var_Num_Batidas_Curtas = 0.0;
    if (document.getElementById('Text_J2_Prim_N_BAT_CURTA').value != "")
	   Var_Num_Batidas_Curtas = Number(Number(document.getElementById('Text_J2_Prim_N_BAT_CURTA').value).toFixed(0));
    if (document.getElementById('Text_J2_Prim_N_BAT_CURTA').value != "")
	    document.getElementById('Text_J2_Prim_TOT_BAT').value = (Var_Num_Batidas_Curtas + 1);
}
function Frame_iNICIAL_Exit() {
    if (document.getElementById('Text_Total_Folhas').value != "" && document.getElementById('Text_Puxada_Longa').value != "") {
        document.getElementById('Text_J1_Prim_BAT_LONGA').value = document.getElementById('Text_Puxada_Longa').value;
        //Frame_Inicial.BackColor = &H80000003  'Tela cinza
        //Frame_Inicial.BorderColor = &HFFFFFF    'borda branca
        document.getElementById('Frame_Inicial').style['background-color'] = 'white';    //Tela vermelha
	}	
    else {
        //Frame_Inicial.BackColor = &HC0C0FF    'Tela vermelha
        //Frame_Inicial.BorderColor = &HFF&       'borda vermelha
        //if (document.getElementById('Text_Total_Folhas').value == "" || document.getElementById('Text_Total_Folhas').value == "0") { 
		//   document.getElementById('Text_Total_Folhas').focus();
        //   $('#txtmsg').text('TOTAL FOLHAS INVALIDO');
        //   dialogFMsg.dialog('open');
		//}    
        //if (document.getElementById('Text_Puxada_Longa').value == "" || document.getElementById('Text_Puxada_Longa').value == "0") { 
		//   document.getElementById('Text_Puxada_Longa').focus();
        //   $('#txtmsg').text('PUXADA LONGA INVALIDO');
        //   dialogFMsg.dialog('open');
		//}    
        if (document.getElementById('Text_Total_Folhas').value == "" || document.getElementById('Text_Total_Folhas').value == "0") { 
           document.getElementById('Frame_Inicial').style['background-color'] = 'red';    //Tela vermelha
		   document.getElementById('Text_Total_Folhas').focus();
           $('#txtmsg').text('TOTAL FOLHAS INVALIDO');
           dialogFMsg.dialog('open');
			
		}	
        else if (document.getElementById('Text_Puxada_Longa').value == "" || document.getElementById('Text_Puxada_Longa').value == "0") { 
		   document.getElementById('Text_Puxada_Longa').focus();
           $('#txtmsg').text('PUXADA LONGA INVALIDO');
           dialogFMsg.dialog('open');
		}
    }
    
    if (document.getElementById('Text_Puxada_Longa').value != "") 
        document.getElementById('Text_J1_Prim_BAT_LONGA').value = document.getElementById('Text_Puxada_Longa').value;
   
    //Text_Puxada_Longa.BackColor = &H80000005  ' BRANCO
    //Text_Total_Folhas.BackColor = &H80000005  ' BRANCO
}
function total_folhas_Exit() {
    if (document.getElementById('Text_Total_Folhas').value != "" && document.getElementById('Text_Total_Folhas').value != "0") {
        document.getElementById('Frame_Inicial').style['background-color'] = 'white';    //Tela vermelha
	}	
    else {
        if (document.getElementById('Text_Total_Folhas').value == "" || document.getElementById('Text_Total_Folhas').value == "0") { 
           document.getElementById('Frame_Inicial').style['background-color'] = 'red';    //Tela vermelha
		   //document.getElementById('Text_Total_Folhas').focus();
           //$('#txtmsg').text('TOTAL FOLHAS INVALIDO');
           //dialogFMsg.dialog('open');
		}	
    }
}
function puxada_longa_Exit() {
    if (document.getElementById('Text_Puxada_Longa').value != "" && document.getElementById('Text_Puxada_Longa').value != "0") {
        document.getElementById('Text_J1_Prim_BAT_LONGA').value = document.getElementById('Text_Puxada_Longa').value;
        //Frame_Inicial.BackColor = &H80000003  'Tela cinza
        //Frame_Inicial.BorderColor = &HFFFFFF    'borda branca
        document.getElementById('Frame_Inicial').style['background-color'] = 'white';    //Tela vermelha
        document.getElementById('Text_J1_Prim_BAT_LONGA').value = document.getElementById('Text_Puxada_Longa').value;
	}	
    else {
        if (document.getElementById('Text_Puxada_Longa').value == "" || document.getElementById('Text_Puxada_Longa').value == "0") { 
           document.getElementById('Frame_Inicial').style['background-color'] = 'red';    //Tela vermelha
		   //document.getElementById('Text_Puxada_Longa').focus();
           //$('#txtmsg').text('PUXADA LONGA INVALIDO');
           //dialogFMsg.dialog('open');
		}	
    }
}


</script>
</head>

<body>
<div class='header' id='top_header'>
 <p style='width:10vw;float:left;color:blue;'>Usuario:<?php echo $vusuario ?></p>

 <button type='button' id='btnTutorial'  title='Tutorial' style='width:8vw' onclick='tutorialon()'>Tutorial</button>
 <!--
 <button type='button' id='btnFornec'  title='Fornecedor' style='width:8vw' onclick='showCard()'>Fornecedor</button>
 <button type='button' id='btnHotStamping'  title='HotStamping' style='width:8vw' onclick='showHotStamping()'>HotStamping</button>
 -->
 <button type='button' id='btnExit'  title='SAIR' style='width:8vw;float:right;color:red;' onclick='fsair()'>Sair</button>
 
</div>
<div class='main'>
 <div class='div1'>
	  <fieldset style='width:12vw' id='Frame_Inicial' >
		   <label for='Text_Total_Folhas' style='font-size:0.8vw;font-weight:bold;'>Total de Folhas</label><br>
		   <input type='text' id='Text_Total_Folhas' class='decimal0' value='' style='font-weight:bold;' onkeydown='nextField(event,"Text_Puxada_Longa")' onfocusout='total_folhas_Exit()'></input><br> 
		   <label for='Text_Puxada_Longa' style='font-size:0.8vw;font-weight:bold;'>Puxada Longa</label><br>
		   <input type='text' id='Text_Puxada_Longa' class='decimal0' value='' style='font-weight:bold;' onchange='setPuxadaLonga()' onfocusout='puxada_longa_Exit()'></input> 
	  </fieldset>
 </div>	  
 <div class='div1a'>
      <p id='Lbl_Opcao_Calculo' style='font-size:0.6vw;color:maroon;width:10vw;font-weight:bold;'>CALCULADO PELA LARG DA BOBINA DO FORNECEDOR</p>
 </div>
 <div class='div2'> 
	  <button type='button' id='Btn_Atualiza_Tot_Rolos'  title='Atualize' style='width:6vw;font-weight:bold;background-color:white;' onclick='Btn_Atualiza_Tot_Rolos_Click()' onfocus='Btn_Atualiza_Tot_Rolos_Enter()' onfocusout='Btn_Atualiza_Tot_Rolos_Exit()'>Atualize</button>
	  <button type='button' id='Btn_Calcular'  title='Calcular' style='width:6vw;font-weight:bold;background-color:white;' onclick='BTN_CALCULAR_Click()' onfocus='Btn_Calcular_Enter()' onfocusout='Btn_Calcular_Exit()' disabled>Calcular</button>
	  <br><br>
	  <button type='button' id='Btn_Novo_Calc'  title='Novo' style='width:6vw;font-weight:bold;' onclick='Btn_Novo_Calc_Click()'>Novo</button>
 </div>

 <div class='div3'>
	  <fieldset style='width:15vw;height:8vw;font-size:0.8vw;'>
		<legend style='font-weight:bold;'>Fornecedor Hot Stamping</legend>
		 <table>
			<tr>
			  <td>
			   <select id='Cmb_Fornecedor' style='font-size:0.8vw;font-weight:bold;' onchange='selFornec()'>
			   </select>
			  </td>
			  <td>
			   <fieldset style='width:10vw;height:2vw;color:blue;'>
				 <legend style='font-weight:bold;'>Largura Bobina</legend>
				  <input type='radio' id='Opt_Normal' name='rlbobina' value='Normal' onclick='Opt_Normal_Click()'></input> 
				  <label for='Opt_Normal'>Normal</label>
				  <input type='radio' id='Opt_Duplo' name='rlbobina' value='Duplo' onclick='Opt_Duplo_Click()'></input> 
				  <label for='Opt_Duplo'>Duplo</label>
				</fieldset>
			  </td>
			</tr> 
		 </table>	
		 <table>
			<tr>
			  <th>Larg. Bobina</th>
			  <th>Min. Lineares</th>
			  <th>Max. mts Lineares</th> 		  
			</tr>
			<tr>
			  <td><input type='text' id='LBL_Larg_Bob_Fornec' class='decimal' style='font-weight:bold;color:red;width:8vw;' disabled></input></td> 
			  <td><input type='text' id='Lbl_Min_Lineares' class='decimal' style='font-weight:bold;color:red;width:8vw;' disabled></input></td> 
			  <td><input type='text' id='Lbl_Max_Lineares' class='decimal' style='font-weight:bold;color:red;width:8vw;' disabled></input></td> 
			</tr>
		 </table>
	  </fieldset>
 </div>
 <div class='div4'>	  
	  <fieldset style='height:10vw;font-size:0.8vw;color:red;'>
	  <legend>Resultados Parciais</legend>
	  <table>
	   <tr>
		 <th>1) mts(Lineares)</th>
		 <th>2) mts(Lineres)</th>
		 <th>(m2)</th>
	   </tr>
	   <tr>
		 <td><input type='text' id='Text_Res_A' class='decimal' disabled></input></td>   
		 <td><input type='text' id='Text_Res_C' class='decimal' disabled></input></td>   
		 <td><input type='text' id='Text_Res_B' class='decimal' disabled></input></td>   
	   </tr>
	  </table> 
	  <table style='color:black;>
		<tr>
		  <th colspan='5' ><span style='color:black;'>Resultado Final</span></th> 
		</tr>
		<tr>
		  <td>Total de</td>
		  <td><input type='text' id='Text_Res_D' class='decimal'></input></td>   
		  <td>Bobinas c/</td>
		  <td><input type='text' id='Text_Res_E' class='decimal'></input></td>   
		  <td>mts lineares</td>
		</tr>
	  </table>
	  <table border='0' style='color:black;'>
	   <tr>
		 <th>Tot (Lineares)</th>
		 <th>Total em m2</th>
		 <th></th>
	   </tr>
	   <tr>
		 <td><input type='text' id='Text_Res_G' class='decimal'></input></td>  
		 <td><input type='text' id='Text_Res_F' class='decimal'></input></td>  
		 <td id='Lbl_Min_Compra'>Minimo Compra!!!</td>  
	   </tr>
	  </table>
	  </fieldset>
 </div>
 
 <div class='div5'> 
  <table border='1' style='border-collapse: collapse;'>
    <tr>
      <td></td>
      <td>
 	   <fieldset> 
	    <legend>JOB1 Principal ATIVO?</legend>
	      <input type='radio' id='J1_Prim_Opt_Ativo_Sim' name='J1_Prim_Opt_Ativo' value='SIM' onclick='J1_Prim_Opt_Ativo_Sim_Click()'></input> 
		  <label for='J1_Prim_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J1_Prim_Opt_Ativo_Nao' name='J1_Prim_Opt_Ativo' value='NAO' onclick='J1_Prim_Opt_Ativo_Nao_Click()'></input> 
		  <label for='J1_Prim_Opt_Ativo_Nao'>NÃO</label>
	   </fieldset>
	  </td>
      <td>
	   <fieldset>
	    <legend>JOB1 Espelho ATIVO?</legend>
	      <input type='radio' id='J1_Seg_Opt_Ativo_Sim' name='J1_Seg_Opt_Ativo' value='SIM' onclick='J1_Seg_Opt_Ativo_Sim_Click()'></input> 
		  <label for='J1_Seg_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J1_Seg_Opt_Ativo_Nao' name='J1_Seg_Opt_Ativo' value='NAO' onclick='J1_Seg_Opt_Ativo_Nao_Click()'></input> 
		  <label for='J1_Seg_Opt_Ativo_Nao'>NÃO</label>
	   </fieldset>
	  </td>
      <td>
	   <fieldset>
	    <legend>JOB2 Principal ATIVO?</legend>
	      <input type='radio' id='J2_Prim_Opt_Ativo_Sim' name='J2_Prim_Opt_Ativo' value='SIM' onclick='J2_Prim_Opt_Ativo_Sim_Click()'></input> 
		  <label for='J2_Prim_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J2_Prim_Opt_Ativo_Nao' name='J2_Prim_Opt_Ativo' value='NAO' onclick='J2_Prim_Opt_Ativo_Nao_Click()'></input> 
		  <label for='J2_Prim_Opt_Ativo_Nao'>NÃO</label>
	   </fieldset>
	  </td>
      <td>
	   <fieldset>
	    <legend>JOB2 Espelho ATIVO?</legend>
	      <input type='radio' id='J2_Seg_Opt_Ativo_Sim' name='J2_Seg_Opt_Ativo' value='SIM' onclick='J2_Seg_Opt_Ativo_Sim_Click()'></input> 
		  <label for='J2_Seg_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J2_Seg_Opt_Ativo_Nao' name='J2_Seg_Opt_Ativo' value='NAO' onclick='J2_Seg_Opt_Ativo_Nao_Click()'></input> 
		  <label for='J2_Seg_Opt_Ativo_Nao'>NÃO</label>
	   </fieldset>
	  </td>
   
    </tr>
    <tr>
     <td></td>
     <td colspan='2' style='color:red;font-weight:bold;text-align:center;background-color:#81d4fa;'>JOB N.1</td>
     <td colspan='2' style='color:red;font-weight:bold;text-align:center;background-color:#ffcc80;' >JOB N.2</td>
    </tr>
    <tr>
     <td></td>
     <td style='color:red;font-weight:bold;text-align:center;background-color:#fff59d;'>Principal</td>
     <td style='color:red;font-weight:bold;text-align:center;background-color:#fff59d;'>Espelho</td>
     <td style='color:red;font-weight:bold;text-align:center;background-color:#fff59d;'>Principal</td>
     <td style='color:red;font-weight:bold;text-align:center;background-color:#fff59d;'>Espelho</td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>LARGURA DO ROLO:</span></td>
     <td><input type='text' id='Text_J1_Prim_LARG_ROLO' class='decimal' value='' style='background-color:red;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J1_Prim_Puxada_Limpeza")'></input></td>
     <td><input type='text' id='Text_J1_Seg_LARG_ROLO'  class='decimal' value='' style='background-color:red;color:white;font-weight:bold;' disabled></input></td>
     <td><input type='text' id='Text_J2_Prim_LARG_ROLO' class='decimal' value='' style='background-color:red;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J2_Prim_Puxada_Limpeza")'></input></td>
     <td><input type='text' id='Text_J2_Seg_LARG_ROLO' class='decimal' value=''  style='background-color:red;color:white;font-weight:bold;' disabled></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>Advance Pull:</span></td>
     <td><input type='text' id='Text_J1_Prim_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;' onfocus='Text_J1_Prim_Puxada_Limpeza_Change()' onkeydown='nextField(event,"Text_J1_Prim_BAT_CURTA")'></input></td>
     <td><input type='text' id='Text_J1_Seg_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;' onfocus='Text_J2_Prim_Puxada_Limpeza_Change()' onkeydown='nextField(event,"Text_J2_Prim_BAT_CURTA")'></input></td>
     <td><input type='text' id='Text_J2_Seg_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#1 Short Pull:</span></td>
     <td><input type='text' id='Text_J1_Prim_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J1_Prim_N_BAT_CURTA")'></input></td>
     <td><input type='text' id='Text_J1_Seg_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J2_Prim_N_BAT_CURTA")'></input></td>
     <td><input type='text' id='Text_J2_Seg_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#1 Short Pull No.:</span></td>
     <td><input type='text' id='Text_J1_Prim_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J1_Prim_BAT_CURTA_2")'></input></td>
     <td><input type='text' id='Text_J1_Seg_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J2_Prim_BAT_CURTA_2")'></input></td>
     <td><input type='text' id='Text_J2_Seg_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#2 Short Pull:</span></td>
     <td><input type='text' id='Text_J1_Prim_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;' onkeydown='nextField(event,"Text_J1_Prim_N_BAT_CURTA_2")'></input></td>
     <td><input type='text' id='Text_J1_Seg_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;' onkeydown='nextField(event,"Text_J2_Prim_N_BAT_CURTA_2")'></input></td>
     <td><input type='text' id='Text_J2_Seg_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#2 Short Pull No.:</span></td>
     <td><input type='text' id='Text_J1_Prim_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'  onkeydown='nextField(event,"Text_J1_Prim_BAT_LONGA")'></input></td>
     <td><input type='text' id='Text_J1_Seg_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;' onkeydown='nextField(event,"Text_J2_Prim_BAT_LONGA")' ></input></td>
     <td><input type='text' id='Text_J2_Seg_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>Long Pull:</span></td>
     <td><input type='text' id='Text_J1_Prim_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J1_Prim_PUXADA")'></input></td>
     <td><input type='text' id='Text_J1_Seg_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;' onkeydown='nextField(event,"Text_J2_Prim_PUXADA")'></input></td>
     <td><input type='text' id='Text_J2_Seg_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>PUXADA TOTAL:</span></td>
     <td><input type='text' id='Text_J1_Prim_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;' onfocus='Text_J1_Prim_PUXADA_Enter()' onkeydown='nextField(event,"Text_J1_Prim_TOT_BAT")'></input></td>
     <td><input type='text' id='Text_J1_Seg_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;' onfocus='Text_J2_Prim_PUXADA_Change()' onkeydown='nextField(event,"Text_J2_Prim_TOT_BAT")'></input></td>
     <td><input type='text' id='Text_J2_Seg_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>TOTAL DE BATIDAS:</span></td>
     <td><input type='text' id='Text_J1_Prim_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;' onfocus='Text_J1_Prim_TOT_BAT_Change()'></input></td>
     <td><input type='text' id='Text_J1_Seg_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;' onfocus='Text_J2_Prim_TOT_BAT_Change()'></input></td>
     <td><input type='text' id='Text_J2_Seg_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td></td>
     <td><button type='button' id='Btn_Limpar_JOB1_Prim'  style='width:8vw' onclick='Btn_Limpar_JOB1_Prim_Click()'>LIMPAR JOB1</button></td>
     <td><!--<button type='button' id='Btn_Limpar_JOB1_Seg'  style='width:8vw' onclick='Btn_Limpar_JOB1_Seg_Click()'>Limpar JOB1</button>--></td>
     <td><!--<button type='button' id='Btn_Limpar_JOB2_Prim'  style='width:8vw' onclick='Btn_Limpar_JOB2_Prim_Click()'>Limpar JOB2</button>--></td>
     <td><!--<button type='button' id='Btn_Limpar_JOB2_Seg'  style='width:8vw' onclick='Btn_Limpar_JOB2_Seg_Click()'>Limpar JOB2</button>--></td>
    </tr>
    <tr>
     <td></td>
	 <td>
       <input type='radio' id='ChkBox_J1_Prim_Nenhum' name='ChkBox_J1' value='1' onclick='ChkBox_J1_Prim_Nenhum_Click()'>
       <label for='ChkBox_J1_Prim_Nenhum'>Somente este</label><br>	 
       <input type='radio' id='ChkBox_J1_Prim_J1_Seg' name='ChkBox_J1' value='2' onclick='ChkBox_J1_Prim_J1_Seg_Click()'>
       <label for='ChkBox_J1_Prim_J1_Seg'>2 ROLOS</label><br>	 
       <input type='radio' id='ChkBox_J1_Prim_J2_Prim' name='ChkBox_J1' value='3' onclick='ChkBox_J1_Prim_J2_Prim_Click()'>
       <label for='ChkBox_J1_Prim_J2_Prim'>3 ROLOS</label><br>	 
       <input type='radio' id='ChkBox_J1_Prim_Todos' name='ChkBox_J1' value='4' onclick='ChkBox_J1_Prim_Todos_Click()'>
       <label for='ChkBox_J1_Prim_Todos'>4 ROLOS</label><br>	 
	 </td>
	 <td>
	   <!--
	   <p>DUPLICAR PARA</p><br>
       <input type='checkbox' id='ChkBox_J1_Seg_Nenhum' value='1'>
       <label for='ChkBox_J1_Seg_Nenhum'>Somente este</label><br>	 
       <input type='checkbox' id='ChkBox_J1_Seg_J2_Seg' value='2'>
       <label for='ChkBox_J1_Seg_J2_Seg'>2 ROLOS</label><br>	 
	   -->
	 </td>
	 <td>
	   <fieldset id='Frame_Puxar_J1'>
	    <header style='color:red;'>PUXAR AS INF. DO JOB1?</header>
        <input type='radio' id='Opt_Puxar_J1' name='Opt_Puxar' value='SIM' onclick='Opt_Puxar_J1_Click()'></input> 
		<label for='Opt_Puxar_J1'>SIM</label>
		<input type='radio' id='Opt_N_Puxar_J1' name='Opt_Puxar' value='NAO' onclick='Opt_N_Puxar_J1_Click()'></input> 
		<label for='Opt_N_Puxar_J1'>NÃO</label>
	   </fieldset>
	 </td>
	 <td>
	 </td>
    </tr>
	<tr>
	<td colspan='5'>
	   <fieldset>
		 <p style='font-size:0.8vw;'>A soma de <span id='Lbl_Tot_Rolos_2'>9999</span> rolo(s) = <span id='Lbl_Larg_Produzir_Hot'>9999</span> mm restando...<span id='Lbl_Resto_Bobina' style='color:red;'>9999</span>mm na Bob do Fornecedor</p>  
		 <p id='Lbl_Msg_1' style='font-size:0.8vw;'>xxxxxx</p>
		 <p id='Lbl_Msg_2' style='font-size:0.8vw;'>xxxxxx</p>
		 <p id='Lbl_Msg_3' style='font-size:0.8vw;'>xxxxxx</p>
	   </fieldset>   
	</td>
	</tr>
  </table>
 </div>
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
 <div id='dialog-message' title='Message'>
    <p id='txtmsg'>  </p>
 </div>


</div>

<script>

$(function() { 
  NovoCalculo();
  document.getElementById('Text_Total_Folhas').focus();

  $('#Cmb_Fornecedor').get(0).selectedIndex = -1;
  $('#Lbl_Opcao_Calculo').text('');
});
function fsair() { 
	 $.post('saircx.php',
	 function(data,status,xhr) {
	    if (status == 'success') { 
            window.location.href = 'index.php';
		}
		if (status == 'error') {
		}
	 });
  
}

</script>
</body>
</html>