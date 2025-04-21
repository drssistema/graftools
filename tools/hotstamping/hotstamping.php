<?php
session_start();


$DEBUG = false;
if (isset($_REQUEST["DEBUG"])) {
    $DEBUG = $_REQUEST["DEBUG"];
    if ($DEBUG == 1) {
        $DEBUG = true;
    }    
} 

$vid_user = "9999";
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
else { 
    $_SESSION['id'] = "9999";
    $_SESSION['nome'] = "teste";    
}

$vprog1 = $_SESSION['prog'];
//echo $vprog1;

$vprog = explode('-',$vprog1);
$vdescr = "";

if (in_array("01",$vprog)) {
    $vdescr = "./hotstamping/hotstamping.php";
}
//echo $vdescr;

//if (empty($vdescr)) {
//    header("Location: ../index.php");	
//    return;    
//}

?>

<!DOCTYPE html>
<html>
<head>
<title>Hot Stamping</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='../js/jquery-3.7.1.min.js'></script>
<script src='../js/jquery-ui.js'></script>
<link rel='stylesheet' href='../js/jquery-ui.css'>
<script src='../js/jquery.inputmask.js'></script>
<script src='../js/jspdf.min.js'></script>
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
<script src="mod_hs.min.ob.js?version=4"></script>


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

