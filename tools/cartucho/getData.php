<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
//http://www.mydomain.example/index.php?argument1=arg1&argument2=arg2
session_start();
require_once('../conecta.php');

if(empty($_SESSION['id'])){
  $_SESSION['msg'] = "Área restrita";
  header("Location: ../index.php");	
  return;
}
if (empty($_SESSION["PWD"])) {
   return;
}


$vid_user = $_SESSION['idcli'];
$vusuario = $_SESSION['nome'];

$search = "";
if (isset($_REQUEST["s"])) {
   $search = $_REQUEST["s"];
   if (empty(trim($search)))
       return;
   $search = filter_var($search, FILTER_SANITIZE_STRING);
}    

//echo $search; 
$action = "";
if (isset($_REQUEST["q"])) {
   $action = $_REQUEST["q"];
} else {
    return;	
}
//echo $action;
$tipojson = json_decode($action);
//var_dump($tipojson);
$table = $tipojson->tb;


if ($table == 'template') {
    $arrFiles = glob('./templates/*.cxy');    

    $posts ='{"template":[';    
    for($i=0; $i<count($arrFiles); $i++) {
       $vfile = "./templates/".basename($arrFiles[$i]);   
       $myfile = fopen($vfile, "r") or die("Unable to open file!");
       $vlin =fgets($myfile);
       fclose($myfile);    
       $posts = $posts.'{';
       $posts = $posts.'"file":"'. basename($arrFiles[$i]).'","descr":"'.trim(substr($vlin,1)).'"';
       $posts = $posts.'},'; 	  
        
    }
    $posts = rtrim($posts, ",");
    $posts = $posts.']}';
    echo $posts;
}
if ($table == 'templates') {
    $arrFiles = glob('./templates/*.cxy');    

    $posts ='{"template":[';    
    for($i=0; $i<count($arrFiles); $i++) {
       $vfile = "./templates/".basename($arrFiles[$i]);   
       $myfile = fopen($vfile, "r") or die("Unable to open file!");
       $vlin =fgets($myfile);
       fclose($myfile);    
       $vlin1 = strtoupper(trim(substr($vlin,1)));
       $vlin2 = strtoupper(basename($arrFiles[$i]));
       $search = strtoupper($search);
       //echo $vlin1;
       //echo $vlin2;
       //echo $search;
       if (is_numeric(strpos($vlin1,$search)) || is_numeric(strpos($vlin2,$search)) ) {        
          $posts = $posts.'{';
          $posts = $posts.'"file":"'. basename($arrFiles[$i]).'","descr":"'.trim(substr($vlin,1)).'"';
          $posts = $posts.'},'; 	  
       } 
    }
    $posts = rtrim($posts, ",");
    $posts = $posts.']}';
    echo $posts;
}

if ($table == 'templateFile') {
    $vfile = "./templates/".$tipojson->file;   
    //echo $vfile;
    //$myfile = fopen($vfile, "r") or die("Unable to open file!");
    //echo fread($myfile,filesize($vfile));
    //fclose($myfile);   
    $myfile = fopen($vfile, "r") or die("Unable to open file!");
    // Output one line until end-of-file
    while(!feof($myfile)) {
      echo fgets($myfile);
    }
    fclose($myfile);    
    
}



