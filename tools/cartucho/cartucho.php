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

if (in_array("03",$vprog)) {
    $vdescr = "./cartucho/menu.php";
} 
if (empty($vdescr)) {
    header("Location: ../index.php");	
    return;    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Cartucho</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src='../js/konva.min.js'></script>
<script src='../js/jquery-3.7.1.min.js'></script>
<script src='../js/jquery.inputmask.js'></script>
<script src='../js/jspdf.min.js'></script>
<script src='../js/math.js'></script>
<script src='../js/jquery-ui.js'></script>
<link rel='stylesheet' href='../js/jquery-ui.css'>
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

<script src='modmount.min.ob.js?version="2"'></script>

<style>

body {
  font-family: Arial, Helvetica, sans-serif;
  overflow : hidden;
}

/* Style the header */
.header {
  background-color: #bbb;
  padding: 5px;
  text-align: center;
  font-size: 10px;
  height : 4vh;
}

/* Create three unequal columns that floats next to each other */
.column {
  float: left;
  padding: 0px;
  /*height: 50%;*/  /* Should be removed. Only for demonstration */
  height: 91vh;
}

/* Left and right column */
.column.side {
  width: 20%;
}

/* Middle column */
.column.middle {
  width: 80%;
  overflow:auto;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Style the footer */
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #bbb;
  padding: 2px;
  text-align: center;
  font-size: 5px;
  height: 3vh;
}



input[type=text]:focus {
   background-color: yellow;
}


/* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
@media (max-width: 1024px) {
  .column.side {
    width: 20%;
  }
  .column.middle {
    width: 80%;
  }
}

.icon-rotate {
   background-image: url(./images/icons-rotate.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-clear {
   background-image: url(./images/icons-clear.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-zoomIn {
   background-image: url(./images/icons-zoom-in.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-zoomOut {
   background-image: url(./images/icons-zoom-out.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-reset {
   background-image: url(./images/icons-reset.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-width {
   background-image: url(./images/icons-width.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-pdf {
   background-image: url(./images/icons-pdf.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-png {
   background-image: url(./images/icons-png.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-tutorial {
   background-image: url(./images/icons-tutorial.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-undo {
   background-image: url(./images/icons-undo.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-redo {
   background-image: url(./images/icons-redo.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-lock {
   background-image: url(./images/icons-lock.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-unlock {
   background-image: url(./images/icons-unlock.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-open-file {
   background-image: url(./images/icons-open-file.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-save-file {
   background-image: url(./images/icons-save-file.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-delete-file {
   background-image: url(./images/icons-delete-file.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-template {
   background-image: url(./images/icons-template.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-machine {
   background-image: url(./images/machine.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-box {
   background-image: url(./images/box.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}

.tutorial {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  /*background-color: rgba(0,0,0,0.5);*/
  z-index: 2;
  cursor: pointer;
  overflow: auto;
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  
}


.close_tutorial {
  color: yellow;
  float: left;
  font-size: 28px;
  font-weight: bold;
  text-align: right;
  width: 97%;
  position: fixed;
}

.close_tutorial:hover,
.close_tutorial:focus {
  color: red;
  text-decoration: none;
  cursor: pointer;
}



.tutorialtext {
  overflow: auto;	
  position: absolute;
  top: 0;
  left: 10px;
  font-size: 2vw;
  color: yellow;
  width:90%;
}


.loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 10;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  display: none;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


</style>

<script>
</script>

</head>
<body>