.divprint {
  display: none;	
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
  font-size: 0.6vw;
}
legend {
  font-size: 0.6vw;
}
label {
  font-size: 0.6vw;
}
p {
  font-size: 0.6vw;
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
</script>
</head>

<body>
<div class='header' id='top_header'>
 <p style='width:10vw;float:left;color:blue;'>Usuario:<?php echo $vusuario ?></p>

 <button type='button' id='btnTutorial'  title='Tutorial' style='width:8vw'>Tutorial</button>
 <button type='button' id='btnFornec'  title='Fornecedor' style='width:8vw'>Fornecedor</button>
 
 <button type='button' id='btnHotStamping'  title='HotStamping' style='width:8vw'>HotStamping</button>
 
 <button type='button' id='btnExit'  title='SAIR' style='width:8vw;float:right;color:red;'>Sair</button>
 
</div>
<div class='main'>
 <div class='div1' id='div1'>
	  <fieldset style='width:12vw' id='Frame_Inicial' >
		   <label for='Text_Total_Folhas' style='font-size:0.8vw;font-weight:bold;'>Total de Folhas</label><br>
		   <!--<input type='text' id='Text_Total_Folhas' class='decimal0' value='' style='font-weight:bold;' onkeydown='nextField(event,"Text_Puxada_Longa")' onfocusout='total_folhas_Exit()'></input><br>-->
		   <input type='text' id='Text_Total_Folhas' class='decimal0' value='' style='font-weight:bold;'></input><br> 
		   <label for='Text_Puxada_Longa' style='font-size:0.8vw;font-weight:bold;'>Puxada Longa (mm)</label><br>
		   <input type='text' id='Text_Puxada_Longa' class='decimal0' value='' style='font-weight:bold;'></input> 
	  </fieldset>
 </div>	  
 <div class='div1a'>
      <p id='Lbl_Opcao_Calculo' style='font-size:0.6vw;color:maroon;width:10vw;font-weight:bold;'>CALCULADO PELA LARG DA BOBINA DO FORNECEDOR</p>
 </div>
 <div class='div2'> 
	  <button type='button' id='Btn_Atualiza_Tot_Rolos'  title='Atualize' style='width:6vw;font-weight:bold;background-color:white;'>Atualize</button>
	  <button type='button' id='Btn_Calcular'  title='Calcular' style='width:6vw;font-weight:bold;background-color:white;' disabled>Calcular</button>
	  <br><br>
	  <input type='text' id='txtDataRec' disabled></input>
	  <br>
	  <input type='text' id='txtPkRec' disabled></input>
	  <br>
	  <button type='button' id='Btn_Save_Calc'  title='Salvar' style='width:6vw;font-weight:bold;'>Salvar</button>
	  <br><br>
	  <button type='button' id='Btn_Print'  title='Print' style='width:6vw;font-weight:bold;background-color:white;'  disabled>Print</button>
	  <br><br>
	  <button type='button' id='Btn_Novo_Calc'  title='Novo' style='width:6vw;font-weight:bold;'>Novo</button>
 </div>

 <div class='div3'>
	  <fieldset style='width:15vw;height:8vw;font-size:0.8vw;'>
		<legend style='font-weight:bold;'>Fornecedor Hot Stamping</legend>
		 <table>
			<tr>
			  <td>
			   <select id='Cmb_Fornecedor'  style='font-size:0.8vw;font-weight:bold;'>
			   </select>
			  </td>
			  <td>
			   <fieldset style='width:10vw;height:2vw;color:blue;'>
				 <legend style='font-weight:bold;'>Largura Bobina</legend>
				  <input type='radio' id='Opt_Normal' name='rlbobina' value='Normal'></input> 
				  <label for='Opt_Normal'>Normal</label>
				  <input type='radio' id='Opt_Duplo' name='rlbobina' value='Duplo'></input> 
				  <label for='Opt_Duplo'>Duplo</label>
				</fieldset>
			  </td>
			</tr> 
		 </table>	
		 <table>
			<tr>
			  <th>Larg. Bobina (mts)</th>
			  <th>Min. Lineares (mts)</th>
			  <th>Max. mts Lineares</th> 		  
			</tr>
			<tr>
			  <td><input type='text' id='LBL_Larg_Bob_Fornec' class='decimal' style='font-weight:bold;color:red;width:8vw;' disabled></input></td> 
			  <td><input type='text' id='Lbl_Min_Lineares' class='decimal' style='font-weight:bold;color:red;width:8vw;' disabled></input></td> 
			  <td><input type='text' id='Lbl_Max_Lineares' class='decimal' style='font-weight:bold;color:red;width:8vw;'></input></td> 
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
		 <th>2) mts(Lineares)</th>
		 <th>(m2)</th>
	   </tr>
	   <tr>
		 <td><input type='text' id='Text_Res_A' class='decimal' disabled></input></td>   
		 <td><input type='text' id='Text_Res_C' class='decimal' disabled></input></td>   
		 <td><input type='text' id='Text_Res_B' class='decimal' disabled></input></td>   
	   </tr>
	  </table> 
	  <table style='color:black;'>
		<tr>
		  <th colspan='5' ><span style='color:black;font-weight:bold'>Resultado Final</span></th> 
		</tr>
		<tr>
		  <td style='color:black;font-weight:bold'>Total de</td>
		  <td><input type='text' id='Text_Res_D' class='decimal'></input></td>   
		  <td style='color:black;font-weight:bold'>Bobinas c/</td>
		  <td><input type='text' id='Text_Res_E' class='decimal'></input></td>   
		  <td style='color:black;font-weight:bold'>mts lineares</td>
		</tr>
	  </table>
	  <table border='0' style='color:black;'>
	   <tr>
		 <th style='color:black;font-weight:bold'>Tot (Lineares)</th>
		 <th style='color:black;font-weight:bold'>Total em m2</th>
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
 
 <div class='div5' id='div5'> 
  <table border='1' style='border-collapse: collapse;'>
    <tr>
      <td></td>
      <td>
 	   <fieldset> 
	    <legend>JOB1 Principal ATIVO?</legend>
	      <input type='radio' id='J1_Prim_Opt_Ativo_Sim' name='J1_Prim_Opt_Ativo' value='SIM'></input> 
		  <label for='J1_Prim_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J1_Prim_Opt_Ativo_Nao' name='J1_Prim_Opt_Ativo' value='NAO'></input> 
		  <label for='J1_Prim_Opt_Ativo_Nao'>NÃO</label>
	   </fieldset>
	  </td>
      <td>
	   <fieldset>
	    <legend>JOB1 Espelho ATIVO?</legend>
	      <input type='radio' id='J1_Seg_Opt_Ativo_Sim' name='J1_Seg_Opt_Ativo' value='SIM'></input> 
		  <label for='J1_Seg_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J1_Seg_Opt_Ativo_Nao' name='J1_Seg_Opt_Ativo' value='NAO'></input> 
		  <label for='J1_Seg_Opt_Ativo_Nao'>NÃO</label>
	   </fieldset>
	  </td>
      <td>
	   <fieldset>
	    <legend>JOB2 Principal ATIVO?</legend>
	      <input type='radio' id='J2_Prim_Opt_Ativo_Sim' name='J2_Prim_Opt_Ativo' value='SIM'></input> 
		  <label for='J2_Prim_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J2_Prim_Opt_Ativo_Nao' name='J2_Prim_Opt_Ativo' value='NAO'></input> 
		  <label for='J2_Prim_Opt_Ativo_Nao'>NÃO</label>
	   </fieldset>
	  </td>
      <td>
	   <fieldset>
	    <legend>JOB2 Espelho ATIVO?</legend>
	      <input type='radio' id='J2_Seg_Opt_Ativo_Sim' name='J2_Seg_Opt_Ativo' value='SIM'></input> 
		  <label for='J2_Seg_Opt_Ativo_Sim'>SIM</label>
		  <input type='radio' id='J2_Seg_Opt_Ativo_Nao' name='J2_Seg_Opt_Ativo' value='NAO'></input> 
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
     <td><span style='color:red;font-weight:bold;'>LARGURA DO ROLO (mm):</span></td>
     <td><input type='text' id='Text_J1_Prim_LARG_ROLO' class='decimal' value='' style='background-color:red;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_LARG_ROLO'  class='decimal' value='' style='background-color:red;color:white;font-weight:bold;' disabled></input></td>
     <td><input type='text' id='Text_J2_Prim_LARG_ROLO' class='decimal' value='' style='background-color:red;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_LARG_ROLO' class='decimal' value=''  style='background-color:red;color:white;font-weight:bold;' disabled></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>Advance Pull (mm):</span></td>
     <td><input type='text' id='Text_J1_Prim_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_Puxada_Limpeza' value='' class='decimal' style='background-color:silver;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#1 Short Pull (mm):</span></td>
     <td><input type='text' id='Text_J1_Prim_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#1 Short Pull No.:</span></td>
     <td><input type='text' id='Text_J1_Prim_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_N_BAT_CURTA' value='' class='decimal' style='background-color:pink;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#2 Short Pull (mm): </span></td>
     <td><input type='text' id='Text_J1_Prim_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#2 Short Pull No.:</span></td>
     <td><input type='text' id='Text_J1_Prim_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_N_BAT_CURTA_2' value='' class='decimal' style='background-color:lime;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>Long Pull (mm):</span></td>
     <td><input type='text' id='Text_J1_Prim_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_BAT_LONGA' value='' class='decimal' style='background-color:red;color:white;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>PUXADA TOTAL (mm):</span></td>
     <td><input type='text' id='Text_J1_Prim_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_PUXADA' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>TOTAL DE BATIDAS:</span></td>
     <td><input type='text' id='Text_J1_Prim_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J1_Seg_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Prim_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
     <td><input type='text' id='Text_J2_Seg_TOT_BAT' value='' class='decimal' style='background-color:yellow;color:black;font-weight:bold;'></input></td>
    </tr>
    <tr>
     <td></td>
     <td><button type='button' id='Btn_Limpar_JOB1_Prim'  style='width:8vw'>LIMPAR JOB1</button></td>
     <td><!--<button type='button' id='Btn_Limpar_JOB1_Seg'  style='width:8vw' onclick='Btn_Limpar_JOB1_Seg_Click()'>Limpar JOB1</button>--></td>
     <td><!--<button type='button' id='Btn_Limpar_JOB2_Prim'  style='width:8vw' onclick='Btn_Limpar_JOB2_Prim_Click()'>Limpar JOB2</button>--></td>
     <td><!--<button type='button' id='Btn_Limpar_JOB2_Seg'  style='width:8vw' onclick='Btn_Limpar_JOB2_Seg_Click()'>Limpar JOB2</button>--></td>
    </tr>
    <tr>
     <td></td>
	 <td>
       <input type='radio' id='ChkBox_J1_Prim_Nenhum' name='ChkBox_J1' value='1'>
       <label for='ChkBox_J1_Prim_Nenhum'>Somente este</label><br>	 
       <input type='radio' id='ChkBox_J1_Prim_J1_Seg' name='ChkBox_J1' value='2'>
       <label for='ChkBox_J1_Prim_J1_Seg'>2 ROLOS</label><br>	 
       <input type='radio' id='ChkBox_J1_Prim_J2_Prim' name='ChkBox_J1' value='3'>
       <label for='ChkBox_J1_Prim_J2_Prim'>3 ROLOS</label><br>	 
       <input type='radio' id='ChkBox_J1_Prim_Todos' name='ChkBox_J1' value='4'>
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
                <input type='radio' id='Opt_Puxar_J1' name='Opt_Puxar' value='SIM'></input> 
		<label for='Opt_Puxar_J1'>SIM</label>
		<input type='radio' id='Opt_N_Puxar_J1' name='Opt_Puxar' value='NAO'></input> 
		<label for='Opt_N_Puxar_J1'>NÃO</label>
	   </fieldset>
	 </td>
	 <td>
	 </td>
    </tr>
	<tr>
	<td colspan='5'>
	   <fieldset>
		 <p id='Lbl_Msg_0' style='font-size:0.8vw;'>A soma de <span id='Lbl_Tot_Rolos_2'>9999</span> rolo(s) = <span id='Lbl_Larg_Produzir_Hot'>9999</span> mm restando...<span id='Lbl_Resto_Bobina' style='color:red;'>9999</span>mm na Bob do Fornecedor</p>  
		 <p id='Lbl_Msg_1' style='font-size:0.8vw;'>xxxxxx</p>
		 <p id='Lbl_Msg_2' style='font-size:0.8vw;'>xxxxxx</p>
		 <p id='Lbl_Msg_3' style='font-size:0.8vw;'>xxxxxx</p>
	   </fieldset>   
	</td>
	</tr>
  </table>
 </div>
 
 <div id='frmFornec' title='Fornecedor'>
 <div>
  <table id='tableFornec1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
   <thead>
   <tr>
   <th>Fornecedor</th>
   <th>Largura Bobina</th>
   <th>Min. Lineares</th>
   <th>Max. mts Lineares</th>
   </tr>
   </thead>
   <tbody id='tbodyFornec1'>
   </tbody>
  </table>
 </div>
 </div>
 <div id='frmFornecDetail' title='Fornecedor'>
 <div>
  <input type='text' id='txtRowFornec' style='width:5vw;' disabled></input>
  <input type='text' id='txtPkFornec' style='width:5vw;' disabled></input></br></br>
  <table>
   <tr>
     <td>Fornecedor</td>
     <td><input type='text' id='txtFornec' disabled></input></td>
   </tr>
   <tr>
     <td>Largura Bobina (mts)</td>
     <td><input type='text' id='txtLarguraBobina' class='decimal' style='width:10vw' disabled></input></td>
   </tr>
   <tr>
     <td>Min. Lineares (mts)</td>
     <td><input type='text' id='txtMinLineares' class='decimal' style='width:10vw' disabled></input></td>
   </tr>
   <tr>
     <td>Max. mts Lineares</td>
     <td><input type='text' id='txtMaxMtsLineares' class='decimal' style='width:10vw'></input></td>
   </tr>
  </table>
 </div>
 </div>
 
 <div id='frmHotStamping' title='Hot Stamping'>
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
    
    
    <table id='tbHotStamping1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
	<th>Numero</th>
	<th>Data</th>
	<th>Qtd Folhas</th>
	<th>Puxada Longa</th>
	<th>Fornecedor</th>
	<th>Largura do Rolo</th>
     </tr>
    </thead>
    <tbody id='tbodyHotStamping1'>
    </tbody>
    </table>
 </div>
 
 
 <div class='tutorial' id='tutorial' title='Tutorial'>
   <div class="tutorialtext" id="tutorialtext">
     <p style="font-size: 1vw;">
        PERGUNTA PARA O DAVID R SILVA.
     </p>   
   </div>
   <script>
   </script>
 </div>

 <div id='dialog-delete' title='Atenção!'>
  <p>Deleta o item?</p><br>
  <p id='delItem'></p>  
 </div>

 <div id='dialog-message' title='Message'>
    <p id='txtmsg'>  </p>
 </div>


