<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

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

 
//echo "action=".$action;
//var_dump(json_decode($action));
$tipojson = json_decode($action,true);
//var_dump($tipojson);
$transaction = $tipojson["t"];
//echo "transaction=".$transaction;
$table = $tipojson["tb"];
//echo "table=".$table;
//$transaction="";


if ($table == "cart") {
    $conn = pdoConn();
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    $vpk = $tipojson["cd"];
    $vcod = $tipojson["cod"];
    $vsig = $tipojson["sig"];
    $vdesc = $tipojson["desc"];   
    $vcp = empty($tipojson["cp"]) ? "0" : $tipojson["cp"];   
    $vat = empty($tipojson["at"]) ? "0" : $tipojson["at"];
    $vlt = empty($tipojson["lt"]) ? "0" : $tipojson["lt"];
    $vcl = empty($tipojson["cl"]) ? "0" : $tipojson["cl"];
    $vbc = empty($tipojson["bc"]) ? "0" : $tipojson["bc"];
    $vbleed = empty($tipojson["bleed"]) ? "0" : $tipojson["bleed"];
    $vrefile = $tipojson["refile"];
    $vsize = (int)$tipojson["size"];
    $vcodemb = "";
    for ($i=0 ; $i<$vsize ; $i++) {
       $field  = "codemb$i";
       //echo "field=$field";
       //echo "val=".$tipojson["$field"];
       $vcodemb = $vcodemb.$tipojson["$field"]."<br>";
    }
    //echo $vcodemb;	
    try {
	$conn->BeginTransaction();
        $pkins = 0;
        if (empty($vpk)) {
	   $msql = "select max(pk) as pk from tbcartucho where";
           $msql = $msql." codcli=".$vid_user;
           //echo $msql;
           foreach ($conn->query($msql) as $row) {
	      if ($row['pk'] == NULL) {
                 $pkins = 1; 
              } else {
                 $pkins = $row['pk'] + 1; 
              }
	   }
        } else {
           $pkins = $vpk; 
        }
	if (empty($vpk)) {
           $transaction="1"; 
	   $msql = "insert into tbcartucho (codcli,pk,dtpk,codigo,sigla,descricao,cp,at,lt,
		                            cl,bc,bleed,refile,
	   		                     codemb)
			          values (:codcli,:pk,:dtpk,:codigo,:sigla,:descricao,:cp,:at,:lt,
			   	          :cl,:bc,:bleed,:refile,
		                          :codemb
				  )";
        					
	}
	if (!empty($vpk)) { 
            if ($transaction=="0") {
               $transaction="2";            
	       $msql = "update tbcartucho set
                                        codigo=:codigo,sigla=:sigla,
                                        descricao=:descricao,cp=:cp,
		                        at=:at,lt=:lt,
					cl=:cl,bc=:bc,
					bleed=:bleed,refile=:refile,
		                        codemb=:codemb
   		                        where codcli=:codcli and pk=:pk";
            }   
	}
        if ($transaction == "3") {
	   $msql = "delete from tbcartucho where";
           $msql = $msql." codcli=:codcli and pk=:pk";
        }

        //echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':codigo',$vcod);
	    $stmt->bindParam(':sigla',$vsig);
	    $stmt->bindParam(':descricao',$vdesc);
	    $stmt->bindParam(':cp',$vcp);
	    $stmt->bindParam(':at',$vat);
	    $stmt->bindParam(':lt',$vlt);
	    $stmt->bindParam(':cl',$vcl);
	    $stmt->bindParam(':bc',$vbc);
	    $stmt->bindParam(':bleed',$vbleed);
	    $stmt->bindParam(':refile',$vrefile);
	    $stmt->bindParam(':codemb',$vcodemb);
	    $stmt->bindParam(':codcli',$vid_user);
	    $stmt->bindParam(':pk',$vpk);
	}		
	if ($transaction=="1") {
	    //echo $msql;
	    $stmt->bindParam(':pk',$pkins);
	    $stmt->bindParam(':dtpk',date("Y-m-d"));
	    $stmt->bindParam(':codcli',$vid_user);
	    $stmt->bindParam(':codigo',$vcod);
	    $stmt->bindParam(':sigla',$vsig);
	    $stmt->bindParam(':descricao',$vdesc);
	    $stmt->bindParam(':cp',$vcp);
	    $stmt->bindParam(':at',$vat);
	    $stmt->bindParam(':lt',$vlt);
	    $stmt->bindParam(':cl',$vcl);
	    $stmt->bindParam(':bc',$vbc);
	    $stmt->bindParam(':bleed',$vbleed);
	    $stmt->bindParam(':refile',$vrefile);
	    $stmt->bindParam(':codemb',$vcodemb);
	}
        if ($transaction == "3") {
           $stmt->bindParam(':codcli',$vid_user);
	   $stmt->bindParam(':pk',$vpk);
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

if ($table == "cartmov") {
    $conn = pdoConn();
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    $vcod = $tipojson["cd"];
    $vdesc = $tipojson["desc"];   
    $vcp = empty($tipojson["cp"]) ? "0" : $tipojson["cp"];   
    $vat = empty($tipojson["at"]) ? "0" : $tipojson["at"];
    $vlt = empty($tipojson["lt"]) ? "0" : $tipojson["lt"];
    $vcl = empty($tipojson["cl"]) ? "0" : $tipojson["cl"];
    $vbc = empty($tipojson["bc"]) ? "0" : $tipojson["bc"];
    $vbleed = empty($tipojson["bleed"]) ? "0" : $tipojson["bleed"];
    $vinterX = empty($tipojson["interX"]) ? "0" : $tipojson["interX"];
    $vinterY = empty($tipojson["interY"]) ? "0" : $tipojson["interY"];
    $vrefile = $tipojson["refile"];
    $vsize = (int)$tipojson["size"];
    $vcodemb = "";
    for ($i=0 ; $i<$vsize ; $i++) {
       $field  = "codemb$i";
       //echo "field=$field";
       //echo "val=".$tipojson["$field"];
       $vcodemb = $vcodemb.$tipojson["$field"]."<br>";
    }
    //echo $vcodemb;	
    $vsizepos = (int)$tipojson["sizepos"];
    $vmontagem = "";
    for ($i=0 ; $i<$vsizepos ; $i++) {
       $field  = "pos$i";
       //echo "field=$field";
       //echo "val=".$tipojson["$field"];
       $vmontagem = $vmontagem.$tipojson["$field"]."<br>";
    }
    try {
	$conn->BeginTransaction();
        $pkins = 0;
        if (empty($vcod)) {
	   $msql = "select max(pk) as pk from tbcartuchomv where";
           $msql = $msql." codcli=".$vid_user;
           //echo $msql;
           foreach ($conn->query($msql) as $row) {
              if ($row['pk'] == NULL) {
                 $pkins = 1; 
              } else { 
	         $pkins  = $row['pk']+1;
              }   
	   }
        } else {   
           $pkins = $vcod;   
        }
        //echo "pkins=$pkins";       
        
	if (empty($vcod)) {
           $transaction="1"; 
	   $msql = "insert into tbcartuchomv (pk,dtpk,codcli,data,descricao,cp,at,lt,
		                             cl,bc,bleed,refile,interX,interY,
	   		                     codemb,montagem)
			          values (:pk,:dtpk,:codcli,:data,:descricao,:cp,:at,:lt,
			   	          :cl,:bc,:bleed,:refile,:interX,:interY,
		                          :codemb,:montagem
				  )";
        					
	}
	if (!empty($vcod)) { 
            if ($transaction=="0") {
               $transaction="2";            
	       $msql = "update tbcartuchomv set descricao=:descricao,cp=:cp,
		                        at=:at,lt=:lt,
					cl=:cl,bc=:bc,
					bleed=:bleed,refile=:refile,interX=:interX,interY=:interY,
		                        codemb=:codemb,montagem=:montagem
   		                        where codcli=:codcli and pk=:pk";
            }   
	}
        if ($transaction == "3") {
	   $msql = "delete from tbcartuchomv where";
           $msql = $msql." codcli=:codcli and pk=:pk";
        }

        //echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':descricao',$vdesc);
	    $stmt->bindParam(':cp',$vcp);
	    $stmt->bindParam(':at',$vat);
	    $stmt->bindParam(':lt',$vlt);
	    $stmt->bindParam(':cl',$vcl);
	    $stmt->bindParam(':bc',$vbc);
	    $stmt->bindParam(':bleed',$vbleed);
	    $stmt->bindParam(':refile',$vrefile);
	    $stmt->bindParam(':interX',$vinterX);
	    $stmt->bindParam(':interY',$vinterY);
	    $stmt->bindParam(':codemb',$vcodemb);
	    $stmt->bindParam(':montagem',$vmontagem);
	    $stmt->bindParam(':codcli',$vid_user);
	    $stmt->bindParam(':pk',$vcod);
	}		
	if ($transaction=="1") {
	    //echo $msql;
	    $stmt->bindParam(':pk',$pkins);
	    $stmt->bindParam(':dtpk',date("Y-m-d"));
	    $stmt->bindParam(':codcli',$vid_user);
	    $stmt->bindParam(':data',date("Y-m-d"));
	    $stmt->bindParam(':descricao',$vdesc);
	    $stmt->bindParam(':cp',$vcp);
	    $stmt->bindParam(':at',$vat);
	    $stmt->bindParam(':lt',$vlt);
	    $stmt->bindParam(':cl',$vcl);
	    $stmt->bindParam(':bc',$vbc);
	    $stmt->bindParam(':bleed',$vbleed);
	    $stmt->bindParam(':refile',$vrefile);
	    $stmt->bindParam(':interX',$vinterX);
	    $stmt->bindParam(':interY',$vinterY);
	    $stmt->bindParam(':codemb',$vcodemb);
	    $stmt->bindParam(':montagem',$vmontagem);
	}
        if ($transaction == "3") {
           $stmt->bindParam(':codcli',$vid_user);
	   $stmt->bindParam(':pk',$vcod);
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
	
if ($table == "maq") {
    $conn = pdoConn();
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    $vcod = $tipojson["cod"];
    $vequipto = $tipojson["equipto"];
    $valias = $tipojson["alias"];   
    $vlarg_mancha = empty($tipojson["larg_mancha"]) ? "0" : $tipojson["larg_mancha"];   
    $vcompr_mancha = empty($tipojson["compr_mancha"]) ? "0" : $tipojson["compr_mancha"];
    $vlarg_folha = empty($tipojson["larg_folha"]) ? "0" : $tipojson["larg_folha"];
    $vcompr_folha = empty($tipojson["compr_folha"]) ? "0" : $tipojson["compr_folha"];
    try {
	$conn->BeginTransaction();
        
        if ($transaction=="1") { 
	   $msql = "insert into tbmaquina (codcli,codigo,equipamento,apelido,larg_mancha,compr_mancha,
		                            larg_folha,compr_folha)
			          values (:codcli,:codigo,:equipamento,:apelido,:larg_mancha,:compr_mancha,
			   	          :larg_folha,:compr_folha
				  )";
        					
	}
        if ($transaction=="2") {
            $msql = "update tbmaquina set equipamento=:equipamento,apelido=:apelido,
		                        larg_mancha=:larg_mancha,compr_mancha=:compr_mancha,
					larg_folha=:larg_folha,compr_folha=:compr_folha
   		                        where codcli=:codcli and codigo=:codigo";
	}
        if ($transaction == "3") {
	   $msql = "delete from tbmaquina where";
           $msql = $msql." codcli=:codcli and codigo=:codigo";
        }

        //echo $msql;
	$stmt = $conn->prepare($msql);
	if ($transaction=="2") {
	    $stmt->bindParam(':equipamento',$vequipto);
	    $stmt->bindParam(':apelido',$valias);
	    $stmt->bindParam(':larg_mancha',$vlarg_mancha);
	    $stmt->bindParam(':compr_mancha',$vcompr_mancha);
	    $stmt->bindParam(':larg_folha',$vlarg_folha);
	    $stmt->bindParam(':compr_folha',$vcompr_folha);
            $stmt->bindParam(':codcli',$vid_user);
	    $stmt->bindParam(':codigo',$vcod);
	}		
	if ($transaction=="1") {
	    //echo $msql;
	    $stmt->bindParam(':codcli',$vid_user);
	    $stmt->bindParam(':codigo',$vcod);
	    $stmt->bindParam(':equipamento',$vequipto);
	    $stmt->bindParam(':apelido',$valias);
	    $stmt->bindParam(':larg_mancha',$vlarg_mancha);
	    $stmt->bindParam(':compr_mancha',$vcompr_mancha);
	    $stmt->bindParam(':larg_folha',$vlarg_folha);
	    $stmt->bindParam(':compr_folha',$vcompr_folha);
	}
        if ($transaction == "3") {
           $stmt->bindParam(':codcli',$vid_user);
	   $stmt->bindParam(':codigo',$vcod);
        }
	$stmt->execute();
		
        $conn->commit();
		
        $conn=null;
        $ret = array('codigo' => "OK",'error' => $vcod);
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

