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
        //Gerar a senha criptografa
        //echo password_hash($senha, PASSWORD_DEFAULT);
        //Pesquisar o usuário no BD
		//if ($usuario!="dsr" && $usuario!="trevor") {
		//	$_SESSION['msg'] = "Login e senha incorreto!";
		//	header("Location: loginusr.php");
		//	return;
		//}
        $result_usuario = "SELECT id, nome, email, senha,root FROM usuarios WHERE usuario='$usuario' LIMIT 1";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
            $root = $row_usuario['root'];
			if ($root!=1) {
				$_SESSION['msg'] = "Login e senha incorreto!";
				$_SESSION['id'] = "";
				$_SESSION['nome'] = "";
				$_SESSION['root'] = "";
				header("Location: loginusr.php");
				return;
			}	
			
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id'] = $row_usuario['id'];
				$_SESSION['nome'] = $row_usuario['nome'];
				$_SESSION['email'] = $row_usuario['email'];
				$_SESSION['root'] = $row_usuario['root'];
				//header("Location: user.php");
				$_SESSION['msg'] = "Login";
				header("Location: loginusr.php");
			}else{
				$_SESSION['id'] = "";
				$_SESSION['nome'] = "";
				$_SESSION['root'] = "";
				$_SESSION['msg'] = "Login e senha incorreto!";
				header("Location: loginusr.php");
			}
		}
    }else
    {
        $_SESSION['msg'] = "Login e/ou Senha incorreto(s)";
        header("Location: loginusr.php");
    }
}else
{
    $_SESSION['msg'] = "Usuário e/ou Senha incorreto(s)";
    header("Location: loginusr.php");
}