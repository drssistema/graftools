<?php
session_start();
include_once("..\includes\config.php");
$btnLoginchklist = filter_input(INPUT_POST, 'btnLoginchklist', FILTER_SANITIZE_STRING);
if($btnLoginchklist)
{
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    
    if((!empty($usuario)) AND (!empty($senha)))
    {
        //Gerar a senha criptografa
        //echo password_hash($senha, PASSWORD_DEFAULT);
        //Pesquisar o usuário no BD
        $result_usuario = "SELECT id, nome, email, senha FROM usu_chk_orc WHERE usuario='$usuario' LIMIT 1";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id'] = $row_usuario['id'];
				$_SESSION['nome'] = $row_usuario['nome'];
				$_SESSION['email'] = $row_usuario['email'];
				header("Location: checklist.php");
			}else{
				$_SESSION['msg'] = "Login e senha do Check-List está incorreto!";
				header("Location: loginchklist.php");
			}
		}
    }else
    {
        $_SESSION['msg'] = "Login e/ou Senha do Check-List está(ão) incorreta(s)";
        header("Location: loginchklist.php");
    }
}else
{
    $_SESSION['msg'] = "Usuário e/ou Senha do Check-List está(ão) incorreta(s)";
    header("Location: loginchklist.php");
}