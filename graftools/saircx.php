<?php
session_start();
include_once("../includes/config.php");

// Recupera o ID do usuário logado
$id_usuario = $_SESSION['id'] ?? 0;

// Atualiza status de login no banco
if ($id_usuario > 0) {
    $sql_logout = "UPDATE usuarios SET logado = 0 WHERE id = $id_usuario";
    mysqli_query($conn, $sql_logout);
}

// Limpa a sessão
session_unset();
session_destroy();

session_start();
$_SESSION['msg'] = "Deslogado com sucesso!";
header("Location: logincx.php");
exit();