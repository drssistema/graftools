<?php
Class Usuario
{
    private $pdo;
    public $msgErro = "";

    public function conectar($nome, $host, $usuario, $senha)
    {
        global $pdo; 
        global $msgErro;
        try 
        {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
        }catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }
    public function cadastrar($nome, $telefone, $email, $senha)
    {
        global $pdo;
        //Verificar se já existe e-mail cadastrado.
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        $sql->bindValue(":e",$email);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            return false; //já está cadastrado
        }
        else //Caso não, Cadastrar
        {
            $sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
            $sql->bindValue(":n",$nome);
            $sql->bindValue(":t",$telefone);
            $sql->bindValue(":e",$email);
            $sql->bindValue(":s",md5($senha));
            $sql->execute();
            return true; //cadastrado com sucesso
        }
    }
    public function logar($email, $senha)
    {
        global $pdo;
        
        //Verificar se o email e senha estão cadastrados, se sim
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e",$email);      
        $sql->bindValue(":s",md5($senha));
        $sql->execute();

        if($sql->rowCount() > 0)
        {
            //entrar no sistema (sessão)
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; // sessão iniciada com sucesso!!!
        }
        else
        {
            return false; //não foi possível logar
        }
    }
}
?>