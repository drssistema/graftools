<?php
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../includes/config.php';

    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT db_usu_id FROM db_usuarios WHERE db_usu_email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $stmt = $pdo->prepare("UPDATE db_usuarios SET reset_token = :token, reset_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE db_usu_id = :id");
        $stmt->execute(['token' => $token, 'id' => $user['db_usu_id']]);

        $link = "http://www.drssistemas.com.br/login/redefinir.php?token=$token";
        $mensagem = "Um link de redefinição de senha foi enviado para o seu e-mail.";

        // Enviar e-mail com o link de redefinição (implementar envio de e-mail aqui)
    } else {
        $mensagem = "E-mail não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="POST" action="recuperar.php">
        <h2>Recuperar Senha</h2>
        <?php if ($mensagem): ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>