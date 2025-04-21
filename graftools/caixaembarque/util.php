<?php
// require_once('conexao.php');
require_once('../../includes/config.php');

$key = "G4HT9h8ThSTYDY85HfmkX3Ng";// 24 bit Key
$iv = "eYehReJw";// 8 bit IV
$bit_check=8;// bit amount for diff algor.

define('FIRSTKEY','Lk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=');
define('SECONDKEY','EZ44mFi3TlAey1b2w4Y7lVDuqO+SRxGXsa7nctnr/JmMrA2vN6EJhrvdVZbxaQs5jpSe34X3ejFK/o9+Y5c83w==');

function secured_encrypt($data)
{
$first_key = base64_decode(FIRSTKEY);
$second_key = base64_decode(SECONDKEY);   
   
$method = "aes-256-cbc";   
$iv_length = openssl_cipher_iv_length($method);
$iv = openssl_random_pseudo_bytes($iv_length);
       
$first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);   
$second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
           
$output = base64_encode($iv.$second_encrypted.$first_encrypted);   
return $output;       
}

function secured_decrypt($input)
{
$first_key = base64_decode(FIRSTKEY);
$second_key = base64_decode(SECONDKEY);           
$mix = base64_decode($input);
       
$method = "aes-256-cbc";   
$iv_length = openssl_cipher_iv_length($method);
           
$iv = substr($mix,0,$iv_length);
$second_encrypted = substr($mix,$iv_length,64);
$first_encrypted = substr($mix,$iv_length+64);
           
$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
$second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
   
if (hash_equals($second_encrypted,$second_encrypted_new))
return $data;
   
return false;
}


function seeUser($puser,$psenha,$action) { 
  global $key,$iv,$bit_check; 	
  $user=$puser;
  $senha=$psenha;
  $codigocli="";
  $senhacli="";
  $inscricao="";

  $conn = pdoConn();
  $msql = 'select CODIGO,SENHA from USER';
  
  $result = $conn->prepare($msql);
  $result->execute();
  $row=$result->fetch(PDO::FETCH_ASSOC);
  if (!$row) {
  	   $conn=null;
  	   return true;
  } 


  if ($user=="" && $senha=="") {
  	   $conn=null;
	   return false;
  }
  
   
  $user = decrypt($puser);
  $senha = $psenha;  
  
  
  
  $msql = 'select * from USER where CODIGO=:user';
  $msql = $msql.' and SENHA=:senha';
  
  //echo '<br>'.$msql.'<br>';
  
  $result = $conn->prepare($msql);
  $result->bindParam(':user',$user);
  $result->bindparam(':senha',$senha);
  $result->execute();
  $row=$result->fetch(PDO::FETCH_ASSOC);
  if ($row) { 
      $codigocli=$row['CODIGO'];
      $senhacli = $row['SENHA'];  
  }
  $conn=null;  

  if ($user==$codigocli  && $senha==$senhacli) {
	  return true;
  }
  else { 
	//echo "<script type='text/javascript'> window.location='index.php';</script>";
	return false;
  }


}
//check
function checkUser($puser,$psenha,$action) { 
  global $key,$iv,$bit_check; 	
  $user=$puser;
  $senha=$psenha;
  $codigocli="";
  $senhacli="";
  $inscricao="";
  $acesso="";

  $conn = pdoConn();
  $msql = 'select CODIGO,SENHA,NOME from USER';
  
  $result = $conn->prepare($msql);
  $result->execute();
  $row=$result->fetch(PDO::FETCH_ASSOC);
  if (!$row) {
  	   $conn=null;
  	   return true;
  } 


  if ($user=="" && $senha=="") {
  	   $conn=null;
	   return false;
  }
  
   
  $user = decrypt($puser);
  $senha = $psenha;  
  
  
  
  $msql = 'select * from USER where CODIGO=:user';
  $msql = $msql.' and SENHA=:senha';
  
  //echo '<br>'.$msql.'<br>';
  
  $result = $conn->prepare($msql);
  $result->bindParam(':user',$user);
  $result->bindparam(':senha',$senha);
  $result->execute();
  $row=$result->fetch(PDO::FETCH_ASSOC);
  if ($row) { 
      $codigocli=$row['CODIGO'];
      $senhacli = $row['SENHA'];  
    	$acesso=$row['ACESSO'];
  }
  $conn=null;  
  
  $acesso = decrypt($acesso).'N N N N N N N N N N N N N N N N N N N N';

  $optacesso = explode(' ',$acesso);
  $pedido=$optacesso[0];   
  $pedidocon=$optacesso[1];
  $cliente=$optacesso[2];
  $movest=$optacesso[3];
  $produto=$optacesso[4];
  $cor=$optacesso[5];
  $vendedor=$optacesso[6];
  $confemail=$optacesso[7];
  $usuario=$optacesso[8];
  $parametro1=$optacesso[9];
  $categoria=$optacesso[10];
  $tipoEmbalagem=$optacesso[11];
  $tamanho=$optacesso[12];
  $movest_out=$optacesso[13];

  if ($movest_out=="S") {
	  return true;
  }
  else { 
	//echo "<script type='text/javascript'> window.location='index.php';</script>";
	return false;
  }


}

