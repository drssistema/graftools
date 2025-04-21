<?php
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



if ($table == "fornec") {
   checkFornec(); 
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbfornechs where codcli='.$vid_user;
   $posts = '{"fornec":[';
   foreach ($conn->query($sql) as $row) {
	      $posts = $posts.'{';
	      $posts = $posts.'"pk":'.$row['pk'].',';
	      $posts = $posts.'"codcli":"'.$row['codcli'].'",';
	      $posts = $posts.'"Fornecedor":"'.$row['fornecedor'].'",';
	      $posts = $posts.'"LarguraBobina":'.$row['larguraBobina'].',';
	      $posts = $posts.'"MinLineares":'.$row['minLineares'].',';
	      $posts = $posts.'"MaxMtsLineares":'.$row['maxMtsLineares'].'';
	      $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}

if ($table == "orchs") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tborchs where pk='.$search.' and codcli='.$vid_user;
   
   $posts = '{"orchs":[';
   foreach ($conn->query($sql) as $row) {
	  $posts = $posts.'{';
	  $posts = $posts.'"pk":'.$row['pk'].',';
	  $posts = $posts.'"data":"'.$row['data'].'",';
	  $posts = $posts.'"fornecedor":"'.$row['fornecedor'].'",';
	  $posts = $posts.'"indexFornecedor":"'.$row['indexFornecedor'].'",';
	  $posts = $posts.'"totalFolhas":"'.$row['totalFolhas'].'",';
	  $posts = $posts.'"longPull":"'.$row['longPull'].'",';

	  $posts = $posts.'"largBobina":"'.$row['largBobina'].'",';
	  $posts = $posts.'"largBobFornec":"'.$row['largBobFornec'].'",';
	  $posts = $posts.'"minLineares":"'.$row['minLineares'].'",';
	  $posts = $posts.'"maxLineares":"'.$row['maxLineares'].'",';
	  
	  $posts = $posts.'"largRolo":"'.$row['largRolo'].'",';
	  $posts = $posts.'"advancePull":"'.$row['advancePull'].'",';
	  $posts = $posts.'"shortPull1":"'.$row['shortPull1'].'",';
	  $posts = $posts.'"shortPullNo1":"'.$row['shortPullNo1'].'",';
	  $posts = $posts.'"shortPull2":"'.$row['shortPull2'].'",';
	  $posts = $posts.'"shortPullNo2":"'.$row['shortPullNo2'].'",';
	  $posts = $posts.'"longPull1":"'.$row['longPull1'].'",';
	  $posts = $posts.'"puxadaTotal":"'.$row['puxadaTotal'].'",';
	  $posts = $posts.'"totalBatidas":"'.$row['totalBatidas'].'",';
	  $posts = $posts.'"checkOption":"'.$row['checkOption'].'",';
	  $posts = $posts.'"puxarInfJob1":"'.$row['puxarInfJob1'].'",';
	  $posts = $posts.'"largRolo2":"'.$row['largRolo2'].'",';
	  $posts = $posts.'"advancePull2":"'.$row['advancePull2'].'",';
	  $posts = $posts.'"shortPull12":"'.$row['shortPull12'].'",';
	  $posts = $posts.'"shortPullNo12":"'.$row['shortPullNo12'].'",';
	  $posts = $posts.'"shortPull22":"'.$row['shortPull22'].'",';
	  $posts = $posts.'"shortPullNo22":"'.$row['shortPullNo22'].'",';
	  $posts = $posts.'"longPull12":"'.$row['longPull12'].'",';
	  $posts = $posts.'"puxadaTotal2":"'.$row['puxadaTotal2'].'",';
	  $posts = $posts.'"totalBatidas2":"'.$row['totalBatidas2'].'"';
	  $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}
if ($table == "orchsdata") {
   $conn = pdoConn();
   $vlimit = $tipojson->r;
   $sql = 'SELECT * FROM tborchs where codcli='.$vid_user.' order by data desc limit '.$vlimit;
   //echo $sql;
   $posts = '{"orchs":[';
   foreach ($conn->query($sql) as $row) {
	  $posts = $posts.'{';
	  $posts = $posts.'"pk":'.$row['pk'].',';
	  $posts = $posts.'"data":"'.$row['data'].'",';
	  $posts = $posts.'"fornecedor":"'.$row['fornecedor'].'",';
	  $posts = $posts.'"indexFornecedor":"'.$row['indexFornecedor'].'",';
	  $posts = $posts.'"totalFolhas":"'.$row['totalFolhas'].'",';
	  $posts = $posts.'"longPull":"'.$row['longPull'].'",';
	  $posts = $posts.'"largRolo":"'.$row['largRolo'].'",';
	  $posts = $posts.'"advancePull":"'.$row['advancePull'].'",';
	  $posts = $posts.'"shortPull1":"'.$row['shortPull1'].'",';
	  $posts = $posts.'"shortPullNo1":"'.$row['shortPullNo1'].'",';
	  $posts = $posts.'"shortPull2":"'.$row['shortPull2'].'",';
	  $posts = $posts.'"shortPullNo2":"'.$row['shortPullNo2'].'",';
	  $posts = $posts.'"longPull1":"'.$row['longPull1'].'",';
	  $posts = $posts.'"puxadaTotal":"'.$row['puxadaTotal'].'",';
	  $posts = $posts.'"totalBatidas":"'.$row['totalBatidas'].'",';
	  $posts = $posts.'"checkOption":"'.$row['checkOption'].'",';
	  $posts = $posts.'"puxarInfJob1":"'.$row['puxarInfJob1'].'",';
	  $posts = $posts.'"largRolo2":"'.$row['largRolo2'].'",';
	  $posts = $posts.'"advancePull2":"'.$row['advancePull2'].'",';
	  $posts = $posts.'"shortPull12":"'.$row['shortPull12'].'",';
	  $posts = $posts.'"shortPullNo12":"'.$row['shortPullNo12'].'",';
	  $posts = $posts.'"shortPull22":"'.$row['shortPull22'].'",';
	  $posts = $posts.'"shortPullNo22":"'.$row['shortPullNo22'].'",';
	  $posts = $posts.'"longPull12":"'.$row['longPull12'].'",';
	  $posts = $posts.'"puxadaTotal2":"'.$row['puxadaTotal2'].'",';
	  $posts = $posts.'"totalBatidas2":"'.$row['totalBatidas2'].'"';
	  $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}

if ($table == "orchsdatas") {
   $conn = pdoConn();
   $vlimit = $tipojson->r;
   $ymd = $search;
   //$ymd = DateTime::createFromFormat('d/m/Y', $search)->format('Y-m-d');
   $date = date_create_from_format("d/m/Y",$search);
   //echo "date=".$date;
   if (!empty($date)) {
      $ymd = date_format($date,"Y-m-d");
   }   
  
   
   $sql = 'SELECT * FROM tborchs where codcli='.$vid_user;
   $sql = $sql.' and (fornecedor like "%'.$search.'%"';
   $sql = $sql.' or data ="'.$ymd.'"';
   if (is_numeric($search)) {
       $sql = $sql.' or totalFolhas ='.$search;
       $sql = $sql.' or longPull ='.$search;
       $sql = $sql.' or largRolo ='.$search;
   }    
   $sql =  $sql.')';

   $sql = $sql.' order by data desc limit '.$vlimit;
   //echo $sql;
   $posts = '{"orchs":[';
   foreach ($conn->query($sql) as $row) {
	  $posts = $posts.'{';
	  $posts = $posts.'"pk":'.$row['pk'].',';
	  $posts = $posts.'"data":"'.$row['data'].'",';
	  $posts = $posts.'"fornecedor":"'.$row['fornecedor'].'",';
	  $posts = $posts.'"indexFornecedor":"'.$row['indexFornecedor'].'",';
	  $posts = $posts.'"totalFolhas":"'.$row['totalFolhas'].'",';
	  $posts = $posts.'"longPull":"'.$row['longPull'].'",';
	  $posts = $posts.'"largRolo":"'.$row['largRolo'].'",';
	  $posts = $posts.'"advancePull":"'.$row['advancePull'].'",';
	  $posts = $posts.'"shortPull1":"'.$row['shortPull1'].'",';
	  $posts = $posts.'"shortPullNo1":"'.$row['shortPullNo1'].'",';
	  $posts = $posts.'"shortPull2":"'.$row['shortPull2'].'",';
	  $posts = $posts.'"shortPullNo2":"'.$row['shortPullNo2'].'",';
	  $posts = $posts.'"longPull1":"'.$row['longPull1'].'",';
	  $posts = $posts.'"puxadaTotal":"'.$row['puxadaTotal'].'",';
	  $posts = $posts.'"totalBatidas":"'.$row['totalBatidas'].'",';
	  $posts = $posts.'"checkOption":"'.$row['checkOption'].'",';
	  $posts = $posts.'"puxarInfJob1":"'.$row['puxarInfJob1'].'",';
	  $posts = $posts.'"largRolo2":"'.$row['largRolo2'].'",';
	  $posts = $posts.'"advancePull2":"'.$row['advancePull2'].'",';
	  $posts = $posts.'"shortPull12":"'.$row['shortPull12'].'",';
	  $posts = $posts.'"shortPullNo12":"'.$row['shortPullNo12'].'",';
	  $posts = $posts.'"shortPull22":"'.$row['shortPull22'].'",';
	  $posts = $posts.'"shortPullNo22":"'.$row['shortPullNo22'].'",';
	  $posts = $posts.'"longPull12":"'.$row['longPull12'].'",';
	  $posts = $posts.'"puxadaTotal2":"'.$row['puxadaTotal2'].'",';
	  $posts = $posts.'"totalBatidas2":"'.$row['totalBatidas2'].'"';
	  $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}


function checkFornec() {
    global $vid_user;
   
    $conn = pdoConn();
   
    $sql = 'SELECT * FROM tbfornechs where codcli='.$vid_user;
    //echo $sql;
    $xcount = 0;
    foreach ($conn->query($sql) as $row) {
       $xcount++;  
    }
    //echo $xcount;
    if ($xcount > 0) {
       return; 
    }   
    
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	
    $pkins = 0;	
    try {
        $fornecedor = [];
        $LarguraBobina = [];
        $MinLineares = [];
        $MaxMtsLineares = [];

        $fornecedor[0] = 'CROWN/MP';
        $LarguraBobina[0] = '0.64';
        $MinLineares[0] = '61.0';
        $MaxMtsLineares[0] = '2440.00';
        
        $fornecedor[1] = 'KURZ';
        $LarguraBobina[1] = '0.61';
        $MinLineares[1] = '61.0';
        $MaxMtsLineares[1] = '2440.00';

        $conn->BeginTransaction();
        for ($i =0 ; $i < 2 ; $i++)
        {
            $mysql = "select max(pk) as pk from tbfornechs";
            foreach ($conn->query($mysql) as $row) {
                  if ($row['pk'] == NULL) {
                     $pkins = 1; 
                  }
                  else {  
                     $pkins  = $row['pk']+1;
                  }   
            }


            $msql = "insert into tbfornechs (pk,codcli,fornecedor,larguraBobina,minLineares,maxMtsLineares)
                                         values (:pkins,:codcli,:fornecedor,:larguraBobina,:minLineares,:maxMtsLineares)"; 
            //echo $msql;

            $stmt = $conn->prepare($msql);
            $stmt->bindParam(':pkins',$pkins);
            $stmt->bindParam(':codcli',$vid_user);
            $stmt->bindParam(':fornecedor',$fornecedor[$i]);
            $stmt->bindParam(':larguraBobina',$LarguraBobina[$i]);
            $stmt->bindParam(':minLineares',$MinLineares[$i]);
            $stmt->bindParam(':maxMtsLineares',$MaxMtsLineares[$i]);
            $stmt->execute();
        }	
        $conn->commit();
		
        $conn=null;
    } catch(PDOException $e) {
        $conn->rollBack();
        $conn=null;
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

