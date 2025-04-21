<?php
session_start();
require_once('../conecta.php');

//echo "id=".$_SESSION['id'];

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


$action = $_REQUEST["q"];
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


$vcodcli = $vid_user;

if ($table == "fornec") {
    $conn = pdoConn();
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    $pk1 = $tipojson->pk;
    $vfornec = $tipojson->fornec;   
    $vlarguraBobina = $tipojson->larguraBobina;
    $vminLineares = $tipojson->minLineares;
    $vmaxMtsLineares = $tipojson->maxMtsLineares;
	
    $pkins = 0;	
    try {
	$conn->BeginTransaction();
	$msql = "";
	if ($transaction == "1") {
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
        					
	}
	if ($transaction == "2") {         	    
	    $msql = "update tbfornechs set fornecedor=:fornecedor,larguraBobina=:larguraBobina,minLineares=:minLineares,maxMtsLineares=:maxMtsLineares
                     where pk=:pk1"; 
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from tbfornechs where pk=:pk1"; 
	}
	//echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':fornecedor',$vfornec);
	    $stmt->bindParam(':larguraBobina',$vlarguraBobina);
	    $stmt->bindParam(':minLineares',$vminLineares);
	    $stmt->bindParam(':maxMtsLineares',$vmaxMtsLineares);
	}		
	if ($transaction=="1") {
	    //echo $msql;
	    $stmt->bindParam(':pkins',$pkins);
	    $stmt->bindParam(':codcli',$vcodcli);
	    $stmt->bindParam(':fornecedor',$vfornec);
	    $stmt->bindParam(':larguraBobina',$vlarguraBobina);
	    $stmt->bindParam(':minLineares',$vminLineares);
	    $stmt->bindParam(':maxMtsLineares',$vmaxMtsLineares);
	}		
	if (intval($pk1)>0) {
  	    $stmt->bindParam(':pk1',$pk1);
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

if ($table == "orchs") {
    $conn = pdoConn();
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    $pk1 = $tipojson->pk;
    $vdata = $tipojson->data;   
    $vfornec = $tipojson->fornecedor;   
    $vindexFornec = $tipojson->indexFornecedor;
    $vtotalFolhas = $tipojson->totalFolhas;
    $vlongPull = $tipojson->longPull;
    $vlargBobina = $tipojson->largBobina;
    $vlargBobFornec = $tipojson->largBobFornec;
    $vminLineares = $tipojson->minLineares;
    $vmaxLineares = $tipojson->maxLineares;
    $vlargRolo = $tipojson->largRolo;
    $vadvancePull = $tipojson->advancePull;
    $vshortPull1 = $tipojson->shortPull1;
    $vshortPullNo1 = $tipojson->shortPullNo1;
    $vshortPull2 = empty($tipojson->shortPull2) ? '0' : $tipojson->shortPull2;
    $vshortPullNo2 = empty($tipojson->shortPullNo2) ? '0' : $tipojson->shortPullNo2;
    $vlongPull1 = $tipojson->longPull1;
    $vpuxadaTotal = $tipojson->puxadaTotal;
    $vtotalBatidas = $tipojson->totalBatidas;
    $vcheckOption = $tipojson->checkOption;
    $vpuxarInfJob1 = $tipojson->puxarInfJob1;

    $vlargRolo2 = $tipojson->largRolo2;
    $vadvancePull2 = $tipojson->advancePull2;
    $vshortPull12 = $tipojson->shortPull12;
    $vshortPullNo12 = $tipojson->shortPullNo12;
    $vshortPull22 = empty($tipojson->shortPull22) ? '0' : $tipojson->shortPull22;
    $vshortPullNo22 = empty($tipojson->shortPullNo22) ? '0' : $tipojson->shortPullNo22;
    $vlongPull12 = $tipojson->longPull12;
    $vpuxadaTotal2 = $tipojson->puxadaTotal2;
    $vtotalBatidas2 = $tipojson->totalBatidas2;
	
    $pkins = 0;	
    try {
	$conn->BeginTransaction();
	$msql = "";
	if ($transaction == "1") {
           $mysql = "select max(pk) as pk from tborchs where codcli=".$vcodcli;
	   foreach ($conn->query($mysql) as $row) {
              if ($row['pk'] == NULL) {
                  $pkins = 1;
              } 
              else {
	         $pkins  = $row['pk']+1;
              }   
	   }
	   $msql = "insert into tborchs (pk,dtpk,codcli,data,fornecedor,indexFornecedor,totalFolhas,longPull,
		                          largBobina,largBobFornec,minLineares,maxLineares,
	   		                  largRolo,advancePull,shortPull1,shortPullNo1,shortPull2,shortPullNo2,
			                  longPull1,puxadaTotal,totalBatidas,checkOption,puxarInfJob1,
			                  largRolo2,advancePull2,shortPull12,shortPullNo12,shortPull22,shortPullNo22,
			                  longPull12,puxadaTotal2,totalBatidas2)
			    values (:pkins,:dtpk,:codcli,:data,:fornecedor,:indexFornecedor,:totalFolhas,:longPull,
			   	    :largBobina,:largBobFornec,:minLineares,:maxLineares,
		                    :largRolo,:advancePull,:shortPull1,:shortPullNo1,:shortPull2,:shortPullNo2,
				    :longPull1,:puxadaTotal,:totalBatidas,:checkOption,:puxarInfJob1,
				    :largRolo2,:advancePull2,:shortPull12,:shortPullNo12,:shortPull22,:shortPullNo22,
				    :longPull12,:puxadaTotal2,:totalBatidas2			
				    )";
        					
	}
	if ($transaction == "2") {         	    
	    $msql = "update tborchs set fornecedor=:fornecedor,indexFornecedor=:indexFornecedor,
		                        totalFolhas=:totalFolhas,longPull=:longPull,
					largBobina=:largBobina,largBobFornec=:largBobFornec,
					minLineares=:minLineares,maxLineares=:maxLineares,
		                        largRolo=:largRolo,advancePull=:advancePull,shortPull1=:shortPull1,
					shortPullNo1=:shortPullNo1,shortPull2=:shortPull2,shortPullNo2=:shortPullNo2,
					longPull1=:longPull1,puxadaTotal=:puxadaTotal,totalBatidas=:totalBatidas,
					checkOption=:checkOption,puxarInfJob1=:puxarInfJob1,
					largRolo2=:largRolo2,advancePull2=:advancePull2,shortPull12=:shortPull12,
					shortPullNo12=:shortPullNo12,shortPull22=:shortPull22,shortPullNo22=:shortPullNo22,
					longPull12=:longPull12,puxadaTotal2=:puxadaTotal2,totalBatidas2=:totalBatidas2
   		                        where pk=:pk1 and codcli=:codcli and dtpk=:dtpk";
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from tborchs where pk=:pk1 and codcli=:codcli and dtpk=:dtpk" ; 
	}
	//echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':fornecedor',$vfornec);
	    $stmt->bindParam(':indexFornecedor',$vindexFornec);
	    $stmt->bindParam(':totalFolhas',$vtotalFolhas);
	    $stmt->bindParam(':longPull',$vlongPull);
	    $stmt->bindParam(':largBobina',$vlargBobina);
	    $stmt->bindParam(':largBobFornec',$vlargBobFornec);
	    $stmt->bindParam(':minLineares',$vminLineares);
	    $stmt->bindParam(':maxLineares',$vmaxLineares);
			
	    $stmt->bindParam(':largRolo',$vlargRolo);
	    $stmt->bindParam(':advancePull',$vadvancePull);
	    $stmt->bindParam(':shortPull1',$vshortPull1);
	    $stmt->bindParam(':shortPullNo1',$vshortPullNo1);
	    $stmt->bindParam(':shortPull2',$vshortPull2);
	    $stmt->bindParam(':shortPullNo2',$vshortPullNo2);
	    $stmt->bindParam(':longPull1',$vlongPull1);
	    $stmt->bindParam(':puxadaTotal',$vpuxadaTotal);
	    $stmt->bindParam(':totalBatidas',$vtotalBatidas);
	    $stmt->bindParam(':checkOption',$vcheckOption);
	    $stmt->bindParam(':puxarInfJob1',$vpuxarInfJob1);
	    $stmt->bindParam(':largRolo2',$vlargRolo2);
	    $stmt->bindParam(':advancePull2',$vadvancePull2);
	    $stmt->bindParam(':shortPull12',$vshortPull12);
	    $stmt->bindParam(':shortPullNo12',$vshortPullNo12);
	    $stmt->bindParam(':shortPull22',$vshortPull22);
	    $stmt->bindParam(':shortPullNo22',$vshortPullNo22);
	    $stmt->bindParam(':longPull12',$vlongPull12);
	    $stmt->bindParam(':puxadaTotal2',$vpuxadaTotal2);
	    $stmt->bindParam(':totalBatidas2',$vtotalBatidas2);
			
	}		
	if ($transaction=="1") {
	    //echo $msql;
	    $stmt->bindParam(':pkins',$pkins);
	    $stmt->bindParam(':dtpk',$vdata);
	    $stmt->bindParam(':codcli',$vcodcli);
	    $stmt->bindParam(':data',$vdata);
	    $stmt->bindParam(':fornecedor',$vfornec);
	    $stmt->bindParam(':indexFornecedor',$vindexFornec);
	    $stmt->bindParam(':totalFolhas',$vtotalFolhas);
	    $stmt->bindParam(':longPull',$vlongPull);
	    $stmt->bindParam(':largBobina',$vlargBobina);
	    $stmt->bindParam(':largBobFornec',$vlargBobFornec);
	    $stmt->bindParam(':minLineares',$vminLineares);
	    $stmt->bindParam(':maxLineares',$vmaxLineares);
	    $stmt->bindParam(':largRolo',$vlargRolo);
	    $stmt->bindParam(':advancePull',$vadvancePull);
	    $stmt->bindParam(':shortPull1',$vshortPull1);
	    $stmt->bindParam(':shortPullNo1',$vshortPullNo1);
	    $stmt->bindParam(':shortPull2',$vshortPull2);
	    $stmt->bindParam(':shortPullNo2',$vshortPullNo2);
	    $stmt->bindParam(':longPull1',$vlongPull1);
	    $stmt->bindParam(':puxadaTotal',$vpuxadaTotal);
	    $stmt->bindParam(':totalBatidas',$vtotalBatidas);
	    $stmt->bindParam(':checkOption',$vcheckOption);
	    $stmt->bindParam(':puxarInfJob1',$vpuxarInfJob1);
	    $stmt->bindParam(':largRolo2',$vlargRolo2);
	    $stmt->bindParam(':advancePull2',$vadvancePull2);
	    $stmt->bindParam(':shortPull12',$vshortPull12);
	    $stmt->bindParam(':shortPullNo12',$vshortPullNo12);
	    $stmt->bindParam(':shortPull22',$vshortPull22);
	    $stmt->bindParam(':shortPullNo22',$vshortPullNo22);
	    $stmt->bindParam(':longPull12',$vlongPull12);
	    $stmt->bindParam(':puxadaTotal2',$vpuxadaTotal2);
	    $stmt->bindParam(':totalBatidas2',$vtotalBatidas2);
	}		
	if (intval($pk1)>0) {
	    //echo $msql;
  	    $stmt->bindParam(':pk1',$pk1);
  	    $stmt->bindParam(':codcli',$vcodcli);
  	    $stmt->bindParam(':dtpk',$vdata);
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