function getUserAdm($puser,$psenha,$action) { 
  global $key,$iv,$bit_check; 	
  $user=$puser;
  $senha=$psenha;
  $codigocli="";
  $senhacli="";
  $nomecli="";
  $inscricao="";

  $conn = pdoConn();
  $msql = 'select CODIGO,SENHA from USER';
  
  $result = $conn->prepare($msql);
  $result->execute();
  $row=$result->fetch(PDO::FETCH_ASSOC);
  if (!$row) {
  	   $conn=null;
      $ret = array('ret' => "S",'codigo' => '','nome' => '');
      header('Content-Type: application/json');
      return json_encode($ret);
  	   
  	   //return true;
  } 


  if ($user=="" && $senha=="") {
  	   $conn=null;
      $ret = array('ret' => "N",'codigo' => '','nome' => '');
      header('Content-Type: application/json');
      return json_encode($ret);

	   //return false;
  }
  
   
  $user = decrypt($puser);
  $senha = $psenha;  
  
  
  
  $msql = 'select * from USER where CODIGO=:user';
  $msql = $msql.' and SENHA=:senha';
  
  //echo '<br>'.$msql.'<br>';
  
  $result = $conn->prepare($msql);
  $result->bindParam(':user',$user);
  $result->bindparam(':senha',$senha);
  $result->execute();
  $row=$result->fetch(PDO::FETCH_ASSOC);
  if ($row) { 
      $codigocli=$row['CODIGO'];
      $senhacli = $row['SENHA'];  
      $nomecli = $row['NOME'];  
  }
  $conn=null;  

  if ($user==$codigocli  && $senha==$senhacli) {
      $ret = array('ret' => "S",'codigo' => $codigocli,'nome' => $nomecli);
      header('Content-Type: application/json');
      return json_encode($ret);
  	
	   //return true;
  }
  else { 
	//echo "<script type='text/javascript'> window.location='index.php';</script>";
      $ret = array('ret' => "N",'codigo' => '','nome' => '');
      header('Content-Type: application/json');
      return json_encode($ret);
	   //return false;
  }


}



function hextobin($hexstr) { 
  $n = strlen($hexstr); 
  $sbin="";   
  $i=0; 
  while($i<$n) 
  {       
     $a =substr($hexstr,$i,2);           
     $c = pack("H*",$a); 
     if ($i==0){$sbin=$c;} 
     else {$sbin.=$c;} 
     $i+=2; 
  } 
  return $sbin; 
} 

function encrypt($text) {
  global $key,$iv,$bit_check; 	
  $decrypted = base64_encode($text);
  $decrypted = bin2hex($decrypted);
  return $decrypted;
}


function decrypt($encrypted_text){
  $decrypted = base64_decode(hextobin($encrypted_text));
  return $decrypted;


}

function encrypt_old($text) {
  global $key,$iv,$bit_check; 	
  $text_num =str_split($text,$bit_check);
  $text_num = $bit_check-strlen($text_num[count($text_num)-1]);
  for ($i=0;$i<$text_num; $i++) {$text = $text . chr($text_num);}
  $cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
  mcrypt_generic_init($cipher, $key, $iv);
  $decrypted = mcrypt_generic($cipher,$text);
  mcrypt_generic_deinit($cipher);
  //return base64_encode(bin2hex($decrypted));
  $decrypted = base64_encode($decrypted);
  $decrypted = bin2hex($decrypted);
  return $decrypted;
}

function decrypt_old($encrypted_text){
  global $key,$iv,$bit_check; 	
  $cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
  mcrypt_generic_init($cipher, $key, $iv);
  $decrypted = mdecrypt_generic($cipher,base64_decode(hex2bin($encrypted_text)));
  mcrypt_generic_deinit($cipher);
  $last_char=substr($decrypted,-1);
  for($i=0;$i<$bit_check-1; $i++){
      if(chr($i)==$last_char){
          $decrypted=substr($decrypted,0,strlen($decrypted)-$i);
          break;
      }
  }
  return $decrypted;
}


?>