<div class="header" id="top_header">
 <button type="button" id="btnTutorial" class="icon-tutorial" title="Tutorial" style="width: 1vw;font-size: 1vw" onclick="tutorialon()"></button>
 <button type="button" id="rotate" class="icon-rotate" title="Girar" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id="clear" class="icon-clear" title="Estado Original" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='stage1ZoomIn' class="icon-zoomIn" title="Aumentar" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='stage1ZoomOut' class="icon-zoomOut" title="Diminuir" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='reset' class="icon-reset" title="Tamanho Normal" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='fitToWidth' class="icon-width" title="Ajusta na largura" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='savepdf' class="icon-pdf" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='saveimg' class="icon-png" style="width: 1vw;font-size: 1vw"></button>
 
 <!--<button type="button" id='btnRefresh' style="width: 4vw;font-size: 0.6vw">Refresh</button>-->
 <button type="button" id='btnUndo' class='icon-undo' title='Undo' style="width: 1vw;font-size: 0.6vw"></button>
 <button type="button" id='btnRedo' class='icon-redo' title='Redo'  style="width: 1vw;font-size: 0.6vw"></button>
 <button type="button" id='btnLock' class='icon-lock' title='Lock' style="width: 1vw;font-size: 0.6vw"></button>
 <button type="button" id='btnUnlock' class='icon-unlock' title='Unlock' style="width: 1vw;font-size: 0.6vw"></button>
 <button type="button" id='btnOpenFile' class='icon-open-file' title='Abrir' style="width: 1vw;font-size: 0.6vw"></button>
 <button type="button" id='btnSaveFile' class='icon-save-file' title='Salvar' style="width: 1vw;font-size: 0.6vw"></button>
 <button type="button" id='btnDelFile' class='icon-delete-file' title='Deletar' style="width: 1vw;font-size: 0.6vw"></button>
 
 
 <label for = "xposition" style="font-size: 0.5vw;">X:</label>
 <input type="text" id="xposition" style="width: 3vw;font-size: 0.6vw"  class="decimal" disabled value="0"></input>
 <label for = "yposition" style="font-size: 0.5vw;">Y:</label>
 <input type="text" id="yposition" style="width: 3vw;font-size: 0.6vw" class="decimal" disabled value="0"></input>
 <label for = "xwidth" style="font-size: 0.5vw;">Larg.:</label>
 <input type="text" id="xwidth" style="width: 3vw;font-size: 0.6vw"  class="decimal" disabled value="0"></input>
 <label for = "yheight" style="font-size: 0.5vw;">Alt.:</label>
 <input type="text" id="yheight" style="width: 3vw;font-size: 0.6vw" class="decimal" disabled value="0"></input>

 <script>
    
</script> 
 
</div>


  <div class="column side"  id="column_prop1" style="background-color:#f1f1f1;">
     <button type='button' id='btnTemplate' class='icon-template' title='Template' style="width: 1vw;font-size: 0.7vw"></button>
     <button type='button' id='btnOpen' class='icon-box' title='Cartucho' style="width: 1vw;font-size: 0.7vw"></button>

     <table id="tbPaperSize" style="width: 100%">
       <tr>
          <th colspan="2" style="font-size: 0.8vw;">Área Imprimível </th>
          <th><button type='button' id='btnOpenMaq' class='icon-machine' title='Maquina' style="width: 1vw;font-size: 0.7vw"></button></th>
       </tr>
       <tr>   
          <td style="width:90%;font-size: 0.8vw;">Largura Papel</td>
          <td><input type="text" style="width: 5vw;font-size: 0.8vw;" class="decimal" id="larguraPapel" value=1000 /></td>
          <td style="font-size: 1vw;">mm</td>
       </tr>
       <tr>   
          <td style="width:90%;font-size: 0.8vw;">Altura Papel</td>
          <td><input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="alturaPapel" value=1000 /></td>
          <td style="font-size: 1vw;">mm</td>
       </tr>
     </table>

     
     <table id="tbProperties" style="width: 100%;">
       <tr>
          <th colspan="3" style="font-size: 0.8vw;">Medidas</th>
       </tr>       
       <tr>
          <td>Compr(CP)</td>
          <td><input type='text' id='txtComprimento' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
          <td>mm</td>
       <tr>
          <td>Altura(AT)</td>
          <td><input type='text' id='txtAltura' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
          <td>mm</td>
       </tr>       
       <tr>
          <td>Lateral(LT)</td>
          <td><input type='text' id='txtLateral' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
          <td>mm</td>
       </tr>       
       <tr>
          <td>Colagem(CL)</td>
          <td><input type='text' id='txtColagem' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
          <td>mm</td>
       </tr>       
       <tr>
          <td>Boca(BC)</td>
          <td><input type='text' id='txtBoca' class='decimal' style='width:5vw;font-size: 0.8vw;'></input> </td>
          <td>mm</td>
       </tr>       
       <tr>
          <td>Sangria</td>
          <td><input type='text' id='txtSangria' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
          <td>mm</td>
       </tr>
       <tr>
          <td>Intervalo X (Clonagem)</td>
          <td><input type='text' id='txtIntervaloX' class='decimal'  style='width:5vw;font-size: 0.8vw;' value="0"></input> </td>
          <td>mm</td>
       </tr>
       <tr>
          <td>Intervalo Y (Clonagem)</td>
          <td><input type='text' id='txtIntervaloY' class='decimal'  style='width:5vw;font-size: 0.8vw;' value="0"></input> </td>
          <td>mm</td>
       </tr>
     </table>
  </div>
  <div class="column middle" id="container0" style="background-color:#f0f0f0;">
    <label for="txtDescricaoMontagem" style='font-size: 0.8vw;'>Descrição Montagem</label>
    <input type="text" id="txtDescricaoMontagem" style='width:40vw;font-size: 0.8vw;'></input>
    <input type="text" id="txtCodigoMontagem"style='width:4vw;font-size: 0.8vw;' disabled></input>
    <div id="container"></div> 
  </div>

  <script>
  </script>



