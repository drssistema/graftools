<?php
session_start();
if(empty($_SESSION['id'])){
	$_SESSION['msg'] = "Área restrita";
	header("Location: loginusr.php");	
	return;
}

require_once('../includes/conecta.php');

$action = "";
if (isset($_REQUEST["q"])) {
	$action = $_REQUEST["q"];
} else {
    return;	
}

//$action = '{'.$action.'}';
//$action = '{"pk":"0","transaction":"ins","table":"Card","tp":"PVC","descr":"PVC"}';
//echo $action;
//var_dump(json_decode($action));
$tipojson = json_decode($action);
//var_dump($tipojson);
$transaction = $tipojson->transaction;
//echo "transaction=".$transaction;
$table = $tipojson->table;
//echo "table=".$table;

if ($table == "User") {
    $conn = pdoConn();
   	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	$id = $tipojson->id;
	$nome = $tipojson->nome;   
	$email = $tipojson->email;
	$usuario = $tipojson->usuario;
	$senha = trim($tipojson->senha);
	$root = trim($tipojson->root);
	if ($senha!="")
       $senha = password_hash($senha, PASSWORD_DEFAULT);	
    $idins = 0;	
    try {
	    $conn->BeginTransaction();
		$msql = "";
		if ($transaction == "ins") {
           $mysql = "select max(id) as id from usuarios";
		   foreach ($conn->query($mysql) as $row) {
			  $idins  = $row['id']+1;
		   }
	       $msql = "insert into usuarios (id,nome,email,usuario,senha,root)
				    values (:idins,:nome,:email,:usuario,:senha,:root)"; 
	    }
		if ($transaction == "upd") {   
		   if ($senha!="")
	           $msql = "update usuarios set nome=:nome,email=:email,senha=:senha,root=:root where id=:id"; 
		   else {
		       $msql = "update usuarios set nome=:nome,email=:email,root=:root where id=:id"; 
		   }	   
	    }
		if ($transaction == "del") {         	    
	       $msql = "delete from usuarios where id=:id"; 
	    }
		//echo $msql;
	    $stmt = $conn->prepare($msql);
	    if ($transaction=="upd") {
		    $stmt->bindParam(':nome',$nome);
	        $stmt->bindParam(':email',$email);
	        $stmt->bindParam(':root',$root);
			if ($senha!="")
	            $stmt->bindParam(':senha',$senha);
	    }		
	    if ($transaction=="ins") {
		    $stmt->bindParam(':idins',$idins);
		    $stmt->bindParam(':nome',$nome);
	        $stmt->bindParam(':email',$email);
	        $stmt->bindParam(':usuario',$usuario);
	        $stmt->bindParam(':senha',$senha);
	        $stmt->bindParam(':root',$root);
	    }		
		if (intval($id)>0) {
  	        $stmt->bindParam(':id',$id);
		} 	
	    $stmt->execute();
		
        $conn->commit();
		
        $conn=null;
        $ret = array('codigo' => "OK",'error' => $idins,'pwd' => $senha);
        //header('Content-Type: application/json');
        echo json_encode($ret);
    } catch(PDOException $e) {
        $conn->rollBack();
        $conn=null;
        $ret = array('codigo' => "ERROR",'error' => $e->getMessage());
        //header('Content-Type: application/json');
        echo json_encode($ret);
    }
}



?>
