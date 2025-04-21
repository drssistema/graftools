<?php
session_start();
if(empty($_SESSION['id'])){
   $_SESSION['msg'] = "Área restrita";
   header("Location: ../index.php");	
   return;
}

require_once('../conecta.php');

if (empty($_SESSION["PWD"])) {
   return;
}

$table = "";
$search = "";
$pesq = "";
if (isset($_REQUEST["q"])) {
   $table = $_REQUEST["q"];
}   
if (isset($_REQUEST["s"])) {
   $search = $_REQUEST["s"];
}
if (isset($_REQUEST["p"])) {
   $pesq = $_REQUEST["p"];
   if (empty(trim($pesq)))
       return;
   $pesq = filter_var($pesq, FILTER_SANITIZE_STRING);
   
}

$vcodcli = $_SESSION['idcli'];

if ($table == "Card") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbcartao where codcli='.$vcodcli;
   //let text = '{"employees":[' +
   //'{"firstName":"John","lastName":"Doe" },' +
   //'{"firstName":"Anna","lastName":"Smith" },' +
   //'{"firstName":"Peter","lastName":"Jones" }]}';
   
   $posts = '{"cartao":[';
   foreach ($conn->query($sql) as $row) {
      $posts = $posts.'{';
      $posts = $posts.'"pk":'.$row['pk'].',';
      $posts = $posts.'"tpCartao":"'.$row['tpCartao'].'",';
      $posts = $posts.'"descricao":"'.$row['descricao'].'"';
      $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
}

if ($table == "Cardg") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbcartaogram where codcli='.$vcodcli.' order by tpCartao,gram';
   
   $posts = '{"cartaogram":[';
   foreach ($conn->query($sql) as $row) {
      //print_r($row);
      //echo "<tr>";
      //echo "<td>".number_format($row['gram'],0,',','.')."</td>";
      //echo "<td>".number_format($row['espessura'],4,',','.')."</td>";
      //echo "</tr>";
      $posts = $posts.'{';
      $posts = $posts.'"pk":'.$row['pk'].',';
      $posts = $posts.'"tpCartao":"'.$row['tpCartao'].'",';
      $posts = $posts.'"gram":"'.$row['gram'].'",';
      $posts = $posts.'"espessura":"'.$row['espessura'].'"';
      //$posts = $posts.'"gram":"'.number_format($row['gram'],0,',','.').'","espessura":"'.number_format($row['espessura'],4,',','.').'"';
      $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}