if ($table == "cart") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbcartucho where codcli='.$vid_user;
   $posts = '{"cart":[';
   foreach ($conn->query($sql) as $row) {
	$posts = $posts.'{';
        $posts = $posts.'"cd":"'.$row['pk'].'",';
        $posts = $posts.'"dt":"'.$row['dtpk'].'",';
        $posts = $posts.'"cod":"'.$row['codigo'].'",';
        $posts = $posts.'"sig":"'.$row['sigla'].'",';
        $posts = $posts.'"desc":"'.$row['descricao'].'"';
        /*
        $posts = $posts.'"cp":'.$row['cp'].',';
        $posts = $posts.'"at":'.$row['at'].',';
        $posts = $posts.'"lt":'.$row['lt'].',';
        $posts = $posts.'"cl":'.$row['cl'].',';
        $posts = $posts.'"bc":'.$row['bc'].',';
        $posts = $posts.'"bleed":'.$row['bleed'].',';
        $tbcodemb = explode("<br>",$row['codemb']);
        $vsize = sizeof($tbcodemb);
        for ($i=0 ; $i<$vsize ; $i++) {
          $vcodemb1 = "codemb$i";  
          $posts = $posts.'"'.$vcodemb1.'":"'.$tbcodemb[$i].'",';
        }  
        $posts = $posts.'"size":'.$vsize;
        */
        $posts = $posts.'},'; 	  
        
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}
if ($table == "cartcod") {
   $conn = pdoConn();
   $vcod = $tipojson->cd;
   $sql = 'SELECT * FROM tbcartucho where codcli='.$vid_user.' and pk='.$vcod;
   $posts = '{"cart":[';
   foreach ($conn->query($sql) as $row) {
        $posts = $posts.'{"cd":"'.$row['pk'].'",';
        $posts = $posts.'"dt":"'.$row['dtpk'].'",';
        $posts = $posts.'"cod":"'.$row['codigo'].'",';
        $posts = $posts.'"sig":"'.$row['sigla'].'",';
        $posts = $posts.'"desc":"'.$row['descricao'].'",';
        $posts = $posts.'"cp":'.$row['cp'].',';
        $posts = $posts.'"at":'.$row['at'].',';
        $posts = $posts.'"lt":'.$row['lt'].',';
        $posts = $posts.'"cl":'.$row['cl'].',';
        $posts = $posts.'"bc":'.$row['bc'].',';
        $posts = $posts.'"bleed":'.$row['bleed'].',';
        $tbcodemb = explode("<br>",$row['codemb']);
        $vsize = sizeof($tbcodemb);
        for ($i=0 ; $i<$vsize ; $i++) {
          $vcodemb1 = "codemb$i";  
          $posts = $posts.'"'.$vcodemb1.'":"'.$tbcodemb[$i].'",';
        }  
        $posts = $posts.'"size":'.$vsize;
        $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}
if ($table == "carts") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbcartucho where codcli='.$vid_user;
   $limit  = $tipojson->r;
   
   $sql = $sql.' and (codigo like "%'.$search.'%"';
   $sql = $sql.' or sigla like "%'.$search.'%"';
   $sql = $sql.' or descricao like "%'.$search.'%")';
   $sql = $sql.' order by descricao limit '.$limit;
   
   $posts = '{"cart":[';
   foreach ($conn->query($sql) as $row) {
	$posts = $posts.'{';
        $posts = $posts.'"cd":"'.$row['pk'].'",';
        $posts = $posts.'"dt":"'.$row['dtpk'].'",';
        $posts = $posts.'"cod":"'.$row['codigo'].'",';
        $posts = $posts.'"sig":"'.$row['sigla'].'",';
        $posts = $posts.'"desc":"'.$row['descricao'].'"';
        /*
        $posts = $posts.'"cp":'.$row['cp'].',';
        $posts = $posts.'"at":'.$row['at'].',';
        $posts = $posts.'"lt":'.$row['lt'].',';
        $posts = $posts.'"cl":'.$row['cl'].',';
        $posts = $posts.'"bc":'.$row['bc'].',';
        $posts = $posts.'"bleed":'.$row['bleed'].',';
        $tbcodemb = explode("<br>",$row['codemb']);
        $vsize = sizeof($tbcodemb);
        for ($i=0 ; $i<$vsize ; $i++) {
          $vcodemb1 = "codemb$i";  
          $posts = $posts.'"'.$vcodemb1.'":"'.$tbcodemb[$i].'",';
        }  
        $posts = $posts.'"size":'.$vsize;
        */
        $posts = $posts.'},'; 	  
        
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}



if ($table == "cartmov") {
   $conn = pdoConn();
   $limit  = $tipojson->r;
   $sql = 'SELECT * FROM tbcartuchomv where codcli='.$vid_user;
   $sql = $sql.' order by data desc limit '.$limit;
   
   //echo $sql;
   $posts = '{"cartmov":[';
   foreach ($conn->query($sql) as $row) {
        $posts = $posts.'{"cd":"'.$row['pk'].'",';
        $posts = $posts.'"data":"'.$row['data'].'",';
        $posts = $posts.'"desc":"'.$row['descricao'].'",';
        $posts = $posts.'"cp":'.$row['cp'].',';
        $posts = $posts.'"at":'.$row['at'].',';
        $posts = $posts.'"lt":'.$row['lt'].',';
        $posts = $posts.'"cl":'.$row['cl'].',';
        $posts = $posts.'"bc":'.$row['bc'].',';
        $posts = $posts.'"bleed":'.$row['bleed'].',';
        $posts = $posts.'"interX":'.$row['interX'].',';
        $posts = $posts.'"interY":'.$row['interY'].',';
        $tbcodemb = explode("<br>",$row['codemb']);
        $vsize = sizeof($tbcodemb);
        for ($i=0 ; $i<$vsize ; $i++) {
          $vcodemb1 = "codemb$i";  
          $posts = $posts.'"'.$vcodemb1.'":"'.$tbcodemb[$i].'",';
        }  
        $posts = $posts.'"size":'.$vsize.',' ;
        $tbmontagem = explode("<br>",$row['montagem']);
        $vsizepos = sizeof($tbmontagem);
        for ($i=0 ; $i<$vsizepos ; $i++) {
          $vcodpos1 = "pos$i";  
          $posts = $posts.'"'.$vcodpos1.'":"'.$tbmontagem[$i].'",';
        }  
        $posts = $posts.'"sizepos":'.$vsizepos;

        $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}
if ($table == "cartmovs") {
   $conn = pdoConn();
   //echo $table;
   $limit  = $tipojson->r;
   //echo $limit;
   $ymd = $search;
   //$ymd = DateTime::createFromFormat('d/m/Y', $search)->format('Y-m-d');
   $date = date_create_from_format("d/m/Y",$search);
   //echo "date=".$date;
   if (!empty($date)) {
      $ymd = date_format($date,"Y-m-d");
   }   
   //echo $ymd;
   
   $sql = 'SELECT * FROM tbcartuchomv where codcli='.$vid_user;
   $sql = $sql.' and (descricao like "%'.$search.'%"';
   $sql = $sql.' or data ="'.$ymd.'")';
   $sql = $sql.' order by data desc limit '.$limit;
   
   //echo $sql;
   $posts = '{"cartmov":[';
   foreach ($conn->query($sql) as $row) {
        $posts = $posts.'{"cd":"'.$row['pk'].'",';
        $posts = $posts.'"data":"'.$row['data'].'",';
        $posts = $posts.'"desc":"'.$row['descricao'].'",';
        $posts = $posts.'"cp":'.$row['cp'].',';
        $posts = $posts.'"at":'.$row['at'].',';
        $posts = $posts.'"lt":'.$row['lt'].',';
        $posts = $posts.'"cl":'.$row['cl'].',';
        $posts = $posts.'"bc":'.$row['bc'].',';
        $posts = $posts.'"bleed":'.$row['bleed'].',';
        $posts = $posts.'"interX":'.$row['interX'].',';
        $posts = $posts.'"interY":'.$row['interY'].',';
        $tbcodemb = explode("<br>",$row['codemb']);
        $vsize = sizeof($tbcodemb);
        for ($i=0 ; $i<$vsize ; $i++) {
          $vcodemb1 = "codemb$i";  
          $posts = $posts.'"'.$vcodemb1.'":"'.$tbcodemb[$i].'",';
        }  
        $posts = $posts.'"size":'.$vsize.',' ;
        $tbmontagem = explode("<br>",$row['montagem']);
        $vsizepos = sizeof($tbmontagem);
        for ($i=0 ; $i<$vsizepos ; $i++) {
          $vcodpos1 = "pos$i";  
          $posts = $posts.'"'.$vcodpos1.'":"'.$tbmontagem[$i].'",';
        }  
        $posts = $posts.'"sizepos":'.$vsizepos;

        $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}



if ($table == "cartmovcod") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbcartuchomv where pk='.$tipojson->cd.' and codcli='.$vid_user;
   //echo $sql;
   $posts = '{"cartmov":[';
   foreach ($conn->query($sql) as $row) {
        $posts = $posts.'{';
	$posts = $posts.'"cd":'.$row['pk'].',';
	$posts = $posts.'"data":"'.$row['data'].'",';
        $posts = $posts.'"desc":"'.$row['descricao'].'",';
        $posts = $posts.'"cp":'.$row['cp'].',';
        $posts = $posts.'"at":'.$row['at'].',';
        $posts = $posts.'"lt":'.$row['lt'].',';
        $posts = $posts.'"cl":'.$row['cl'].',';
        $posts = $posts.'"bc":'.$row['bc'].',';
        $posts = $posts.'"bleed":'.$row['bleed'].',';
        $posts = $posts.'"interX":'.$row['interX'].',';
        $posts = $posts.'"interY":'.$row['interY'].',';
        $tbcodemb = explode("<br>",$row['codemb']);
        $vsize = sizeof($tbcodemb);
        for ($i=0 ; $i<$vsize ; $i++) {
          $vcodemb1 = "codemb$i";  
          $posts = $posts.'"'.$vcodemb1.'":"'.$tbcodemb[$i].'",';
        }  
        $posts = $posts.'"size":'.$vsize.',' ;
        $tbmontagem = explode("<br>",$row['montagem']);
        $vsizepos = sizeof($tbmontagem);
        for ($i=0 ; $i<$vsizepos ; $i++) {
          $vcodpos1 = "pos$i";  
          $posts = $posts.'"'.$vcodpos1.'":"'.$tbmontagem[$i].'",';
        }  
        $posts = $posts.'"sizepos":'.$vsizepos;

        $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}



if ($table == "maq") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbmaquina where codcli='.$vid_user;
   $posts = '{"maq":[';
   foreach ($conn->query($sql) as $row) {
	$posts = $posts.'{';
        $posts = $posts.'"cod":"'.$row['codigo'].'",';
        $posts = $posts.'"equipto":"'.$row['equipamento'].'",';
        $posts = $posts.'"alias":"'.$row['apelido'].'"';
        $posts = $posts.'},'; 	  
        
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}
if ($table == "maqcod") {
   $conn = pdoConn();
   $vcod = $tipojson->cod;
   $sql = 'SELECT * FROM tbmaquina where codcli='.$vid_user.' and codigo="'.$vcod.'"';
   $posts = '{"maq":[';
   foreach ($conn->query($sql) as $row) {
        $posts = $posts.'{"cod":"'.$row['codigo'].'",';
        $posts = $posts.'"equipto":"'.$row['equipamento'].'",';
        $posts = $posts.'"alias":"'.$row['apelido'].'",';
        $posts = $posts.'"larg_mancha":'.$row['larg_mancha'].',';
        $posts = $posts.'"compr_mancha":'.$row['compr_mancha'].',';
        $posts = $posts.'"larg_folha":'.$row['larg_folha'].',';
        $posts = $posts.'"compr_folha":'.$row['compr_folha'];
        $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}
if ($table == "maqs") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbmaquina where codcli='.$vid_user;
   $sql = $sql.' and (equipamento like "%'.$search.'%"';
   $sql = $sql.' or apelido like "%'.$search.'%"';
   $sql =  $sql.')';
   
   $posts = '{"maq":[';
   foreach ($conn->query($sql) as $row) {
	$posts = $posts.'{';
        $posts = $posts.'"cod":"'.$row['codigo'].'",';
        $posts = $posts.'"equipto":"'.$row['equipamento'].'",';
        $posts = $posts.'"alias":"'.$row['apelido'].'"';
        $posts = $posts.'},'; 	  
        
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
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

