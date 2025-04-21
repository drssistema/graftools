<?php
session_start();
include_once("..\includes\config.php");
$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
if($btnLogin)
{
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    //echo "$usuario - $senha";
    if((!empty($usuario)) AND (!empty($senha)))
    {
        $_SESSION['msg'] = password_hash($usuario, PASSWORD_DEFAULT);
        header("Location: geracripto.php");
        $_SESSION['msg'] = password_hash($senha, PASSWORD_DEFAULT);
        header("Location: geracripto.php");
        
        /*
        //Gerar a senha criptografa
        echo "Copie para alguma área a senha criptografada.: (  ";
        echo "<br>";
        echo "<br>";
        echo password_hash($senha, PASSWORD_DEFAULT);
        echo "  )";
        //Pesquisar o usuário no BD
        
        $result_usuario = "SELECT id, nome, email, senha FROM usuarios WHERE usuario='$usuario' LIMIT 1";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id'] = $row_usuario['id'];
				$_SESSION['nome'] = $row_usuario['nome'];
				$_SESSION['email'] = $row_usuario['email'];
				header("Location: cadmp.php");
			}else{
				$_SESSION['msg'] = "Login e senha incorreto!";
				header("Location: geracriptologin.php");
			}
		}
        */
    }else
    {
        $_SESSION['msg'] = "Login e/ou Senha incorreto(s)";
        header("Location: geracripto.php");
    }
}else
{
    $_SESSION['msg'] = "Usuário e/ou Senha incorreto(s)";
    header("Location: geracripto.php");
}