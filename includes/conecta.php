<?php

$conn1=null;


function pdoConn() { 
   global $conn1;
   $arquivo = '{"dbserver": "remote","host":"mysql:host=mysql.uhserver.com;dbname=dbferramentas","user":"adm_principal","pwd":"688657Swf@"}';   
   //$arquivo = file_get_contents("server.php");
   $json = json_decode($arquivo);
   $DEBUG=false;
   if ($json->dbserver=="local")
      $DEBUG = true;
      
   try { 
      if ($DEBUG) {
         $conn1 = new PDO('mysql:host=localhost;dbname=dbferramentas',"root","");
      }   
      else { 
         //$conn1 = new PDO('mysql:host=drspedido.mysql.uhserver.com;dbname=drspedido',"drssistema3","drs@2469.5Y5t3M");
         $conn1 = new PDO($json->host,$json->user,$json->pwd);
      }   
   	$conn1->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
      return $conn1;           
   } catch(PDOException $e) {
      echo 'ERROR: '.$e->getMessage();
      return null;
   }

}
function pdoQuery($msql) { 
   global $conn1;
   try {
   	$conn1->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
      $data = $conn->query($msql);
      return $data;
   } catch(PDOException $e) { 
      echo 'ERROR: '.$e->getMessage();
      return null;
   }
}



function pdoBeginTrans() { 
   global $conn1;
   try { 
    
      $conn1->BeginTransaction();
   
   } catch(PDOException $e) {
      echo 'ERROR: '.$e->getMessage();
      return false;
   
   }

}

function pdoEndTrans() { 
   global $conn1;
   try { 
      $conn1->commit();
      return true;    
   } catch(PDOException $e) { 
      $conn1->rollBack();
      echo 'ERROR: '.$e->getMessage();
      return false;
   
   }

}


function mysqlconn() { 
    global $conn1;
    $arquivo = file_get_contents("server.json");
    $json = json_decode($arquivo);
    $DEBUG=false;
    if ($json["dbserver"]=="local")
       $DEBUG = true;
    if ($DEBUG)
       $conn1 = mysqli_connect("127.0.0.1","root","","dbgraf");
    else
       $conn1 = mysqli_connect("dbmy0012.whservidor.com","drssistema","drssistema","drssistema");
    if (mysqli_connect_errno()) {
        die('Could not connect: ' . mysqli_error($conn1));
        return false;
    }
     
    mysqli_query($conn1,"SET NAMES 'utf8'");
    mysqli_query($conn1,'SET character_set_connection=utf8');
    mysqli_query($conn1,'SET character_set_client=utf8');
    mysqli_query($conn1,'SET character_set_results=utf8');
    return true;
}

function mysqlquery($msql) { 
   global $conn1;
   //echo '<br>'.$msql.'<br>';
	$result = mysqli_query($conn1,$msql);
	if (!$result) {
	   die("ERRO3 - " . mysqli_error($conn1));
	}
   return $result;
 
}

function mysqlexec($msql) { 
   global $conn1;

	$result = mysqli_query($conn1,$msql);
	if (!$result) {
	   die("ERRO3 - " . mysqli_error($conn1));
	}
 
}

function beginTrans1() { 
   global $conn1;
   
   mysqli_autocommit($conn1,FALSE);
   if (mysqli_begin_transaction($conn1,MYSQLI_TRANS_START_READ_WRITE))
      return true;
   else 
      return false;   
   
}

function endTrans1() {
  global $conn1;
  if (!mysqli_commit($conn1)) { 
      mysqli_rollback($conn1);
      mysqli_autocommit($conn1,TRUE);
      return false;   
  }    
  mysqli_autocommit($conn1,TRUE);
  return true; 
}

function mysqlclose() { 
   global $conn1;
   mysqli_close($conn1);

}






?>


