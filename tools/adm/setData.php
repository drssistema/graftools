<?php
session_start();
require_once('../conecta.php');
require_once('../util.php');

//echo $_SESSION["OK"];


if (empty($_SESSION["OK"])) {
    //echo "session empty";
    return;
}

if (empty($_SESSION["PWD"])) {
   $ret = array('codigo' => "ERROR",'error' => "3");
   return;
}

$action = "";
if (isset($_REQUEST["q"])) {
   $action = $_REQUEST["q"];
}   
//$action = '{'.$action.'}';
//$action = '{"pk":"0","transaction":"ins","table":"Card","tp":"PVC","descr":"PVC"}';
//echo $action;
//var_dump(json_decode($action));
$tipojson = json_decode($action);
//var_dump($tipojson);
$transaction = $tipojson->t;
//echo "transaction=".$transaction;
$table = $tipojson->tb;
//echo "table=".$table;



if ($table == "usuario") {
    $conn = pdoConn();
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    $vcodcli = $tipojson->codcli;
    $vnome = $tipojson->nome;   
    $vcodusu = $tipojson->codusu;
    $vnomeusu = $tipojson->nomeusu;   
    //if (empty(trim($tipojson->senha)))
    $vsenha = encrypt($tipojson->senha);
    $vprogram = $tipojson->program;
    $vativo = $tipojson->ativo;
    $vvalidade = $tipojson->validade;
	
    $pkins = 0;	
    try {
	$conn->BeginTransaction();
	$msql = "";
	if ($transaction == "1") {
	    $msql = "insert into tbuser (codcli,nomecli,coduser,nomeuser,senha,program,ativo,validade)
	                 	 values (:codcli,:nomecli,:coduser,:nomeuser,:senha,:program,:ativo,:validade)";
        					
	}
	if ($transaction == "2") {         	    
   	    if (empty(trim($tipojson->senha))) {
	        $msql = "update tbuser set nomecli=:nomecli,nomeuser=:nomeuser,program=:program,ativo=:ativo,validade=:validade
                        where codcli=:codcli and coduser=:coduser";
            }    
            else { 
	        $msql = "update tbuser set nomecli=:nomecli,nomeuser=:nomeuser,senha=:senha,program=:program,ativo=:ativo,validade=:validade
                        where codcli=:codcli and coduser=:coduser";
            }	   
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from tbuser where codcli=:codcli and coduser=:coduser"; 
	}
		//echo $msql;
	$stmt = $conn->prepare($msql);
        if ($transaction=="2") {
            $stmt->bindParam(':nomecli',$vnome);
            $stmt->bindParam(':nomeuser',$vnomeusu);
            if (!empty(trim($tipojson->senha))) {
                $stmt->bindParam(':senha',$vsenha);
            }    
            $stmt->bindParam(':program',$vprogram);
            $stmt->bindParam(':ativo',$vativo);
            $stmt->bindParam(':validade',$vvalidade);
            $stmt->bindParam(':codcli',$vcodcli);
            $stmt->bindParam(':coduser',$vcodusu);
        }		
        if ($transaction=="1") {
            //echo $msql;
            $stmt->bindParam(':codcli',$vcodcli);
            $stmt->bindParam(':nomecli',$vnome);
            $stmt->bindParam(':coduser',$vcodusu);
            $stmt->bindParam(':nomeuser',$vnomeusu);
            $stmt->bindParam(':senha',$vsenha);
            $stmt->bindParam(':program',$vprogram);
            $stmt->bindParam(':ativo',$vativo);
            $stmt->bindParam(':validade',$vvalidade);
        }
        if ($transaction=="3") {
            $stmt->bindParam(':codcli',$vcodcli);
            $stmt->bindParam(':coduser',$vcodusu);
        }		
        $stmt->execute();

        $conn->commit();

        $conn=null;
        $ret = array('codigo' => "OK",'error' => $pkins);
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