</div>

<div class='divprint' id='divprint'>
   <table style='margin:0 auto;width:90%'>
     <tr>
       <th>Total de Folhas</th>
       <th>Puxada Longa</th>
       <th>Fornecedor</th>
       <th>Largura Bobina</th>
       <th>Larg. Bobina (mts)</th>
       <th>Min. Lineares (mts)</th>
       <th>Max. mts Lineares</th>
     </tr> 	 
     <tr>
       <td id='r_totalfolhas'></td>
       <td id='r_puxadalonga'></td>
       <td id='r_fornec'></td>
       <td id='r_largurabobina'></td>
       <td id='r_largbobina'></td>
       <td id='r_minlineares'></td>
       <td id='r_maxlineares'></td>
     </tr> 	 
   </table>
   <br>
     <p id='r_Lbl_Opcao_Calculo' style='text-align:center;color:maroon;font-weight:bold;'>CALCULADO PELA LARG DA BOBINA DO FORNECEDOR</p>
   <br>
   <table style='margin:0 auto;'>
    <tr> 
     <th>Total de Bobinas</th>
	 <th>Total mts Lineares</th>
	 <th>Total Lineares</th>
	 <th>Total em m2</th>
	</tr>
  	<tr>
	  <td id='r_textres_d'></td>
	  <td id='r_textres_e'></td>
	  <td id='r_textres_g'></td>
	  <td id='r_textres_f'></td>
	</tr>
   <table>
   <br>
   <table style='margin:0 auto;width:90%'>
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
     <td><span style='color:red;font-weight:bold;'>LARGURA DO ROLO (mm):</span></td>
     <td id='r_Text_J1_Prim_LARG_ROLO'></td>
     <td id='r_Text_J1_Seg_LARG_ROLO'></td>
     <td id='r_Text_J2_Prim_LARG_ROLO'></td>
     <td id='r_Text_J2_Seg_LARG_ROLO'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>Advance Pull (mm):</span></td>
     <td id='r_Text_J1_Prim_Puxada_Limpeza'></td>
     <td id='r_Text_J1_Seg_Puxada_Limpeza'></td>
     <td id='r_Text_J2_Prim_Puxada_Limpeza'></td>
     <td id='r_Text_J2_Seg_Puxada_Limpeza'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#1 Short Pull (mm):</span></td>
     <td id='r_Text_J1_Prim_BAT_CURTA'></td>
     <td id='r_Text_J1_Seg_BAT_CURTA'></td>
     <td id='r_Text_J2_Prim_BAT_CURTA'></td>
     <td id='r_Text_J2_Seg_BAT_CURTA'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#1 Short Pull No.:</span></td>
     <td id='r_Text_J1_Prim_N_BAT_CURTA'></td>
     <td id='r_Text_J1_Seg_N_BAT_CURTA'></td>
     <td id='r_Text_J2_Prim_N_BAT_CURTA'></td>
     <td id='r_Text_J2_Seg_N_BAT_CURTA'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#2 Short Pull (mm): </span></td>
     <td id='r_Text_J1_Prim_BAT_CURTA_2'></td>
     <td id='r_Text_J1_Seg_BAT_CURTA_2'></td>
     <td id='r_Text_J2_Prim_BAT_CURTA_2'></td>
     <td id='r_Text_J2_Seg_BAT_CURTA_2'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>#2 Short Pull No.:</span></td>
     <td id='r_Text_J1_Prim_N_BAT_CURTA_2'></td>
     <td id='r_Text_J1_Seg_N_BAT_CURTA_2'></td>
     <td id='r_Text_J2_Prim_N_BAT_CURTA_2'></td>
     <td id='r_Text_J2_Seg_N_BAT_CURTA_2'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>Long Pull (mm):</span></td>
     <td id='r_Text_J1_Prim_BAT_LONGA'></td>
     <td id='r_Text_J1_Seg_BAT_LONGA'></td>
     <td id='r_Text_J2_Prim_BAT_LONGA'></td>
     <td id='r_Text_J2_Seg_BAT_LONGA'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>PUXADA TOTAL (mm):</span></td>
     <td id='r_Text_J1_Prim_PUXADA'></td>
     <td id='r_Text_J1_Seg_PUXADA'></td>
     <td id='r_Text_J2_Prim_PUXADA'></td>
     <td id='r_Text_J2_Seg_PUXADA'></td>
    </tr>
    <tr>
     <td><span style='color:red;font-weight:bold;'>TOTAL DE BATIDAS:</span></td>
     <td id='r_Text_J1_Prim_TOT_BAT'></td>
     <td id='r_Text_J1_Seg_TOT_BAT'></td>
     <td id='r_Text_J2_Prim_TOT_BAT'></td>
     <td id='r_Text_J2_Seg_TOT_BAT'></td>
    </tr>
	<tr>
	<td colspan='5'>
	   <fieldset>
		 <p id='r_Lbl_Msg_0'></p>  
		 <p id='r_Lbl_Msg_1'></p>
		 <p id='r_Lbl_Msg_2'></p>
		 <p id='r_Lbl_Msg_3'></p>
	   </fieldset>   
	</td>

   </table>   
</div>

<script>

//$(function() { 
//  NovoCalculo();
//  document.getElementById('Text_Total_Folhas').focus();
//
//  $('#Cmb_Fornecedor').get(0).selectedIndex = -1;
//  $('#Lbl_Opcao_Calculo').text('');
//});



//$(document).ready(function() {
//    makeTableFornec();   
//    makeTableHS1();
//});


</script>
</body>
</html>