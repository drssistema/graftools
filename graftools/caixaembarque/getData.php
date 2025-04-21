<?php
session_start();
if(empty($_SESSION['id'])){
	$_SESSION['msg'] = "Área restrita";
	header("Location: ../logincx.php");	
	return;
}

// require_once('conexao.php');
require_once('../../includes/config.php');

$table = "";
$search = "";
if (isset($_REQUEST["q"]))
	$table = $_REQUEST["q"];
if (isset($_REQUEST["s"]))
	$search = $_REQUEST["s"];


if ($table == "Card") {
   $conn = pdoConn();
   $sql = 'SELECT * FROM cartao';
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
   $sql = 'SELECT * FROM cartaogram order by tpCartao,gram';
   
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
   $sql = 'SELECT * FROM caixas';
   
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
   $conn = pdoConn();
   $sql = 'SELECT * FROM montagem';
   
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
   $sql = 'SELECT * FROM cxemb where pk='.$search;
   
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
   $sql = 'SELECT * FROM cxemb where Date(data)="'.$search.'"';
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

