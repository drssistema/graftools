<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

session_start();
if(empty($_SESSION['id'])){
	//$_SESSION['msg'] = "Área restrita";
	header("Location: ../index.php");	
	return;
}


echo "<!DOCTYPE html>
<html>
<head>
<title>Caixa Embarque</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='../js/jquery-3.7.1.min.js'></script>

</head>
<body>
<script>
$(function () {
var iframe = document.createElement('iframe');
iframe.setAttribute('style', 'position:absolute;top:0;right:0;height:100%; width:100%');
document.body.appendChild(iframe);
iframe.src = 'menu.php';
});
</script>

</body>
</html>
";

