<?php
session_start();
include_once("..\includes\config.php");

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);

if($btnLogin) {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    if((!empty($usuario)) && (!empty($senha))) {
        $result_usuario = "SELECT * FROM usuarios WHERE usuario='$usuario' LIMIT 1";
        $resultado_usuario = mysqli_query($conn, $result_usuario);

        if($resultado_usuario && mysqli_num_rows($resultado_usuario) > 0) {
            $row_usuario = mysqli_fetch_assoc($resultado_usuario);
            $id_usuario = $row_usuario['id'];
            $logado = $row_usuario['logado'];
            $ultimo_login = $row_usuario['ultimo_login'];

            $pode_logar = true;

            // Verificar se já está logado e se houve atividade recente
            if($logado == 1 && $ultimo_login != null) {
                $data_atual = new DateTime();
                $ultimo_ativo = new DateTime($ultimo_login);
                $intervalo = $data_atual->getTimestamp() - $ultimo_ativo->getTimestamp();

                // Se a última atividade foi há menos de 5 minutos, bloquear login
                if($intervalo < 300) {
                    $pode_logar = false;
                }
            }

            if(!$pode_logar) {
                $_SESSION['msg'] = "Este usuário já está conectado em outro local.";
                header("Location: loginhot.php");
                exit();
            }

            // Verifica a senha
            if(password_verify($senha, $row_usuario['senha'])) {
                // Atualiza logado e último login
                $agora = date('Y-m-d H:i:s');
                $sql_logar = "UPDATE usuarios SET logado = 1, ultimo_login = '$agora' WHERE id = $id_usuario";
                mysqli_query($conn, $sql_logar);

                $_SESSION['id'] = $row_usuario['id'];
                $_SESSION['nome'] = $row_usuario['nome'];
                $_SESSION['email'] = $row_usuario['email'];

                header("Location: ./calculo_hotstamping/");
                exit();
            } else {
                $_SESSION['msg'] = "Login e senha incorretos!";
                header("Location: loginhot.php");
                exit();
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!";
            header("Location: loginhot.php");
            exit();
        }
    } else {
        $_SESSION['msg'] = "Preencha todos os campos!";
        header("Location: loginhot.php");
        exit();
    }
} else {
    $_SESSION['msg'] = "Acesso inválido!";
    header("Location: loginhot.php");
    exit();
}
