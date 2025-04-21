<?php
session_start();
if(empty($_SESSION['id'])){
	$_SESSION['msg'] = "Área restrita";
	header("Location: ../logincx.php");	
	return;
}

// require_once('conexao.php');
require_once('../../includes/config.php');

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

if ($table == "Card") {
    $conn = pdoConn();
   	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	$pk1 = $tipojson->pk;
	$tpCard = $tipojson->tp;   
	$descrCard = $tipojson->descr;
    $pkins = 0;	
    try {
	    $conn->BeginTransaction();
		$msql = "";
		if ($transaction == "ins") {
           $mysql = "select max(pk) as pk from cartao";
		   foreach ($conn->query($mysql) as $row) {
			  $pkins  = $row['pk']+1;
		   }
	       $msql = "insert into cartao (pk,tpCartao,descricao)
				    values (:pkins,:tpCard,:descrCard)"; 
	    }
		if ($transaction == "upd") {         	    
	       $msql = "update cartao set tpCartao=:tpCard,descricao=:descrCard where pk=:pk1"; 
	    }
		if ($transaction == "del") {         	    
	       $msql = "delete from cartao where pk=:pk1"; 
	    }
		//echo $msql;
	    $stmt = $conn->prepare($msql);
	    if ($transaction=="upd") {
		    $stmt->bindParam(':tpCard',$tpCard);
	        $stmt->bindParam(':descrCard',$descrCard);
	    }		
	    if ($transaction=="ins") {
		    $stmt->bindParam(':pkins',$pkins);
		    $stmt->bindParam(':tpCard',$tpCard);
	        $stmt->bindParam(':descrCard',$descrCard);
	    }		
		if (intval($pk1)>0) {
  	        $stmt->bindParam(':pk1',$pk1);
		} 	
	    $stmt->execute();
		if ($transaction == "del") {         	    
	       $msql1 = "delete from cartaogram where tpCartao=:tpCard";
		   $stmt1 = $conn->prepare($msql1);
  	       $stmt1->bindParam(':tpCard',$tpCard);
		   $stmt1->execute();
	    }
		
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

if ($table == "Cardg") {
    $conn = pdoConn();
   	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	$pk1 = $tipojson->pk;
	$tpCard = $tipojson->tpcard;   
	$gram = $tipojson->gramatura;
	$espessura = $tipojson->espessura;
    $pkins = 0;	
    try {
	    $conn->BeginTransaction();
		$msql = "";
		if ($transaction == "ins") {
           $mysql = "select max(pk) as pk from cartaogram";
		   foreach ($conn->query($mysql) as $row) {
			  $pkins  = $row['pk']+1;
		   }
	       $msql = "insert into cartaogram (pk,tpCartao,gram,espessura)
				    values (:pkins,:tpCard,:gram,:espessura)"; 
	    }
		if ($transaction == "upd") {         	    
	       $msql = "update cartaogram set gram=:gram,espessura=:espessura where pk=:pk1"; 
	    }
		if ($transaction == "del") {         	    
	       $msql = "delete from cartaogram where pk=:pk1"; 
	    }
		//echo $msql;
	    $stmt = $conn->prepare($msql);
	    if ($transaction=="upd") {
		    $stmt->bindParam(':gram',$gram);
	        $stmt->bindParam(':espessura',$espessura);
	    }		
	    if ($transaction=="ins") {
		    $stmt->bindParam(':pkins',$pkins);
		    $stmt->bindParam(':tpCard',$tpCard);
	        $stmt->bindParam(':gram',$gram);
	        $stmt->bindParam(':espessura',$espessura);
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

if ($table == "Cx") {
    $conn = pdoConn();
   	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	$pk1 = $tipojson->pk;
	$ncx = $tipojson->ncx;   
	$col = $tipojson->col;
	$gm2 = $tipojson->gm2;
	$comp = $tipojson->comp;
	$larg = $tipojson->larg;
	$alt = $tipojson->alt;
	$pallet = $tipojson->pallet;
	$canton = $tipojson->canton;
	
    $pkins = 0;	
    try {
	    $conn->BeginTransaction();
		$msql = "";
		if ($transaction == "ins") {
           $mysql = "select max(pk) as pk from caixas";
		   foreach ($conn->query($mysql) as $row) {
			  $pkins  = $row['pk']+1;
		   }
	       $msql = "insert into caixas (pk,ncx,col,gm2,c,l,a,pallet,cantoneira)
				    values (:pkins,:ncx,:col,:gm2,:comp,:larg,:alt,:pallet,:canton)"; 
	    }
		if ($transaction == "upd") {         	    
	       $msql = "update caixas set ncx=:ncx,col=:col,gm2=:gm2,c=:comp,l=:larg,a=:alt,
                    pallet=:pallet,cantoneira=:canton where pk=:pk1"; 
	    }
		if ($transaction == "del") {         	    
	       $msql = "delete from caixas where pk=:pk1"; 
	    }
		//echo $msql;
	    $stmt = $conn->prepare($msql);
	    if ($transaction=="upd") {
		    $stmt->bindParam(':ncx',$ncx);
	        $stmt->bindParam(':col',$col);
	        $stmt->bindParam(':gm2',$gm2);
	        $stmt->bindParam(':comp',$comp);
	        $stmt->bindParam(':larg',$larg);
	        $stmt->bindParam(':alt',$alt);
	        $stmt->bindParam(':pallet',$pallet);
	        $stmt->bindParam(':canton',$canton);
	    }		
	    if ($transaction=="ins") {
		    $stmt->bindParam(':pkins',$pkins);
		    $stmt->bindParam(':ncx',$ncx);
	        $stmt->bindParam(':col',$col);
	        $stmt->bindParam(':gm2',$gm2);
	        $stmt->bindParam(':comp',$comp);
	        $stmt->bindParam(':larg',$larg);
	        $stmt->bindParam(':alt',$alt);
	        $stmt->bindParam(':pallet',$pallet);
	        $stmt->bindParam(':canton',$canton);
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

if ($table == "Montag") {
    $conn = pdoConn();
   	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	$pk1 = $tipojson->pk;
	$codigo = $tipojson->Codigo;   
	$descricao = $tipojson->Descricao;
	$sentido = $tipojson->Sentido;
	
    $pkins = 0;	
    try {
	    $conn->BeginTransaction();
		$msql = "";
		if ($transaction == "ins") {
           $mysql = "select max(pk) as pk from montagem";
		   foreach ($conn->query($mysql) as $row) {
			  $pkins  = $row['pk']+1;
		   }
	       $msql = "insert into montagem (pk,codigo_montagem,descricao_colagem,sentido_cartucho)
				     values (:pkins,:codigo,:descricao,:sentido)"; 
	    }
		if ($transaction == "upd") {         	    
	       $msql = "update montagem set codigo_montagem=:codigo,descricao_colagem=:descricao,
		            sentido_cartucho=:sentido
 		             where pk=:pk1"; 
	    }
		if ($transaction == "del") {         	    
	       $msql = "delete from montagem where pk=:pk1"; 
	    }
		//echo $msql;
	    $stmt = $conn->prepare($msql);
	    if ($transaction=="upd") {
		    $stmt->bindParam(':codigo',$codigo);
	        $stmt->bindParam(':descricao',$descricao);
	        $stmt->bindParam(':sentido',$sentido);
	    }		
	    if ($transaction=="ins") {
		    $stmt->bindParam(':pkins',$pkins);
		    $stmt->bindParam(':codigo',$codigo);
	        $stmt->bindParam(':descricao',$descricao);
	        $stmt->bindParam(':sentido',$sentido);
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
if ($table == "caixaemb") {
    $conn = pdoConn();
   	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	$pk1 = $tipojson->pk;
    $data = $tipojson->data;   
	$fechamento = $tipojson->fechamento;   
	$cartao = $tipojson->cartao;
	$gramatura = $tipojson->gramatura;
	$frente = $tipojson->frente;
	$lateral = $tipojson->lateral;
	$altura = $tipojson->altura;
	$desc_lat = $tipojson->desc_lat;
	$med_f_aut = $tipojson->med_f_aut;
	$frente_lateral = $tipojson->frente_lateral;
	$aba_cola = $tipojson->aba_cola;
	$aba_superior = $tipojson->aba_superior;
	$aba_inferior = $tipojson->aba_inferior;
	$acrescimo_espessura = $tipojson->acrescimo_espessura;
	$cx_ncx = $tipojson->cx_ncx;
	$sentidoCartucho = $tipojson->sentidoCartucho;
	$minimo_espaco = $tipojson->minimo_espaco;
	$id_user = $tipojson->id_user;
	$usuario = $tipojson->usuario;
	
    $pkins = 0;	
    try {
	    $conn->BeginTransaction();
		$msql = "";
		if ($transaction == "ins") {
           $mysql = "select max(pk) as pk from cxemb";
		   foreach ($conn->query($mysql) as $row) {
			  $pkins  = $row['pk']+1;
		   }
	       $msql = "insert into cxemb (pk,data,fechamento,cartao,gramatura,frente,lateral,altura,
		             desc_lat,med_f_aut,frente_lateral,aba_cola,aba_superior,aba_inferior,
					 acrescimo_espessura,cx_ncx,sentidoCartucho,minimo_espaco,id_user,usuario)
				     values (:pkins,:data,:fechamento,:cartao,:gramatura,:frente,:lateral,:altura,
					 :desc_lat,:med_f_aut,:frente_lateral,:aba_cola,:aba_superior,:aba_inferior,
					 :acrescimo_espessura,:cx_ncx,:sentidoCartucho,
					 :minimo_espaco,:id_user,:usuario)"; 
	    }
		if ($transaction == "upd") {         	    
	       $msql = "update cxemb set fechamento=:fechamento,cartao=:cartao,
		            gramatura=:gramatura,frente=:frente,lateral=:lateral,altura=:altura,
					desc_lat=:desc_lat,med_f_aut=:med_f_aut,frente_lateral=:frente_lateral,
					aba_cola=:aba_cola,aba_superior=:aba_superior,aba_inferior=:aba_inferior,
					acrescimo_espessura=:acrescimo_espessura,cx_ncx=:cx_ncx,sentidoCartucho=:sentidoCartucho,
					minimo_espaco=:minimo_espaco,id_user=:id_user,usuario=:usuario
 		             where pk=:pk1"; 
	    }
		if ($transaction == "del") {         	    
	       $msql = "delete from cxemb where pk=:pk1"; 
	    }
		//echo $msql;
	    $stmt = $conn->prepare($msql);
	    if ($transaction=="upd") {
		    $stmt->bindParam(':fechamento',$fechamento);
	        $stmt->bindParam(':cartao',$cartao);
	        $stmt->bindParam(':gramatura',$gramatura);
	        $stmt->bindParam(':frente',$frente);
	        $stmt->bindParam(':lateral',$lateral);
	        $stmt->bindParam(':altura',$altura);
	        $stmt->bindParam(':desc_lat',$desc_lat);
	        $stmt->bindParam(':med_f_aut',$med_f_aut);
	        $stmt->bindParam(':frente_lateral',$frente_lateral);
	        $stmt->bindParam(':aba_cola',$aba_cola);
	        $stmt->bindParam(':aba_superior',$aba_superior);
	        $stmt->bindParam(':aba_inferior',$aba_inferior);
	        $stmt->bindParam(':acrescimo_espessura',$acrescimo_espessura);
	        $stmt->bindParam(':cx_ncx',$cx_ncx);
	        $stmt->bindParam(':sentidoCartucho',$sentidoCartucho);
	        $stmt->bindParam(':minimo_espaco',$minimo_espaco);
	        $stmt->bindParam(':id_user',$id_user);
	        $stmt->bindParam(':usuario',$usuario);
	    }		
	    if ($transaction=="ins") {
		    $stmt->bindParam(':pkins',$pkins);
		    $stmt->bindParam(':data',$data);
		    $stmt->bindParam(':fechamento',$fechamento);
	        $stmt->bindParam(':cartao',$cartao);
	        $stmt->bindParam(':gramatura',$gramatura);
	        $stmt->bindParam(':frente',$frente);
	        $stmt->bindParam(':lateral',$lateral);
	        $stmt->bindParam(':altura',$altura);
	        $stmt->bindParam(':desc_lat',$desc_lat);
	        $stmt->bindParam(':med_f_aut',$med_f_aut);
	        $stmt->bindParam(':frente_lateral',$frente_lateral);
	        $stmt->bindParam(':aba_cola',$aba_cola);
	        $stmt->bindParam(':aba_superior',$aba_superior);
	        $stmt->bindParam(':aba_inferior',$aba_inferior);
	        $stmt->bindParam(':acrescimo_espessura',$acrescimo_espessura);
	        $stmt->bindParam(':cx_ncx',$cx_ncx);
	        $stmt->bindParam(':sentidoCartucho',$sentidoCartucho);
	        $stmt->bindParam(':minimo_espaco',$minimo_espaco);
	        $stmt->bindParam(':id_user',$id_user);
	        $stmt->bindParam(':usuario',$usuario);
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

if ($table == "caixaembupd") {
    $conn = pdoConn();
   	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
	$pk1 = $tipojson->pk;
	$qtdereal = $tipojson->qtdereal;
	$opt_qtdereal = $tipojson->opt_qtdereal;
	
    $pkins = 0;	
    try {
	    $conn->BeginTransaction();
        $msql = "update cxemb set qtdereal=:qtdereal,opt_qtdereal=:opt_qtdereal
 		             where pk=:pk1"; 
		//echo $msql;
	    $stmt = $conn->prepare($msql);
        $stmt->bindParam(':qtdereal',$qtdereal);
        $stmt->bindParam(':opt_qtdereal',$opt_qtdereal);
        $stmt->bindParam(':pk1',$pk1);
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
