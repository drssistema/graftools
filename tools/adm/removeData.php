<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

session_start();
require_once('../conecta.php');
require_once('../util.php');

//print_r($_SESSION);

//if ($_SESSION["OK"] == '') {
//    return;
//}
if (empty($_SESSION["PWD"])) {
    return;
}
$action = "";
if (isset($_REQUEST["q"])) {
    $action = $_REQUEST["q"];
} else {
    return;	
}
$tipojson = json_decode($action);
//var_dump($tipojson);
$vcodcli = $tipojson->id;

//tborchs tbcxemb
//tbcaixas tbcartao tbcartaogram tbfornechs tbmaqhs tbmontagem
//$handle = fopen('../backupData/'.$vcodcli.'-'.date('Ymd').'-'.time().'.sql','w+');
try {
    $fileout = '../backupData/'.$vcodcli.'-'.date('Ymd').'-'.time().'.sql';
    file_put_contents($fileout,"");

    $db = mysqlconn();
    $sql = "select * from tborchs where codcli = ".$vcodcli;

    if (removeData($sql,"tborchs")) {
       $msql = "delete from tborchs where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
            
    $sql = "select * from tbcxemb where codcli = ".$vcodcli;
    if (removeData($sql,"tbcxemb")) {
       $msql = "delete from tbcxemb where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbcaixas where codcli = ".$vcodcli;
    if (removeData($sql,"tbcaixas")) {
       $msql = "delete from tbcaixas where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbcartao where codcli = ".$vcodcli;
    if (removeData($sql,"tbcartao")) {
       $msql = "delete from tbcartao where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbcartaogram where codcli = ".$vcodcli;
    if (removeData($sql,"tbcartaogram")) {
       $msql = "delete from tbcartaogram where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbfornechs where codcli = ".$vcodcli;
    if (removeData($sql,"tbfornechs")) {
       $msql = "delete from tbfornechs where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbmaqhs where codcli = ".$vcodcli;
    if (removeData($sql,"tbmaqhs")) {
       $msql = "delete from tbmaqhs where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbmontagem where codcli = ".$vcodcli;
    if (removeData($sql,"tbmontagem")) {
       $msql = "delete from tbmontagem where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbcartucho where codcli = ".$vcodcli;
    if (removeData($sql,"tbcartucho")) {
       $msql = "delete from tbcartucho where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbcartuchomv where codcli = ".$vcodcli;
    if (removeData($sql,"tbcartuchomv")) {
       $msql = "delete from tbcartuchomv where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    $sql = "select * from tbmaquina where codcli = ".$vcodcli;
    if (removeData($sql,"tbmaquina")) {
       $msql = "delete from tbmaquina where codcli =". $vcodcli; 
       $result = $db->query($msql);
    }
    
    echo "OK";
} catch (Exception $e) { 
    echo $e->getMessage(); 
}
//fclose($handle);


function removeData($sql,$table) {
    global $db,$fileout;
    $result = $db->query($sql);
    $numColumns = $result->field_count;
    $return = "";
    
    $fieldinfo = mysqli_fetch_fields($result);
    $vfield = "("; 
    foreach ($fieldinfo as $val) {
       $vfield .=  $val->name;
       $vfield .= ",";
    }
    $vfield = substr($vfield,0,strlen($vfield)-1);
    $vfield .= ")"; 
    
    for ($i = 0; $i < $numColumns; $i++) {
        while ($row = $result->fetch_row()) {
          $return .= "INSERT INTO ". $table .$vfield." VALUES(";
          for ($j = 0; $j < $numColumns; $j++) {
            $row[$j] = addslashes($row[$j]);
            //$row[$j] = ereg_replace("\n","\\n",$row[$j]);
            if (isset($row[$j])) {
               $return .= '"'.$row[$j].'"';
            }
            else {
               $return .= '""';  
            }
            if ($j < ($numColumns-1)) {
                $return .= ',';
            }
          }
          $return .= ");\n";
        }
        //$return .= "\n\n\n";
    } 
    if (file_put_contents($fileout,$return,FILE_APPEND) === false)
       return false;
    
    return true;
    
    //$handle = fopen('../backupData/'.$table.'-'.$vcodcli.'-'.date('Ymd').'-'.time().'.sql','w+');
    //fwrite($handle,$return);
    //fclose($handle);

    //$msql = "delete from ".$table." where codcli =". $vcodcli; 
    //$result = $db->query($msql);
}