if ($table == "Caixa") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbcaixas where codcli='.$vcodcli;
   
   $posts = '{"caixa":[';
   foreach ($conn->query($sql) as $row) {
      $posts = $posts.'{';
      $posts = $posts.'"pk":'.$row['pk'].',';
      $posts = $posts.'"ncx":"'.$row['ncx'].'",';
      $posts = $posts.'"col":"'.$row['col'].'",';
      $posts = $posts.'"gm2":"'.$row['gm2'].'",';
      $posts = $posts.'"c":"'.$row['c'].'",';
      $posts = $posts.'"l":"'.$row['l'].'",';
      $posts = $posts.'"a":"'.$row['a'].'",';
      $posts = $posts.'"pallet":"'.$row['pallet'].'",';
      $posts = $posts.'"cantoneira":"'.$row['cantoneira'].'"';
      $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;   
}
if ($table == "Montagem") {
   checkMontag(); 
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbmontagem where codcli='.$vcodcli;


   
   $posts = '{"montagem":[';
   foreach ($conn->query($sql) as $row) {
      $posts = $posts.'{';
      $posts = $posts.'"pk":'.$row['pk'].',';
      $posts = $posts.'"codigo":"'.$row['codigo_montagem'].'",';
      $posts = $posts.'"descricao":"'.$row['descricao_colagem'].'",';
      $posts = $posts.'"sentido":"'.$row['sentido_cartucho'].'"';
     $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}

if ($table == "caixaemb") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM tbcxemb where pk='.$search.' and codcli='.$vcodcli;
   
   $posts = '{"caixaemb":[';
   foreach ($conn->query($sql) as $row) {
      $posts = $posts.'{';
      $posts = $posts.'"pk":'.$row['pk'].',';
      $posts = $posts.'"data":"'.$row['data'].'",';
      $posts = $posts.'"fechamento":"'.$row['fechamento'].'",';
      $posts = $posts.'"cartao":"'.$row['cartao'].'",';
      $posts = $posts.'"gramatura":"'.$row['gramatura'].'",';
      $posts = $posts.'"frente":"'.$row['frente'].'",';
      $posts = $posts.'"lateral":"'.$row['lateral'].'",';
      $posts = $posts.'"altura":"'.$row['altura'].'",';
      $posts = $posts.'"desc_lat":"'.$row['desc_lat'].'",';
      $posts = $posts.'"med_f_aut":"'.$row['med_f_aut'].'",';
      $posts = $posts.'"frente_lateral":"'.$row['frente_lateral'].'",';
      $posts = $posts.'"aba_cola":"'.$row['aba_cola'].'",';
      $posts = $posts.'"aba_superior":"'.$row['aba_superior'].'",';
      $posts = $posts.'"aba_inferior":"'.$row['aba_inferior'].'",';
      $posts = $posts.'"acrescimo_espessura":"'.$row['acrescimo_espessura'].'",';
      $posts = $posts.'"cx_ncx":"'.$row['cx_ncx'].'",';
      $posts = $posts.'"sentidoCartucho":"'.$row['sentidoCartucho'].'",';
      $posts = $posts.'"minimo_espaco":"'.$row['minimo_espaco'].'",';
      $posts = $posts.'"id_user":"'.$row['id_user'].'",';
      $posts = $posts.'"usuario":"'.$row['usuario'].'",';
      $posts = $posts.'"qtdereal":"'.$row['qtdereal'].'",';
      $posts = $posts.'"opt_qtdereal":"'.$row['opt_qtdereal'].'"';
      $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}
if ($table == "caixaembdata") {
   $conn = pdoConn();
   $vlimit = $search;
   $sql = 'SELECT * FROM tbcxemb where codcli='.$vcodcli.' order by data desc limit '.$vlimit;
   //echo $sql;
   $posts = '{"caixaemb":[';
   foreach ($conn->query($sql) as $row) {
      $posts = $posts.'{';
      $posts = $posts.'"pk":'.$row['pk'].',';
      $posts = $posts.'"data":"'.$row['data'].'",';
      $posts = $posts.'"fechamento":"'.$row['fechamento'].'",';
      $posts = $posts.'"cartao":"'.$row['cartao'].'",';
      $posts = $posts.'"gramatura":"'.$row['gramatura'].'",';
      $posts = $posts.'"frente":"'.$row['frente'].'",';
      $posts = $posts.'"lateral":"'.$row['lateral'].'",';
      $posts = $posts.'"altura":"'.$row['altura'].'",';
      $posts = $posts.'"desc_lat":"'.$row['desc_lat'].'",';
      $posts = $posts.'"med_f_aut":"'.$row['med_f_aut'].'",';
      $posts = $posts.'"frente_lateral":"'.$row['frente_lateral'].'",';
      $posts = $posts.'"aba_cola":"'.$row['aba_cola'].'",';
      $posts = $posts.'"aba_superior":"'.$row['aba_superior'].'",';
      $posts = $posts.'"aba_inferior":"'.$row['aba_inferior'].'",';
      $posts = $posts.'"acrescimo_espessura":"'.$row['acrescimo_espessura'].'",';
      $posts = $posts.'"cx_ncx":"'.$row['cx_ncx'].'",';
      $posts = $posts.'"sentidoCartucho":"'.$row['sentidoCartucho'].'",';
      $posts = $posts.'"minimo_espaco":"'.$row['minimo_espaco'].'",';
      $posts = $posts.'"id_user":"'.$row['id_user'].'",';
      $posts = $posts.'"usuario":"'.$row['usuario'].'",';
      $posts = $posts.'"qtdereal":"'.$row['qtdereal'].'",';
      $posts = $posts.'"opt_qtdereal":"'.$row['opt_qtdereal'].'"';
      $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}
if ($table == "caixaembdatas") {
   $conn = pdoConn();
   $vlimit = $search;
   $ymd = $pesq;
   //$ymd = DateTime::createFromFormat('d/m/Y', $search)->format('Y-m-d');
   $date = date_create_from_format("d/m/Y",$pesq);
   //echo "date=".$date;
   if (!empty($date)) {
      $ymd = date_format($date,"Y-m-d");
   }   

   $sql = 'SELECT * FROM tbcxemb where codcli='.$vcodcli;
   $sql = $sql.' and (fechamento like "%'.$pesq.'%"';
   $sql = $sql.' or cartao like "%'.$pesq.'%"';
   $sql = $sql.' or usuario like "%'.$pesq.'%"';
   if (!empty($date)) {
      $sql = $sql.' or data ="'.$ymd.'"';
   }   
   if (is_numeric($pesq)) {
       $sql = $sql.' or gramatura ='.$pesq;
       $sql = $sql.' or frente ='.$pesq;
       $sql = $sql.' or lateral ='.$pesq;
       $sql = $sql.' or altura ='.$pesq;
   }    
   $sql =  $sql.')';
   
   $sql = $sql.' order by data desc limit '.$vlimit;
   //echo $sql;
   $posts = '{"caixaemb":[';
   foreach ($conn->query($sql) as $row) {
      $posts = $posts.'{';
      $posts = $posts.'"pk":'.$row['pk'].',';
      $posts = $posts.'"data":"'.$row['data'].'",';
      $posts = $posts.'"fechamento":"'.$row['fechamento'].'",';
      $posts = $posts.'"cartao":"'.$row['cartao'].'",';
      $posts = $posts.'"gramatura":"'.$row['gramatura'].'",';
      $posts = $posts.'"frente":"'.$row['frente'].'",';
      $posts = $posts.'"lateral":"'.$row['lateral'].'",';
      $posts = $posts.'"altura":"'.$row['altura'].'",';
      $posts = $posts.'"desc_lat":"'.$row['desc_lat'].'",';
      $posts = $posts.'"med_f_aut":"'.$row['med_f_aut'].'",';
      $posts = $posts.'"frente_lateral":"'.$row['frente_lateral'].'",';
      $posts = $posts.'"aba_cola":"'.$row['aba_cola'].'",';
      $posts = $posts.'"aba_superior":"'.$row['aba_superior'].'",';
      $posts = $posts.'"aba_inferior":"'.$row['aba_inferior'].'",';
      $posts = $posts.'"acrescimo_espessura":"'.$row['acrescimo_espessura'].'",';
      $posts = $posts.'"cx_ncx":"'.$row['cx_ncx'].'",';
      $posts = $posts.'"sentidoCartucho":"'.$row['sentidoCartucho'].'",';
      $posts = $posts.'"minimo_espaco":"'.$row['minimo_espaco'].'",';
      $posts = $posts.'"id_user":"'.$row['id_user'].'",';
      $posts = $posts.'"usuario":"'.$row['usuario'].'",';
      $posts = $posts.'"qtdereal":"'.$row['qtdereal'].'",';
      $posts = $posts.'"opt_qtdereal":"'.$row['opt_qtdereal'].'"';
      $posts = $posts.'},'; 	  
   }
   $posts = rtrim($posts, ",");
   $posts = $posts.']}';
   echo $posts;
   $conn = null;
}

function checkMontag() {
    global $vcodcli;
   
    $conn = pdoConn();
   
    $sql = 'SELECT * FROM tbmontagem where codcli='.$vcodcli;
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
        $codigo = [];
        $descricao = [];
        $sentido = [];

        $codigo[0] = 'AHFC';
        $descricao[0] = 'Cartucho c// Colagem HOTMELT';
        $sentido[0] = '(Altura na FRENTE da CAIXA - Paisagem)';

        $codigo[1] = 'AHLC';
        $descricao[1] = 'Cartucho c// Colagem HOTMELT';
        $sentido[1] = '(Altura na LATERAL da CAIXA - Paisagem)';

        $codigo[2] = 'ACFC';
        $descricao[2] = 'Cartucho c// Colagem COMUM';
        $sentido[2] = '(Altura na FRENTE da CAIXA - Paisagem)';

        $codigo[3] = 'ACLC';
        $descricao[3] = 'Cartucho c// Colagem COMUM';
        $sentido[3] = '(Altura na LATERAL da CAIXA - Paisagem)';

        $codigo[4] = 'BFAF';
        $descricao[4] = 'Cartucho c// Colagem F. AUTOM';
        $sentido[4] = '(Base na FRENTE da CAIXA - Retrato)';

        $codigo[5] = 'BFAL';
        $descricao[5] = 'Cartucho c// Colagem F. AUTOM';
        $sentido[5] = '(Base na LATERAL da CAIXA - Retrato)';

        $codigo[6] = 'AFAF';
        $descricao[6] = 'Cartucho c// Colagem F. AUTOM';
        $sentido[6] = '(Altura na FRENTE da CAIXA - Paisagem)';

        $codigo[7] = 'AFAL';
        $descricao[7] = 'Cartucho c// Colagem F. AUTOM';
        $sentido[7] = '(Altura na LATERAL da CAIXA - Paisagem)';

        $conn->BeginTransaction();
        for ($i =0 ; $i < 8 ; $i++)
        {
            $mysql = "select max(pk) as pk from tbmontagem where codcli=".$vcodcli;
            foreach ($conn->query($mysql) as $row) {
                  if ($row['pk'] == NULL) {
                     $pkins = 1; 
                  }
                  else {  
                     $pkins  = $row['pk']+1;
                  }   
            }


            $msql = "insert into tbmontagem (pk,codcli,codigo_montagem,descricao_colagem,sentido_cartucho)
                                         values (:pkins,:codcli,:codigo,:descricao,:sentido)"; 
            //echo $msql;

            $stmt = $conn->prepare($msql);
            $stmt->bindParam(':pkins',$pkins);
            $stmt->bindParam(':codcli',$vcodcli);
            $stmt->bindParam(':codigo',$codigo[$i]);
            $stmt->bindParam(':descricao',$descricao[$i]);
            $stmt->bindParam(':sentido',$sentido[$i]);
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

