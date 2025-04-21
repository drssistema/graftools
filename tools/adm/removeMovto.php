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
//   return;
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
$vdata = $tipojson->dt;

//tborchs tbcxemb
//tbcaixas tbcartao tbcartaogram tbfornechs tbmaqhs tbmontagem

//$handle = fopen('../backupData/movto-'.date('Ymd').'-'.time().'.sql','w+');

try {
    $db = mysqlconn();
    
    $sql = "select * from tborchs where data < '".$vdata."'";

    $result = $db->query($sql);
    $numColumns = $result->field_count;
    $return = "";

    $fieldinfo = mysqli_fetch_fields($result);
    $vtype = [];
    $vtypeseq = 0;
    $vfield = "("; 
    foreach ($fieldinfo as $val) {
       $vfield .=  $val->name;
       $vfield .= ",";
       $vtype[$vtypeseq] = $val->type;
       $vtypeseq++;
    }
    $vfield = substr($vfield,0,strlen($vfield)-1);
    $vfield .= ")"; 

    for ($i = 0; $i < $numColumns; $i++) {
        while ($row = $result->fetch_row()) {
          $return .= "INSERT INTO tborchs".$vfield." VALUES(";
          for ($j = 0; $j < $numColumns; $j++) {
            $row[$j] = addslashes($row[$j]);
            //$row[$j] = ereg_replace("\n","\\n",$row[$j]);
            if (isset($row[$j])) {
                switch ($vtype[$j])
                {
                 case MYSQLI_TYPE_DECIMAL:
                 case MYSQLI_TYPE_NEWDECIMAL:
                 case MYSQLI_TYPE_FLOAT:
                 case MYSQLI_TYPE_DOUBLE:

                 case MYSQLI_TYPE_BIT:
                 case MYSQLI_TYPE_TINY:
                 case MYSQLI_TYPE_SHORT:
                 case MYSQLI_TYPE_LONG:
                 case MYSQLI_TYPE_LONGLONG:
                 case MYSQLI_TYPE_INT24:
                 case MYSQLI_TYPE_YEAR:
                 case MYSQLI_TYPE_ENUM:
                
                  $return .= $row[$j];
                  break;   
                 default:     
                  $return .= '"'.$row[$j].'"';
               }   
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
    //$handle = fopen('../backupData/tborchs-'.date('Ymd').'-'.time().'.sql','w+');
    //fwrite($handle,$return);
    //fclose($handle);
    $fileout = '../backupData/movto-orchs-'.date('Ymd').'-'.time().'.sql';
    if (file_put_contents($fileout,$return) === false)
       return;     

    //$msql = "delete from tborchs where data < '". $vdata."'"; 
    //$result = $db->query($sql);

    $sql = "select * from tbcxemb where data < '".$vdata."'";

    $result = $db->query($sql);
    $numColumns = $result->field_count;
    $return = "";

    $fieldinfo = mysqli_fetch_fields($result);
    $vtype = [];
    $vtypeseq = 0;
    $vfield = "("; 
    foreach ($fieldinfo as $val) {
       $vfield .=  $val->name;
       $vfield .= ",";
       $vtype[$vtypeseq] = $val->type;
       $vtypeseq++;
    }
    $vfield = substr($vfield,0,strlen($vfield)-1);
    $vfield .= ")"; 

    for ($i = 0; $i < $numColumns; $i++) {
        while ($row = $result->fetch_row()) {
          $return .= "INSERT INTO tbcxemb".$vfield." VALUES(";
          for ($j = 0; $j < $numColumns; $j++) {
            $row[$j] = addslashes($row[$j]);
            //$row[$j] = ereg_replace("\n","\\n",$row[$j]);
            if (isset($row[$j])) {
                switch ($vtype[$j])
                {
                 case MYSQLI_TYPE_DECIMAL:
                 case MYSQLI_TYPE_NEWDECIMAL:
                 case MYSQLI_TYPE_FLOAT:
                 case MYSQLI_TYPE_DOUBLE:

                 case MYSQLI_TYPE_BIT:
                 case MYSQLI_TYPE_TINY:
                 case MYSQLI_TYPE_SHORT:
                 case MYSQLI_TYPE_LONG:
                 case MYSQLI_TYPE_LONGLONG:
                 case MYSQLI_TYPE_INT24:
                 case MYSQLI_TYPE_YEAR:
                 case MYSQLI_TYPE_ENUM:
                
                  $return .= $row[$j];
                  break;   
                 default:     
                  $return .= '"'.$row[$j].'"';
               }   
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
    //$handle = fopen('../backupData/tborchs-'.date('Ymd').'-'.time().'.sql','w+');
    //fwrite($handle,$return);
    //fclose($handle);
    $fileout = '../backupData/movto-cxemb-'.date('Ymd').'-'.time().'.sql';
    if (file_put_contents($fileout,$return) === false)
       return;     

    //$msql = "delete from tborchs where data < '". $vdata."'"; 
    //$result = $db->query($sql);




    $sql = "delete from tborchs where data < '".$vdata."'";
    $result = $db->query($sql);
    
    $sql = "delete from tbcxemb where data < '".$vdata."'";
    $result = $db->query($sql);
    echo "OK";
    
} catch (Exception $e) { 
    echo $e->getMessage(); 
    
}

//$sql = "delete from tbcxemb where data < '".$vdata."'";
//$result = $db->query($sql);






function bkDb() {
    //connect & select the database
    $db = mysqlconn(); 

    //get all of the tables
    $tables = array();
    $result = $db->query("SHOW TABLES");
    while($row = $result->fetch_row()){
       $tables[] = $row[0];
    }

    //loop through the tables
    foreach($tables as $table){
        $result = $db->query("SELECT * FROM $table");
        $numColumns = $result->field_count;

        $return .= "DROP TABLE $table;";

        $result2 = $db->query("SHOW CREATE TABLE $table");
        $row2 = $result2->fetch_row();

        $return .= "\n\n".$row2[1].";\n\n";

        for($i = 0; $i < $numColumns; $i++){
            while($row = $result->fetch_row()){
                $return .= "INSERT INTO $table VALUES(";
                for($j=0; $j < $numColumns; $j++){
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return .= '"'.$row[$j].'"' ; } else { $return .= '""'; }
                    if ($j < ($numColumns-1)) { $return.= ','; }
                }
                $return .= ");\n";
            }
        }

        $return .= "\n\n\n";
    }

    //save file
    $handle = fopen('db-backup-'.time().'.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
}

function db_backup() {
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
    $file = 'db-backup-' . time() . '.sql';

    //write backup sql file to disk
    $handle = fopen($file, 'w+');
    fwrite($handle, $return);
    fclose($handle);
}

function dbrestore($filename) {
  //$filename = 'backup.sql';
  $connection = mysqlconn(); 
  $handle = fopen($filename,"r+");
  $contents = fread($handle,filesize($filename));
  $sql = explode(';',$contents);
  foreach ($sql as $query){
    $result = mysqli_query($connection,$query);
    if($result){
       echo '<tr><td><br></td></tr>';
       echo '<tr><td>'.$query.' <b>SUCCESS</b></td></tr>';
       echo '<tr><td><br></td></tr>';
    }
  }
  fclose($handle);
  echo 'Successfully imported';    
    
}

function backdb() {
  $connection = mysqlconn(); 
  $tables = array();
  $result = mysqli_query($connection,"SHOW TABLES");
  while($row = mysqli_fetch_row($result)){
     $tables[] = $row[0];
  }
  $return = '';
  foreach($tables as $table){
      $result = mysqli_query($connection,"SELECT * FROM ".$table);
      $num_fields = mysqli_num_fields($result);

      $return .= 'DROP TABLE '.$table.';';
      $row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
      $return .= "\n\n".$row2[1].";\n\n";

      for ($i=0;$i<$num_fields;$i++){
        while ($row = mysqli_fetch_row($result)){
          $return .= "INSERT INTO ".$table." VALUES(";
          for ($j=0;$j<$num_fields;$j++){
            $row[$j] = addslashes($row[$j]);
            if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
            else{ $return .= '""';}
            if($j<$num_fields-1){ $return .= ',';}
          }
          $return .= ");\n";
        }
      }
      $return .= "\n\n\n";
  }
  //save file
  $handle = fopen("backup".time().".sql","w+");
  fwrite($handle,$return);
  fclose($handle);
  echo "Successfully backed up";    
    
}