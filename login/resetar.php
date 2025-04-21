<?php
$valido = false;
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $conn = new mysqli("mysql.uhserver.com", "adm_principal", "688657Swf@", "dbferramentas", 3306);
    $stmt = $conn->prepare("SELECT db_usu_login FROM db_usuarios WHERE reset_token=? AND token_expira > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc()['db_usu_login'];
        $valido = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE db_usuarios SET db_usu_senha=?, reset_token=NULL, token_expira=NULL WHERE db_usu_login=?");
    $stmt->bind_param("ss", $novaSenha, $_POST['usuario']);
    $stmt->execute();
    echo "Senha redefinida com sucesso!";
    exit;
}
?>

<?php if ($valido): ?>
<form method="POST">
  <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">
  <input type="password" name="senha" placeholder="Nova senha" required>
  <button type="submit">Redefinir Senha</button>
</form>
<?php else: ?>
<p>Link expirado ou inválido.</p>
<?php endif; ?>
