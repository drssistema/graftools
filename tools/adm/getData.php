<?php
session_start();
require_once('../conecta.php');
require_once('../util.php');

//print_r($_SESSION);

if ($_SESSION["OK"] == '') {
    return;
}
if (empty($_SESSION["PWD"])) {
    return;
}


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
$table = $tipojson->tb;


if ($table == "usuario") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbuser';
   $posts = '{"usuario":[';
   foreach ($conn->query($sql) as $row) {
	$posts = $posts.'{';
	$posts = $posts.'"codcli":'.$row['codcli'].',';
	$posts = $posts.'"nome":"'.$row['nomecli'].'",';
	$posts = $posts.'"codusu":'.$row['coduser'].',';
	$posts = $posts.'"nomeusu":"'.$row['nomeuser'].'",';
	$posts = $posts.'"senha":"'.decrypt($row['senha']).'",';
	$posts = $posts.'"program":"'.$row['program'].'",';
	$posts = $posts.'"ativo":"'.$row['ativo'].'",';
	$posts = $posts.'"validade":"'.$row['validade'].'"';
	$posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}

if ($table == "usuariodata") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbuser where  codcli='.$search;
   //echo $sql;
   $posts = '{"usuario":[';
   foreach ($conn->query($sql) as $row) {
	$posts = $posts.'{';
	$posts = $posts.'"codcli":'.$row['codcli'].',';
	$posts = $posts.'"nome":"'.$row['nomecli'].'",';
	$posts = $posts.'"codusu":'.$row['coduser'].',';
	$posts = $posts.'"nomeusu":"'.$row['nomeuser'].'",';
	$posts = $posts.'"senha":"'.decrypt($row['senha']).'",';
	$posts = $posts.'"program":"'.$row['program'].'",';
	$posts = $posts.'"ativo":"'.$row['ativo'].'",';
	$posts = $posts.'"validade":"'.$row['validade'].'"';
	$posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
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

