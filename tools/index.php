<?php
session_start();
unset($_SESSION['id'], $_SESSION['idcli'], $_SESSION['nome'], $_SESSION['prog']);
//$_SESSION['prog_choice']='02';
require_once('./conecta.php');
require_once('./util.php');

$cliente = "";
$usuario = "";
$senha = "";
$program = "";
$error = "0"; 
$vdescr = ""; 
if (filter_input(INPUT_POST,"txtCli", FILTER_DEFAULT)) {
   $cliente = filter_input(INPUT_POST,"txtCli", FILTER_SANITIZE_STRING);  
}
if (filter_input(INPUT_POST,"txtUser", FILTER_DEFAULT)) {
   $usuario = filter_input(INPUT_POST,"txtUser", FILTER_SANITIZE_STRING);  
}
if (filter_input(INPUT_POST,"txtPwd", FILTER_DEFAULT)) {
    $senha = filter_input(INPUT_POST,"txtPwd", FILTER_DEFAULT);
}
if (filter_input(INPUT_POST,"cmbProgram", FILTER_DEFAULT)) {
    $program = filter_input(INPUT_POST,"cmbProgram", FILTER_DEFAULT);
}

if (empty($cliente)) {
    goto fim;
}

   
$conn = pdoConn();
$sql = 'SELECT * FROM tbuser WHERE codcli='.$cliente.' and coduser='.$usuario.' LIMIT 1';
//echo $sql;
//let text = '{"employees":[' +
//'{"firstName":"John","lastName":"Doe" },' +
//'{"firstName":"Anna","lastName":"Smith" },' +
//'{"firstName":"Peter","lastName":"Jones" }]}';
foreach ($conn->query($sql) as $row) {
    //if (password_verify($senha, $row['senha'])){
    //echo $senha;
    //echo $row['senha'];
    //echo decrypt($row['senha']);
    if ($senha ==  decrypt($row['senha'])){
        $_SESSION['idcli'] = $row['codcli'];
	$_SESSION['id'] = $row['coduser'];
	$_SESSION['nome'] = $row['nomeuser'];
	$_SESSION['prog'] = $row['program'];
	$vprog = explode('-',$row['program']);
	$vdescr = "";
          
        $vdataval = $row['validade'];
        $vativo = $row['ativo'];
        
        $vdatanow = date("Y-m-d");
        
        if ($vdatanow > $vdataval) {
            $cliente = null;
            $usuario = null; 
            $error = 3;
            goto fim;
        }
        if ($vativo == 'N') {
            $cliente = null;
            $usuario = null; 
            $error = 3;
            goto fim;
        }
         
        
	if (in_array($program,$vprog)) {
            if ($program === "01") {
                $vdescr = "./hotstamping/";
            }   
            else if ($program === "02") {
                 $vdescr = "./caixaembarque/";
            }   
            else if ($program === "03") {
                 $vdescr = "./cartucho/";
            }   
        } 
        if (empty($vdescr)) {
            unset($_SESSION['id'], $_SESSION['idcli'], $_SESSION['nome'], $_SESSION['prog']);
            $cliente = null;
            $usuario = null; 
            $error = 2;
        }
        else {
            $_SESSION['prog_choice'] = $program;            
        }
        
    } else {
            $cliente = null;
            $usuario = null; 
	    $error = 1;
            unset($_SESSION['id'],$_SESSION['idcli'], $_SESSION['nome'], $_SESSION['prog']);
    }
	  
}


fim:

echo " 
<!DOCTYPE html>
<html>
<head>
<title>Program - Tools</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='./js/jquery-3.7.1.min.js'></script>
<script src='./js/jquery-ui.js'></script>
<link rel='stylesheet' href='./js/jquery-ui.css'>

<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  width: 100%;
  overflow : hidden;
}

.div1 {
  position: absolute;
  top: 10vw;
  left: 20vw;
  width: auto;
  height: auto;
}
</style>
";
echo "  
<script>
var vnome,vdescr;
var dialogFMsg;

$(function() {
    dialogFMsg = $('#dialog-message').dialog({
        autoOpen: false,
	modal: true,
	buttons: {
	    Ok: function() {
	       $( this ).dialog('close');
	    }
        }
    });   
});

function nextField(event,vfield) {
   if (event.key === 'Enter') {
      document.getElementById(vfield).focus();
   }
}

function fBack() { 
  $.post('saircx.php',
  function(data,status,xhr) {
     if (status === 'success') { 
         window.open('../','_top');
     }
  });

}

</script>
</head>
<body>
";

if (empty($usuario)) {
   echo "      
    <div class='div1' id='div1'>
    <form action='index.php' method='POST'> 
    <h1>TOOLS</h1>
    <fieldset>
    <label for='cmbProgram'>Programa:</label>

    <select id='cmbProgram' name='cmbProgram' onkeydown='nextField(event,\"txtCli\")'>
      <option value='01'>Hot Stamping</option>
      <option value='02'>Caixa Embarque</option>
      <option value='03'>Cartucho</option>

    </select>
    <br><br>
    <label for='txtCli'>Cod.Cliente:</label>
    <input type='text' id='txtCli' name='txtCli' style='width:3vw;' onkeydown='nextField(event,\"txtUser\")'></input>
    
    <label for='txtUser'>Cod.Usuario:</label>
    <input type='text' id='txtUser' name='txtUser' style='width:3vw;' onkeydown='nextField(event,\"txtPwd\")'></input>
    
    <label for='txtPwd'>Senha:</label>
    <input type='password' id='txtPwd' name='txtPwd' onkeydown='nextField(event,\"btnOK\")'></input>
    
    <button type='button' id='btnOK' onclick='this.form.submit()'>OK</button>
    <button type='button' id='btnBack' onclick='fBack()'>Voltar</button>
    <!--<button type='button' id='btnOK' onclick='Login()'>OK</button>-->
    <!--<input type='submit' id='btnOK' value='OK'>-->
    <br>
    ";
    if ($error == 1) { 
       echo "<p id='msg'>Usuario Invalido</p>";
    }
    else if ($error == 2) {
       echo "<p id='msg'>Usuario Não Autorizado</p>";
    }
    else if ($error == 3) {
       echo "<p id='msg'>Usuario Expirado</p>";
    }
    else {
       echo "<p id='msg'></p>";
    } 
    echo "</fieldset>";
    echo "</form>";


    echo "</div>";
    echo "<script>";
        
    echo "</script>";
  
}        
else {
   echo "<div>";
   //echo "<iframe src='".$vdescr."' style='position:absolute;top:0;right:0;height:100%; width:100%'></iframe>";
   echo "<iframe src='' id='frame' style='position:absolute;top:0;right:0;height:100%; width:100%'></iframe>";
   echo "</div>";    
   echo "<script>";
   echo "$(document).ready(function() {";
   echo "document.getElementById('frame').src = '".$vdescr."'";
   echo "})";
   echo "</script>";
}

//<div id='dialog-message' title='Message'>
//    <p id='txtmsg'>  </p>
//</div>
if (empty($usuario) || $error == 1) {
   if (empty($_SESSION['prog_choice'])) {
      $_SESSION['prog_choice']='01'; 
   }   
   echo " 
     <script>
       let vprog ='".$_SESSION['prog_choice']."';"."  
       document.getElementById('cmbProgram').value=vprog;
       document.getElementById('cmbProgram').focus();
     </script>
    ";
}    
echo "</body>";
echo "</html>";

