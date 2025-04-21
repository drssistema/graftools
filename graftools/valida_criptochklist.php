<?php
session_start();
//include_once("conexao.php");
$btnLoginchklist = filter_input(INPUT_POST, 'btnLoginchklist', FILTER_SANITIZE_STRING);
if($btnLoginchklist)
{
    $usuario = "admin";
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    //echo "$usuario - $senha";
    if((!empty($usuario)) AND (!empty($senha)))
    {
        $_SESSION['msg'] = password_hash($senha, PASSWORD_DEFAULT);
        header("Location: geracriptochklist.php");
        
        //Gerar a senha criptografa
        //echo password_hash($senha, PASSWORD_DEFAULT);
        //Pesquisar o usuário no BD
        /*
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
				header("Location: geracripto.php");
			}
		}
        */

    }else
    {
        $_SESSION['msg'] = "Login e/ou Senha incorreto(s)";
        header("Location: geracriptochklist.php");
    }
}else
{
    $_SESSION['msg'] = "Usuário e/ou Senha incorreto(s)";
    header("Location: geracriptochklist.php");
}