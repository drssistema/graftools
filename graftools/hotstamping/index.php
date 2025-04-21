<?php
session_start();
unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['email']);


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
var vnome,vdescr;
var dialogFMsg;

$(function() {
	dialogFMsg = $( "#dialog-message" ).dialog({
		  autoOpen: false,
		  modal: true,
		  buttons: {
			Ok: function() {
			  $( this ).dialog( "close" );
			}
		  }
	});   
});

function Login() {
	 var vuser = document.getElementById('txtUser').value;
	 var vpwd = document.getElementById('txtPwd').value;
	 var vnome = '';
	 var qtrans = '{"table":"login","user":"'+vuser+'","pwd":"'+vpwd+'"}';
	 //console.log(qtrans);
	 $.post('getData.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
		   //console.log(data);
		   try {
			   let obj1 = JSON.parse(data); 
			   let j = 0;
			   for (let i in obj1.login) {   
				 vnome = obj1.login[i].nome;
				 vdescr = obj1.login[i].descricao;
				 j++;
			   }	 
			   //console.log(vdescr);
			   document.getElementById('div1').style.display='none';
			   //document.getElementById('frame').src = '"'+vdescr+'"';
			   var iframe = document.createElement('iframe');
			   iframe.setAttribute('style', 'position:absolute;top:0;right:0;height:100%; width:100%');
			   document.body.appendChild(iframe);
			   iframe.src = vdescr;
		   } catch(error) {
			   //console.log(error);
               $('#txtmsg').text('Login e senha incorreto!');
               dialogFMsg.dialog('open');
			   
		   }	   
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
	
	
}

function nextField(event,vfield) {
   if (event.key == 'Enter') {
      document.getElementById(vfield).focus();
   }
}


</script>
</head>
<body>
<div class='div1' id='div1'>
<h1>HOTSTAMPING</h1>
<fieldset>
<label for='txtUser'>Usuário:</label>
<input type='text' id='txtUser' onkeydown='nextField(event,"txtPwd")'></input>
<label for='txtPwd'>Senha:</label>
<input type='password' id='txtPwd' onkeydown='nextField(event,"btnOK")'></input>
<button type='button' id='btnOK' onclick='Login()'>OK</button>
<br>
<p id='msg'></p>
</fieldset>

<?php
  if (isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
  }
?>

</div>

<div id='dialog-message' title='Message'>
    <p id='txtmsg'>  </p>
</div>
<script>
   document.getElementById('txtUser').focus();
</script>
</body>
</html>