<?php
session_start();
if(empty($_SESSION['id'])){
	$_SESSION['msg'] = "Área restrita";
	header("Location: ../loginusr.php");	
	return;
}

require_once('..\includes\config.php');

$table = "";
$search = "";
if (isset($_REQUEST["q"]))
	$table = $_REQUEST["q"];
if (isset($_REQUEST["s"]))
	$search = $_REQUEST["s"];


if ($table == "User") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM usuarios';
   
   $posts = '{"user":[';
   foreach ($conn->query($sql) as $row) {
	  $posts = $posts.'{';
	  $posts = $posts.'"id":'.$row['id'].',';
	  $posts = $posts.'"nome":"'.$row['nome'].'",';
      $posts = $posts.'"email":"'.$row['email'].'",';
      $posts = $posts.'"usuario":"'.$row['usuario'].'",';
      $posts = $posts.'"senha":"'.$row['senha'].'",';
      $posts = $posts.'"root":"'.$row['root'].'"';
	  $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}

?>

