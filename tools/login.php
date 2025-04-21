<?php

session_start();
require_once('./conecta.php');
require_once('./util.php');

$search = "";

if (filter_input(INPUT_POST,"s", FILTER_DEFAULT)) {
   $search = filter_input(INPUT_POST,"s", FILTER_SANITIZE_STRING);  
}
$action = "";
if (filter_input(INPUT_POST,"q", FILTER_DEFAULT)) {
    $action = filter_input(INPUT_POST,"q", FILTER_DEFAULT);
} else {
    return;	
}
//echo $action;
$tipojson = json_decode($action);
//var_dump($tipojson);
$table = $tipojson->table;


if ($table == "login") {
   $usuario = filter_var($tipojson->user, FILTER_SANITIZE_STRING);
   $senha = filter_var($tipojson->pwd, FILTER_SANITIZE_STRING);
   $program = filter_var($tipojson->id, FILTER_SANITIZE_STRING);
   //$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
   //$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
   
   $conn = pdoConn();
   $sql = 'SELECT codcli, nome, senha, program FROM tbuser WHERE codcli='.$usuario.' LIMIT 1';
   //echo $sql;
   //let text = '{"employees":[' +
   //'{"firstName":"John","lastName":"Doe" },' +
   //'{"firstName":"Anna","lastName":"Smith" },' +
   //'{"firstName":"Peter","lastName":"Jones" }]}';
   $posts = '{"login":[';
   foreach ($conn->query($sql) as $row) {
       //if (password_verify($senha, $row['senha'])){
       //echo $senha;
       //echo $row['senha'];
       //echo decrypt($row['senha']);
       if ($senha ==  decrypt($row['senha'])){
	  $_SESSION['id'] = $row['codcli'];
	  $_SESSION['nome'] = $row['nome'];
          $posts = $posts.'{';
          //$posts = $posts.'"pk":'.$row['pk'].',';
          $posts = $posts.'"nome":"'.$row['nome'].'",';
	  $vprog = explode('-',$row['program']);
	  $vdescr = "";
          
	  if (in_array($program,$vprog)) {
              if ($program === "01") {
                 $vdescr = "./hotstamping/hotstamping.php";
              }   
              else if ($program === "02") {
                 $vdescr = "./caixaembarque/caixaembarque.php";
              }   
          } 	
          $posts = $posts.'"descricao":"'.$vdescr.'"';
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
?>