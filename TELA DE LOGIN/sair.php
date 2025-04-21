<?php
session_start();
unset($_SESSION['id_usuario']);
header("location: index.php");
echo "<script>window.alert('Você precisa se conectar para poder acessar a este formulário');</script>";
?>
