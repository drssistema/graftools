<?php
session_start();
require_once('../../includes/conecta.php');

$search = "";
if (isset($_REQUEST["s"]))
	$search = $_REQUEST["s"];

$action = "";
if (isset($_REQUEST["q"])) {
	$action = $_REQUEST["q"];
} else {
    return;	
}
$tipojson = json_decode($action);
//var_dump($tipojson);
$table = $tipojson->table;


if ($table == "login") {
   $usuario = $tipojson->user;
   $senha = $tipojson->pwd;
   //$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
   //$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
   $usuario = filter_var($usuario, FILTER_SANITIZE_STRING);
   $senha = filter_var($senha, FILTER_SANITIZE_STRING);
   
   $conn = pdoConn();
   $sql = 'SELECT id, nome, email, senha FROM usuarios WHERE usuario="'.$usuario.'" LIMIT 1';
   //echo $sql;
   //let text = '{"employees":[' +
   //'{"firstName":"John","lastName":"Doe" },' +
   //'{"firstName":"Anna","lastName":"Smith" },' +
   //'{"firstName":"Peter","lastName":"Jones" }]}';
   $posts = '{"login":[';
   foreach ($conn->query($sql) as $row) {
 	   if (password_verify($senha, $row['senha'])){
		  $_SESSION['id'] = $row['id'];
		  $_SESSION['nome'] = $row['nome'];
	   	  $_SESSION['email'] = $row['email'];
	      $posts = $posts.'{';
	      //$posts = $posts.'"pk":'.$row['pk'].',';
	      $posts = $posts.'"nome":"'.$row['nome'].'",';
          $posts = $posts.'"descricao":"hotstamping.php"';
	      $posts = $posts.'},'; 	  
          $posts = rtrim($posts, ",");
          $posts = $posts.']}';
          echo $posts;
	   } else {
		  //$_SESSION['msg'] = "Login e senha incorreto!";
		  echo "";
		  //header("Location: index.php");
	   }
	  
   }
   
   
}


//number_format($row['VALORTOTAL'],2,',','.')

/*
$file = fopen('caixaembarque1.php', 'r');

if ($file) {
    while (($line = fgets($file)) !== false) {
        echo $line;
    }

    fclose($file);
} else {
    // error opening the file.
    //echo 'Cannot open file: myfile.txt';
}
*/
?>