<div class="tutorial" id="tutorial" onclick="tutorialoff()">
  <span onclick="document.getElementById('tutorial').style.display='none'" class="close" title="Close Modal">&times;</span>
  <span class="close_tutorial">&times;</span>
  <div class="tutorialtext" id="tutorialtext">
  <pre style="font-size: 0.8vw;font-family: monospace">
    Para mover um objeto clique com o mouse no objeto para ficar selecionado e mova com o mouse ou use as setas do lado esquerdo.
    Para mover usando o X: ou Y: selecione o objeto com o mouse para ficar selecionado. Coloque a medida e tecle Enter.
    Para girar um objeto clique com o mouse no objeto que ficará selecionado e clique no botão girar.
    A origem(x,y) do objeto move junto com o giro. Portanto o (x,y) fica diferente da posição original.
    Para clonar um objeto na horizontal marque o objeto e tecle H.
    Para clonar um objeto na vertical marque o objeto e tecle V.
    Para remover a sangria volte para zero.

  </pre>  
  </div>

  <script>
	var modal = document.getElementById("tutorial");
	var span = document.getElementsByClassName("close_tutorial")[0];
	span.onclick = function() {
	  modal.style.display = "none";
	};
	function tutorialon() {
	  document.getElementById("tutorial").style.display = "block";
	}
	
	function tutorialoff() {
	  document.getElementById("tutorial").style.display = "none";
	}
	
  </script>

</div>


<div class="loader" id="loader1"></div>

<div class="footer" id="bottom_footer">
  <p style="font-size: 0.6vw;text-align: right">Powered by DRSSISTEMAS</p>
</div>


 <div id='frmTemplate' title='Template'>
    <label for="txtSearchTemp" style='font-size: 0.8vw;'>Procurar</label> 
    <input type="text" id="txtSearchTemp" style='width:30vw;font-size: 0.8vw;'></input>
    <button type="button" id='btnSearchTemp' style="width: 4vw;font-size: 0.6vw">Procurar</button>
    <label for="txtRecordTemp" style='font-size: 0.8vw;'>Registros</label> 
    <input type="text" id="txtRecordTemp" style='width:4vw;font-size: 0.8vw;' value="50"></input>
    <table id='tbTemplate1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
      <th>Embalagem</th>
      <th>Descricao</th>
     </tr>
    </thead>
    <tbody id='tbodyTemplate1'>
    </tbody>
    </table>
 </div>
 <div id='frmOpen' title='Abrir'>
    <label for="txtSearchCart" style='font-size: 0.8vw;'>Procurar</label> 
    <input type="text" id="txtSearchCart" style='width:30vw;font-size: 0.8vw;'></input>
    <button type="button" id='btnSearchCart' style="width: 4vw;font-size: 0.6vw">Procurar</button>
    <label for="txtRecordCart" style='font-size: 0.8vw;'>Registros</label> 
    <input type="text" id="txtRecordCart" style='width:4vw;font-size: 0.8vw;' value="50"></input>
    <table id='tbOpen1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
      <th></th>
      <th>Codigo</th>
      <th>Sigla</th>
      <th>Descricao</th>
     </tr>
    </thead>
    <tbody id='tbodyOpen1'>
    </tbody>
    </table>
 </div>
 <div id='frmOpenMaq' title='Maquinas'>
    <table id='tbOpenMaq1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
      <th>Codigo</th>
      <th>Equipamento</th>
      <th>Apelido</th>
     </tr>
    </thead>
    <tbody id='tbodyOpenMaq1'>
    </tbody>
    </table>
 </div>

 <div id='frmOpenMont' title='Abrir'>
    <label for="txtSearch" style='font-size: 0.8vw;'>Procurar</label> 
    <input type="text" id="txtSearch" style='width:30vw;font-size: 0.8vw;'></input>
    <button type="button" id='btnSearch' style="width: 4vw;font-size: 0.6vw">Procurar</button>
    <label for="txtRecord" style='font-size: 0.8vw;'>Registros</label> 
    <input type="text" id="txtRecord" style='width:4vw;font-size: 0.8vw;' value="50"></input>
    <table id='tbOpenMont1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
      <th>Cod</th>
      <th>Data</th>
      <th>Descricao</th>
     </tr>
    </thead>
    <tbody id='tbodyOpenMont1'>
    </tbody>
    </table>
 </div>
  
  
<div id='dialog-delete' title='Atenção!'>
  <p>Deleta o item?</p><br>
  <p id='delItem'></p>  
</div>

<div id='dialog-message' title='Message'>
    <p id='txtmsg'>  </p>
</div>

</body>
</html>
