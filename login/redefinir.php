<?php
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../includes/config.php';

    $token = $_POST['token'];
    $nova_senha = $_POST['nova_senha'];

    $stmt = $pdo->prepare("SELECT db_usu_id FROM db_usuarios WHERE reset_token = :token AND reset_expira > NOW()");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE db_usuarios SET db_usu_senha = :senha, reset_token = NULL, reset_expira = NULL WHERE db_usu_id = :id");
        $stmt->execute(['senha' => $hash, 'id' => $user['db_usu_id']]);
        $mensagem = "Senha redefinida
::contentReference[oaicite:0]{index=0}
 
