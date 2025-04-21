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
$op = $tipojson->op;
$arq = $tipojson->a;



if ($op == '0') { //get filenames
    // (A) GET FILES/FOLDERS
    $dir = "../backupData/";
    $all = array_diff(scandir($dir), [".", ".."]);
    $eol = PHP_EOL;

    // (B) LOOP THROUGH ALL
    $posts = '{"files":[';

    foreach ($all as $ff) {
      if (is_file($dir . $ff)) { 
         // echo "{$ff} {$eol};";
         $posts = $posts.'{';
         $posts = $posts.'"file":"'.$ff.'"';
         $posts = $posts.'},'; 	        
      }
      //if (is_dir($dir . $ff)) { echo "{$ff} - folder {$eol}"; }
    }
    $posts = rtrim($posts, ",");
    $posts = $posts.']}';
    echo $posts;
}

if ($op == '1') { //delete filename
   $file_pointer = "../backupData/".$arq; 
  
   // Use unlink() function to delete a file 
   if (!unlink($file_pointer)) { 
       $msg = $file_pointer." cannot be deleted due to an error"; 
       $ret = array('codigo' => "ERROR",'error' => $msg);
       echo json_encode($ret);
   } 
   else { 
     $msg = $file_pointer." has been deleted"; 
     $ret = array('codigo' => "OK",'error' => $msg);
     echo json_encode($ret);
   }     
    
    
}

if ($op  == '2') { //restore filename
    dbrestore("../backupData/".$arq);
}
if ($op  == '3') { //backup DB
    dbbackup();
}


function dbrestore($filename) {
  //$filename = 'backup.sql';
  $connection = mysqlconn(); 
  $handle = fopen($filename,"r+");
  $contents = fread($handle,filesize($filename));
  $sql = explode(';',$contents);
  $msg = ""; 
  foreach ($sql as $query){
    $query = str_replace(array("\n", "\r"), '', $query);
    if (empty($query)) {
        continue;
    }    
    try {     
      $result = mysqli_query($connection,$query);
      if ($result) {
         //echo '<tr><td><br></td></tr>';
         $msg .= $query. ' <b>SUCCESS</b><br>';
      }
    }  
    catch(mysqli_sql_exception $e) {
        $msg .= $query. ' <b>FAIL</b> error='.$e->getMessage().'<br>';
        
    }  
  }
  fclose($handle);
  $ret = array('codigo' => "OK",'error' => $msg);
  echo json_encode($ret);
  
  //echo 'Successfully imported';    
    
}

function dbbackup() {
    //connect to database using database credentials
    $dbConn = mysqlconn();

    //get all of the tables
    $tables = array();
    //fetch tables from database
    $result = mysqli_query($dbConn, 'SHOW TABLES');
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    $return = '';
    //cycle through tables
    foreach ($tables as $table) {
        //select data from table
        $result = mysqli_query($dbConn, 'SELECT * FROM ' . $table);
        $num_fields = mysqli_num_fields($result);
        
        //drop table
        $return.= 'DROP TABLE ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($dbConn, 'SHOW CREATE TABLE ' . $table));
        $return.= "\n\n" . $row2[1] . ";\n\n";

        //insert into statements for each table
        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $return.= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("#\n#", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return.= '"' . $row[$j] . '"';
                    } else {
                        $return.= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return.= ',';
                    }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //create a backup file
    $file = '../backupData/ToolsDB-' .date("Ymd").'-'.time() . '.sql';

    //write backup sql file to disk
    $handle = fopen($file, 'w+');
    fwrite($handle, $return);
    fclose($handle);
}
