<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
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
<html>
<head>
<title>Carttucho Menu</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='../js/jquery-3.7.1.min.js'></script>
<script src='../js/jquery-ui.js'></script>
<link rel='stylesheet' href='../js/jquery-ui.css'>
<script src='../js/jquery.inputmask.js'></script>
<script src='../js/jspdf.min.js'></script>
<script src='modcart.min.ob.js?version="2"'></script>
<script src='../module.min.ob.js?version="4"'></script>

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
  /*overflow : auto;*/
}

.header {
  position: fixed;
  top: 0vh;
  left: 0vh;
  background-color: #bbb;
  padding: 1px;
  text-align: center;
  font-size: 0.8vw;
  height : 1.2vw;
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

.main1 {
  position: absolute;  
  top: 1.0vw;
  left: 0vw;
  padding: 0px;
  height: 100%;
  width: 100%;
  display: block;
  overflow: auto;
}
.main2 {
  position: absolute;  
  top: 1.0vw;
  left: 0vw;
  padding: 0px;
  height: 100%;
  width: 100%;
  display: block;
  overflow: auto;
}

button {
  font-size: 0.8vw;
}

</style>

<script>
vid_user = <?php echo "'".$vid_user."'" ?>;
vusuario = <?php echo "'".$vusuario."'" ?>;

</script>

</head>
<body>
<div class='header' id='top_header'>
  <p style='width:10vw;margin:5px;float:left;color:blue;font-size:0.6vw'>Usuario:<?php echo $vusuario ?></p>

  <button type='button' id='btnDesign'  title='Desenho' style='width:8vw;font-size:0.6vw'>Desenho</button>
  <button type='button' id='btnMontagem'  title='Montagem' style='width:8vw;font-size:0.6vw'>Montagem</button>
  <button type='button' id='btnMaq'  title='Maquinas' style='width:8vw;font-size:0.6vw'>Maquinas</button>
  <button type='button' id='btnExit'  title='SAIR' style='width:8vw;;font-size:0.6vw;float:right;color:red;'>Sair</button>
 
</div>
<div class='main1' id='main1'>
    <iframe id="frame1" style='position:absolute;top:0;right:0;height:100%; width:100%' frameBorder='0'></iframe>
</div> 
<div class='main2' id='main2'>
    <iframe id="frame2" style='position:absolute;top:0;right:0;height:100%; width:100%' frameBorder='0'></iframe>
</div> 
    
 <div id='frmOpenMaq' title='Maquinas'>
    <label for="txtSearch" style='font-size: 0.8vw;'>Procurar</label> 
    <input type="text" id="txtSearch" style='width:30vw;font-size: 0.8vw;'></input>
    <button type="button" id='btnSearch' style="width: 4vw;font-size: 0.6vw">Procurar</button>
    <label for="txtRecord" style='font-size: 0.8vw;'>Registros</label> 
    <input type="text" id="txtRecord" style='width:4vw;font-size: 0.8vw;' value="50"></input>
    <table id='tbOpenMaq' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
      <th>Codigo</th>
      <th>Equipamento</th>
      <th>Apelido</th>
     </tr>
    </thead>
    <tbody id='tbodyOpenMaq'>
    </tbody>
    </table>
 </div>
 <div id='frmMaquinaDetail' title='Maquinas'>
 <div>
  <input type='text' id='txtRowMaq' style='width:5vw;' disabled></input>
  <input type='text' id='txtCodMaq' style='width:5vw;' disabled></input></br></br>
  <table>
   <tr>
     <td>Codigo</td>
     <td><input type='text' id='txtCodigo'></input></td>
   </tr>
   <tr>
     <td>Equipamento</td>
     <td><input type='text' id='txtEquipamento'  style='width:20vw'></input></td>
   </tr>
   <tr>
     <td>Apelido</td>
     <td><input type='text' id='txtApelido' style='width:10vw'></input></td>
   </tr>
   <tr>
     <td>Larg Mancha</td>
     <td><input type='text' id='txtLargMancha' class='decimal' style='width:10vw'></input></td>
   </tr>
   <tr>
     <td>Compr Mancha</td>
     <td><input type='text' id='txtComprMancha' class='decimal' style='width:10vw'></input></td>
   </tr>
   <tr>
     <td>Larg Folha</td>
     <td><input type='text' id='txtLargFolha' class='decimal' style='width:10vw'></input></td>
   </tr>
    <tr>
     <td>Compr Folha</td>
     <td><input type='text' id='txtComprFolha' class='decimal' style='width:10vw'></input></td>
   </tr>
  
  </table>
 </div>
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