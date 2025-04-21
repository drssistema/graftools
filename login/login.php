<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'conexao.php';

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT db_usu_senha FROM db_usuarios WHERE db_usu_login = :usuario");
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['db_usu_senha'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        exit();
    } else {
        $erro = 'Usuário ou senha inválidos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <?php if ($erro): ?>
            <p><?php echo $erro; ?></p>
        <?php endif; ?>
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <button type="submit">Entrar</button>
        <a href="recuperar.php">Esqueci minha senha</a>
    </form>
</body>
</html>
