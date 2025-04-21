<?php
session_start();
$vsenha = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $vsenha = test_input($_POST["txtPwd"]); 
   if ($vsenha == 'r00t__t00r' || $vsenha =='688657Swf@') {
       $_SESSION['OK'] = 'OK';
   }	   
   else {
       $vsenha = "";
       $_SESSION['OK'] = '';
   }	   
}	


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Usuario</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='../js/jquery-3.7.1.min.js'></script>
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
<script src="cprog.min.ob.js?version='2'"></script>


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
<script>


</script>
</head>
<body>
<div class='div1' id='div1'>

</div>
<?php
if (empty($vsenha)) {
    $x = htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "<form action=".$x." method='POST'>";
    echo "<label for='txtPwd'>Senha:</label>";
    echo "<input type='password' id='txtPwd' name='txtPwd'></input>"; 
    echo "<input type='submit' id='txtOK' value='OK'>";
    echo "</form>";
}
else {
   echo "
    <button onclick='showUser()'>Controle Cliente/Usuário</button>
    <button onclick='showBD()'>Manutenção BD</button>

   ";
}

echo "	
<div id='frmUser' title='Usuario'>
<div>
<table id='tableUser1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
<thead>
<tr>
<th>Cod.Cliente</th>
<th>Nome</th>
<th>Cod.Usu</th>
<th>Nome</th>
<th>Programa</th>
<th>Ativo</th>
<th>Validade</th>
</tr>
</thead>
<tbody id='tbodyUser'>
</tbody>
</table>
</div>
</div>
<div id='frmUserDetail' title='Usuario'>
<div>
<form id='formuser'> 
<input type='text' id='txtRowUser' name='txtRowUser' style='width:5vw;' disabled></input>
<input type='hidden' id='txtPUser' name='txtPUser' value='sdsdsdsdsdsd' style='width:5vw;' disabled></input>
<table>
<tr>
     <td>Cod.Cliente (NUMERICO)</td>
     <td><input type='text' id='txtCodcli' name='txtCodcli' disabled></input></td>
</tr>
<tr>
     <td>Nome</td>
     <td><input type='text' id='txtNome' name='txtNome' style='width:10vw' disabled></input></td>
</tr>
<tr>
     <td>Cod.Usu (NUMERICO)</td>
     <td><input type='text' id='txtCodUsu' name='txtCodUsu' disabled></input></td>
</tr>
<tr>
     <td>Nome</td>
     <td><input type='text' id='txtNomeUsu' name='txtNomeUsu' style='width:10vw' disabled></input></td>
</tr>

<tr>
     <td>Senha</td>
     <td><input type='text' id='txtSenha' name='txtSenha' style='width:10vw' disabled></input></td>
</tr>
<tr>
     <td>Programa 01-HotStamping 02-CaixaEmbarque 03-Cartucho<br>formato: 01-02 </td>
     <td><input type='text' id='txtProgram' name='txtProgram' style='width:10vw' disabled></input></td>

</tr>
<tr>
     <td>Ativo</td>
     <td>
        <input type='radio' id='txtAtivo1' name='txtAtivo' value='S' disabled></input>
            <label for='txtAtivo1'>SIM</label>
        <input type='radio' id='txtAtivo2' name='txtAtivo' value='N' disabled></input>
        <label for='txtAtivo2'>NÃO</label>
     </td>
</tr>
<tr>
     <td>Validade formato: 01/01/2024</td>
     <td><input type='text' id='txtValidade' name='txtValidade' style='width:10vw' disabled></input></td>
</tr>
</table>
</form>
</div>
</div>
";

echo "   
<div id='frmBD' title='Manutenção BD'>
<label for='txtCodCli'>Codigo Cliente</label>
<input type='text' id='txtCodCli'>
<button type='button' id='btnRemoveData' onclick='removeData()'>Remove Dados do Cliente</button>

<br>
<br>
<label for='txtData'>Remove dados de movto com data inferior a</label>
<input type='text' id='txtData'>
<button type='button' id='btnRemoveMovto' onclick='removeMovto()'>Remover Dados de Movto</button>

<br>
<br>
<button type='button' id='btnBackup' onclick='dbBackup()'>Fazer Backup do Banco de Dados</button>
<br>
<p>Arquivos de Backup</p>
<button type='button' id='btnRefresh' onclick='FileRefresh()'>Refresh ListBox</button>
<br>
<select name='Files' id='Files' size='10'>  
    <option value=''></option>  
</select>  
<br>
<p>Para restaurar/deletar selecione um item</p>
<button type='button' id='btnRestore' onclick='dbRestore()'>Restaurar Dados ou Banco de Dados</button>
<button type='button' id='btnDelItem' onclick='dbDelItem()'>Deleta Arquivo</button>

</div>

";

?>




    
    
<div id='dialog-delete' title='Atenção!'>
  <p>Deleta o item?</p><br>
  <p id='delItem'></p>  
</div>
    
<div id='dialog-warning' title='Atenção!'>
  <p>Continua?</p><br>
  <p id='varItem'></p>  
</div>

<div id='dialog-message' title='Message'>
    <p id='txtmsg'></p>
</div>

<div id='dialog-message2' title='Message'>
    <textarea id='txtmsg2' rows="4" cols="50"></textarea>
</div>
    
<script>


//makeTableUser();   

/*
$(document).ready(function() {
   makeTableUser();   
   if (!empty(vsenha)) {
      loadUser();
      getFile();
   }
});
*/




   
</script>
</body>
</html>