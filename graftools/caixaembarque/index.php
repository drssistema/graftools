<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Caixa Embarque</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='jquery-3.7.1.min.js'></script>

</head>
<body>
<script>
$(function () {
var iframe = document.createElement('iframe');
iframe.setAttribute('style', 'position:absolute;top:0;right:0;height:100%; width:100%');
document.body.appendChild(iframe);
iframe.src = 'caixaembarque.php';
});
</script>

</body>
</html>

