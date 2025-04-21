<?php
session_start();
if (empty($_SESSION['id'])){
    //$_SESSION['msg'] = "Área restrita";
    header("Location: ../index.php");	
    return;
}
if (empty($_SESSION["PWD"])) {
   return;
}


require_once('../conecta.php');
$action = "";

if (filter_input(INPUT_POST,"q", FILTER_DEFAULT)) {
   $action = filter_input(INPUT_POST,"q", FILTER_DEFAULT);  
}
else {
   return; 
}


//if (isset($_REQUEST["q"])) {
//   $action = $_REQUEST["q"];
//} else {
//   return;	
//}

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

$vcodcli = $_SESSION['idcli'];


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
	if ($transaction == "1") {
            $mysql = "select max(pk) as pk from tbcartao where codcli=".$vcodcli;
	    foreach ($conn->query($mysql) as $row) {
                if ($row['pk'] == NULL) {
                   $pkins = 1; 
                }
                else {
		  $pkins  = $row['pk']+1;
                }  
	    }  
	    $msql = "insert into tbcartao (pk,codcli,tpCartao,descricao)
				    values (:pkins,:codcli,:tpCard,:descrCard)"; 
	}
	if ($transaction == "2") {         	    
	    $msql = "update tbcartao set tpCartao=:tpCard,descricao=:descrCard where pk=:pk1 and codcli=:codcli"; 
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from tbcartao where pk=:pk1 and codcli=:codcli"; 
	}
	//echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':tpCard',$tpCard);
	    $stmt->bindParam(':descrCard',$descrCard);
	}		
	if ($transaction=="1") {
	    $stmt->bindParam(':pkins',$pkins);
	    $stmt->bindParam(':codcli',$vcodcli);
	    $stmt->bindParam(':tpCard',$tpCard);
	    $stmt->bindParam(':descrCard',$descrCard);
	}		
	if (intval($pk1)>0) {
  	    $stmt->bindParam(':pk1',$pk1);
  	    $stmt->bindParam(':codcli',$vcodcli);
	} 	
	$stmt->execute();
	if ($transaction == "3") {         	    
	    $msql1 = "delete from tbcartaogram where tpCartao=:tpCard and codcli=:codcli";
	    $stmt1 = $conn->prepare($msql1);
  	    $stmt1->bindParam(':tpCard',$tpCard);
  	    $stmt1->bindParam(':codcli',$vcodcli);
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
	if ($transaction == "1") {
            $mysql = "select max(pk) as pk from tbcartaogram where codcli=".$vcodcli;
	    foreach ($conn->query($mysql) as $row) {
              if ($row['pk'] == NULL) {
                 $pkins = 1; 
              }
              else {  
	        $pkins  = $row['pk']+1;
              }  
	    }
	    $msql = "insert into tbcartaogram (pk,codcli,tpCartao,gram,espessura)
				    values (:pkins,:codcli,:tpCard,:gram,:espessura)"; 
	}
	if ($transaction == "2") {         	    
	    $msql = "update tbcartaogram set gram=:gram,espessura=:espessura where pk=:pk1 and codcli=:codcli"; 
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from tbcartaogram where pk=:pk1 and codcli=:codcli"; 
	}
	//echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':gram',$gram);
	    $stmt->bindParam(':espessura',$espessura);
	}		
	if ($transaction=="1") {
	    $stmt->bindParam(':pkins',$pkins);
	    $stmt->bindParam(':codcli',$vcodcli);
	    $stmt->bindParam(':tpCard',$tpCard);
	    $stmt->bindParam(':gram',$gram);
	    $stmt->bindParam(':espessura',$espessura);
	}		
	if (intval($pk1)>0) {
  	    $stmt->bindParam(':pk1',$pk1);
  	    $stmt->bindParam(':codcli',$vcodcli);
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
	if ($transaction == "1") {
            $mysql = "select max(pk) as pk from tbcaixas where codcli=".$vcodcli;
	    foreach ($conn->query($mysql) as $row) {
               if ($row['pk'] == NULL) {
                  $pkins = 1; 
               } 
               else {
	          $pkins  = $row['pk']+1;
               }   
	    }
	    $msql = "insert into tbcaixas (pk,codcli,ncx,col,gm2,c,l,a,pallet,cantoneira)
				    values (:pkins,:codcli,:ncx,:col,:gm2,:comp,:larg,:alt,:pallet,:canton)"; 
	}
	if ($transaction == "2") {         	    
	    $msql = "update tbcaixas set ncx=:ncx,col=:col,gm2=:gm2,c=:comp,l=:larg,a=:alt,
                    pallet=:pallet,cantoneira=:canton where pk=:pk1 and codcli=:codcli"; 
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from tbcaixas where pk=:pk1 and codcli=:codcli"; 
	}
		//echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':ncx',$ncx);
	    $stmt->bindParam(':col',$col);
	    $stmt->bindParam(':gm2',$gm2);
	    $stmt->bindParam(':comp',$comp);
	    $stmt->bindParam(':larg',$larg);
	    $stmt->bindParam(':alt',$alt);
	    $stmt->bindParam(':pallet',$pallet);
	    $stmt->bindParam(':canton',$canton);
	}		
	if ($transaction=="1") {
	    $stmt->bindParam(':pkins',$pkins);
	    $stmt->bindParam(':codcli',$vcodcli);
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
  	    $stmt->bindParam(':codcli',$vcodcli);
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
	if ($transaction == "1") {
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
	}
	if ($transaction == "2") {         	    
	    $msql = "update tbmontagem set codigo_montagem=:codigo,descricao_colagem=:descricao,
		            sentido_cartucho=:sentido
 		             where pk=:pk1 and codcli=:codcli"; 
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from tbmontagem where pk=:pk1 and codcli=:codcli"; 
	}
	//echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':codigo',$codigo);
	    $stmt->bindParam(':descricao',$descricao);
	    $stmt->bindParam(':sentido',$sentido);
	}		
	if ($transaction=="1") {
	    $stmt->bindParam(':pkins',$pkins);
	    $stmt->bindParam(':codcli',$vcodcli);
	    $stmt->bindParam(':codigo',$codigo);
	    $stmt->bindParam(':descricao',$descricao);
	    $stmt->bindParam(':sentido',$sentido);
	}		
	if (intval($pk1)>0) {
  	    $stmt->bindParam(':pk1',$pk1);
  	    $stmt->bindParam(':codcli',$vcodcli);
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
	if ($transaction == "1") {
            $mysql = "select max(pk) as pk from tbcxemb where codcli=".$vcodcli;
	    foreach ($conn->query($mysql) as $row) {
              if ($row['pk'] == NULL) {
                 $pkins = 1; 
              } 
              else {
	         $pkins  = $row['pk']+1;
              }   
	    }
	    $msql = "insert into tbcxemb (pk,dtpk,codcli,data,fechamento,cartao,gramatura,frente,lateral,altura,
		                desc_lat,med_f_aut,frente_lateral,aba_cola,aba_superior,aba_inferior,
				acrescimo_espessura,cx_ncx,sentidoCartucho,minimo_espaco,id_user,usuario)
				values (:pkins,:dtpk,:codcli,:data,:fechamento,:cartao,:gramatura,:frente,:lateral,:altura,
				:desc_lat,:med_f_aut,:frente_lateral,:aba_cola,:aba_superior,:aba_inferior,
				:acrescimo_espessura,:cx_ncx,:sentidoCartucho,
				:minimo_espaco,:id_user,:usuario)"; 
	}
	if ($transaction == "2") {         	    
	    $msql = "update tbcxemb set fechamento=:fechamento,cartao=:cartao,
		            gramatura=:gramatura,frente=:frente,lateral=:lateral,altura=:altura,
	 		    desc_lat=:desc_lat,med_f_aut=:med_f_aut,frente_lateral=:frente_lateral,
			    aba_cola=:aba_cola,aba_superior=:aba_superior,aba_inferior=:aba_inferior,
			    acrescimo_espessura=:acrescimo_espessura,cx_ncx=:cx_ncx,sentidoCartucho=:sentidoCartucho,
			    minimo_espaco=:minimo_espaco,id_user=:id_user,usuario=:usuario
 		             where pk=:pk1 and codcli=:codcli and dtpk=:dtpk"; 
	}
	if ($transaction == "3") {         	    
	    $msql = "delete from cxemb where pk=:pk1 and codcli=:codcli and dtpk=:dtpk"; 
	}
	//echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
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
	if ($transaction=="1") {
	    $stmt->bindParam(':pkins',$pkins);
	    $stmt->bindParam(':dtpk',$data);
	    $stmt->bindParam(':codcli',$vcodcli);
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
  	    $stmt->bindParam(':codcli',$vcodcli);
            $stmt->bindParam(':dtpk',$data);
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
    $data = $tipojson->data;   
	
    $pkins = 0;	
    try {
        $conn->BeginTransaction();
        $msql = "update tbcxemb set qtdereal=:qtdereal,opt_qtdereal=:opt_qtdereal
 		             where pk=:pk1 and codcli=:codcli and  dtpk=:dtpk"; 
		//echo $msql;
        $stmt = $conn->prepare($msql);
        $stmt->bindParam(':qtdereal',$qtdereal);
        $stmt->bindParam(':opt_qtdereal',$opt_qtdereal);
        $stmt->bindParam(':pk1',$pk1);
        $stmt->bindParam(':codcli',$vcodcli);
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
