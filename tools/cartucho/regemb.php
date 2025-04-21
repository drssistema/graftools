<?php
session_start();

$DEBUG = false;
if (isset($_REQUEST["DEBUG"])) {
    $DEBUG = $_REQUEST["DEBUG"];
    if ($DEBUG == 1)
        $DEBUG = true;		
} 

$vid_user = "0";
$vusuario = "teste"; 
if (!$DEBUG) {
    if (empty($_SESSION['id'])){
        $_SESSION['msg'] = "Área restrita";
	header("Location: ../index.php");	
	return;
    }
    $vid_user = $_SESSION['id'];
    $vusuario = $_SESSION['nome'];
}

$vprog = explode('-',$_SESSION['prog']);
$vdescr = "";

if (in_array("03",$vprog)) {
    $vdescr = "./cartucho/menu.php";
} 
if (empty($vdescr)) {
    header("Location: ../index.php");	
    return;    
}


?>

<!DOCTYPE html>
<html lang='en'>
<head>
<title>Embalagem</title>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='../js/konva.min.js'></script>
<script src='../js/jquery-3.7.1.min.js'></script>
<script src='../js/jquery.inputmask.js'></script>
<script src='../js/jspdf.min.js'></script>
<script src='../js/math.js'></script>
<script src='../js/jquery-ui.js'></script>
<link rel='stylesheet' href='../js/jquery-ui.css'>
<link href="../js/datatables.min.css" rel="stylesheet">
<script src="../js/datatables.min.js"></script>
<script src="../js/dataTables.keyTable.js"></script>
<script src="../js/keyTable.dataTables.js"></script>
<link href="../js/keyTable.dataTables.css" rel="stylesheet">
<script src="../js/scroller.dataTables.js"></script>
<script src="../js/dataTables.scroller.js"></script>
<link href="../js/scroller.dataTables.css" rel="stylesheet">
<script src="../js/dataTables.select.js"></script>
<link href="../js/select.dataTables.css" rel="stylesheet">
<script src='modemb.min.ob.js?version="2"'></script>
<style>
.header {
  background-color: #bbb;
  padding: 1px;
  text-align: center;
  font-size: 0.8vw;
  height: 5vh;
  width: 100%; 
}
.flex-container {
  display: flex;
  align-items: stretch;
  background-color: #f1f1f1;
}
.flex-container > div {
  top: 6.0vh;
  overflow: auto;
}
.main {
  top: 5.0vh;
  padding: 0px;
  height: 8vw;
  width: 100%;
  overflow: auto; 
}
input[type=text]:focus {
  background-color: yellow;
}
textarea {
  overflow-y: scroll;
  height: 28vw;
  width: 30vw;
  resize: none;
  text-transform: uppercase;
}
.icon-rotate {
   background-image: url(./images/icons-rotate.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-clear {
   background-image: url(./images/icons-clear.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-zoomIn {
   background-image: url(./images/icons-zoom-in.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-zoomOut {
   background-image: url(./images/icons-zoom-out.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-reset {
   background-image: url(./images/icons-reset.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-width {
   background-image: url(./images/icons-width.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-pdf {
   background-image: url(./images/icons-pdf.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-png {
   background-image: url(./images/icons-png.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-draw {
   background-image: url(./images/icons-draw.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}

.icon-tutorial {
   background-image: url(./images/icons-tutorial.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-open-file {
   background-image: url(./images/icons-open-file.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-save-file {
   background-image: url(./images/icons-save-file.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-delete-file {
   background-image: url(./images/icons-delete-file.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-new-file {
   background-image: url(./images/icons-new-file.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-template {
   background-image: url(./images/icons-template.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}



.tutorial {
   position: fixed;
   display: none;
   width: 100%;
   height: 100%;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   z-index: 2;
   cursor: pointer;
   overflow: auto;
   background-color: rgb(0,0,0);
   background-color: rgba(0,0,0,0.9);    
}
.close_tutorial {
  color: yellow;
  float: left;
  font-size: 28px;
  font-weight: bold;
  text-align: right;
  width: 97%;
  position: fixed;
}

.close_tutorial:hover,
.close_tutorial:focus {
  color: red;
  text-decoration: none;
  cursor: pointer;
}

.tutorialtext {
  overflow: auto;	
  position: absolute;
  top: 0;
  left: 10px;
  font-size: 2vw;
  color: yellow;
  width:90%;
}


.loader {
    width: 48px;
    height: 48px;
    border: 5px solid #FFF;
    border-bottom-color: #FF3D00;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    display: none;
}

@keyframes rotation {
      0% {
         transform: rotate(0deg);
      }
      100% {
         transform: rotate(360deg);
      }
}

.loaderx {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 10;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  display: block;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>

<script>


</script>
</head>
<body>
<div class='header' id='topheader'>
   <button type='button' id='btnTutorial' title='Tutorial' class='icon-tutorial' style='width:1vw;font-size:0.7vw'></button>
   <button type='button' id='btnNew' title='Novo' class='icon-new-file' style="width: 1vw;font-size: 0.7vw"></button>
   <button type='button' id='btnTemplate' title='Template' class='icon-template' style="width: 1vw;font-size: 0.7vw"></button>
   <button type='button' id='btnOpen' title='Abrir' class='icon-open-file' style="width: 1vw;font-size: 0.7vw"></button>
   <button type='button' id='btnSave' title='Salvar' class='icon-save-file' style="width: 1vw;font-size: 0.7vw"></button>
   <button type='button' id='btnDel' title='Deletar' class='icon-delete-file' style="width: 1vw;font-size: 0.7vw"></button>
</div>
<div class='main'>
<fieldset id='fieldsetRegEmb' style='background-color:white;'>
<legend>Registro de Embalagem</legend>
<table>
<tr>
  <th></th>
  <th>Código</th>
  <th>Sigla</th>
  <th>Descrição da Embalagem</th>
  <th>Compr(CP)</th>
  <th>Altura(AT)</th>
  <th>Lateral(LT)</th>
  <th>Colagem(CL)</th>
  <th>Boca(BC)</th>
  <th>Sangria</th>
</tr>
<tr>
  <td><input type='text' id='txtCd' class='decimal' style='width:3vw;' disabled></input></td>
  <td><input type='text' id='txtCodigo' class='decimal' style='width:3vw;'></input></td>
  <td><input type='text' id='txtSigla' style='width:5vw;' ></input> </td>
  <td><input type='text' id='txtDescr' style='width:19vw;'></input> </td>
  <td><input type='text' id='txtComprimento' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
  <td><input type='text' id='txtAltura' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
  <td><input type='text' id='txtLateral' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
  <td><input type='text' id='txtColagem' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
  <td><input type='text' id='txtBoca' class='decimal' style='width:4vw;font-size: 0.8vw;'></input> </td>
  <td><input type='text' id='txtSangria' class='decimal'  style='width:5vw;font-size: 0.8vw;'></input> </td>
  <td><span class="loader" id="loader1"></span></td>  

</tr>
</table>
</fieldset>
<p id='txtError' style='color: red;'>...</p>
</div>
<div class='flex-container'>
 <div style='flex-grow:1'>
  <div style='text-align:left'>   
  </div>   
  <fieldset id='fieldsetCod' style='background-color:white;width:30vw;'>
   <legend>Codificação da Embalagem</legend>
   <textarea id='txtcod' rows='100' cols='100' spellcheck='false' wrap='off'></textarea>
  </fieldset>
 </div>
 <div style='flex-grow:1'>
     <br><br> 
     <button type='button' id='btnDraw' class='icon-draw' title='Desenhar' style="width: 1vw;font-size: 0.8vw"></button><br>

     <button type="button" id='stage1ZoomIn' class="icon-zoomIn" title="Aumentar" style="width: 1vw;font-size: 1vw"></button><br>
     <button type="button" id='stage1ZoomOut' class="icon-zoomOut" title="Diminuir" style="width: 1vw;font-size: 1vw"></button><br>
     <button type="button" id='reset' class="icon-reset" title="Tamanho Normal" style="width: 1vw;font-size: 1vw"></button><br>
     <button type="button" id='fitToWidth' class="icon-width" title="Ajusta na largura" style="width: 1vw;font-size: 1vw"></button><br>
     <button type="button" id='savepdf' class="icon-pdf" style="width: 1vw;font-size: 1vw"></button><br>
     <button type="button" id='saveimg' class="icon-png" style="width: 1vw;font-size: 1vw"></button>
     <br><br>
     <label for='txtWidth'>Larg.:</label><br>
     <input type='text' id='txtWidth' class='decimal' style='width:4vw' value='800'></input>
     <br>
     <label for='txtHeight'>Alt.:</label><br>
     <input type='text' id='txtHeight' class='decimal' style='width:4vw' value='800'></input>
     <br><br>
     <label for='txtX'>X:</label><br>
     <input type='text' id='txtX' class='decimal' style='width:4vw' value='0'></input><br>
     <label for='txtY'>Y:</label><br>
     <input type='text' id='txtY' class='decimal' style='width:4vw' value='0'></input>
 
 </div>
 <div id='container' style='flex-grow:40;background-color:white;width:20vw;height:70vh;overflow:auto;'>
 </div>
</div>
<div class='tutorial' id='tutorial'>
  <span class='close_tutorial'>&times;</span>
  <div class='tutorialtext' id='tutorialtext'>
  <pre style='font-size: 0.8vw;font-family: monospace'>
   A origem da área de desenho está no topo a esquerda ou seja na coordenada 0,0.
   A coordenada x,y representa a posição, onde x aumenta valor para a direita e
   y aumenta o valor para baixo.
   Ao desenhar fique mais proximo da coordenada 0,0 senão aparecera espaços no lado direito e topo.
   Imagine o desenho no papel milimetrado com uma caneta desenhando. 
   
   Comandos: 
   
   M x y  --> Posiciona para o inicio do traçado
   Ex.: M 0 0 Posiona na coordenada 0,0
   
   H x    --> Traça uma Linha Horizontal
   x representa a posição final -> Ex.: M 0 0 H 100
   
   V y    --> Traça uma Linha Vertical
   y representa a posição final ->Ex.: M 0 0 V 100   
   
   L x y  --> Traça uma Linha
   onde x,y representa a posição final. Ex.: M 0 0 L 100 200
   
   Q cpx cpy x y --> Traça uma Curva Belzier
   cpx,cpx representa o ponto de controle e x,y a posição final
   O ponto de controle faz a linha curvar. Ex.: M 0 10 Q 0 0 10 0
   
   A x y r anguloInicial anguloFinal --> Traça um Arco
   x e y representa o ponto central, r é o raio,
   anguloInicial e anguloFinal representa o inicio e fim do traçado.
   Para fazer um circulo o angulo será de 0 até 360.
   Deverá ser o usado M x y, no x adcione o valor de r senão aparecerá o traço do raio.
   Ex.: M 10+4 10  A 10 10 4 0 360
   
   A1 x y x1 y1 r  --> Traça um arco na borda
   x e y representa o ponto de controle e x1 e y1 o final e r o raio.
   Funciona da mesma forma que a curva de belzier. Só que a curva é o raio.
   Ex.: M 10 20 A1 10 10 20 10 10
   
   E x y rx ry rotacao anguloInicial anguloFinal --> Traça uma Ellipse
   x e y representa o ponto central, rx e ry é o raio,
   anguloInicial e anguloFinal representa o inicio e fim do traçado.
   Para fazer uma  ellipse o angulo será de 0 até 360.
   Deverá ser o usado M x y, no x adcione o valor de rx senão aparecerá o traço do raio.
   Ex.: M 20+20 20 E 20 20 20 10 0 0 360
   
   D tamanhoTraco espacejamento --> Traça uma linha tracejada  ->Ex.: D 2 5
   Ex.: M 0 10 D 2 5 H 40 M 0 0 L 0 0
   Se o ultimo comando for uma linha tracejada
   e não aparecer coloque estes dois comandos M 0 0 e L 0 0
   
   A posição inicial de cada elemento é a posição final do último elemento traçado.
   Se tiver que reposionar use o M x y.
   Exemplo: Para desenhar um retangulo 
             M 0 0
             H 100
             V 40
             H 0
             V 0
             #para traçar uma linha no meio # na primeira coluna serve como comentario.
             M 50 0
             V 40
     Deixe o desenho proximo do lado esquerdo e proximo do topo 
     senão pode haver um espaço na esquerda e no topo que ficará 
     sendo parte do desenho.     
     Quando houver uma expressão aritmetica em x ou y
     Não poderá haver espaço entre os numeros
     ficando desta forma 10*0.01 ou 10+20-2
     deverá ser usado o ponto decimal e não a virgula.    
  </pre> 
</div>

  
 <div id='frmTemplate' title='Template'>
    <label for="txtSearchTemp" style='font-size: 0.8vw;'>Procurar</label> 
    <input type="text" id="txtSearchTemp" style='width:30vw;font-size: 0.8vw;'></input>
    <button type="button" id='btnSearchTemp' style="width: 4vw;font-size: 0.6vw">Procurar</button>
    <label for="txtRecordTemp" style='font-size: 0.8vw;'>Registros</label> 
    <input type="text" id="txtRecordTemp" style='width:4vw;font-size: 0.8vw;' value="50"></input>
    <table id='tbTemplate1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
      <th>Embalagem</th>
      <th>Descricao</th>
     </tr>
    </thead>
    <tbody id='tbodyTemplate1'>
    </tbody>
    </table>
 </div>
 <div id='frmOpen' title='Abrir'>
    <label for="txtSearchCart" style='font-size: 0.8vw;'>Procurar</label> 
    <input type="text" id="txtSearchCart" style='width:30vw;font-size: 0.8vw;'></input>
    <button type="button" id='btnSearchCart' style="width: 4vw;font-size: 0.6vw">Procurar</button>
    <label for="txtRecordCart" style='font-size: 0.8vw;'>Registros</label> 
    <input type="text" id="txtRecordCart" style='width:4vw;font-size: 0.8vw;' value="50"></input>
    <table id='tbOpen1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
    <thead>
     <tr>
      <th></th>
      <th>Codigo</th>
      <th>Sigla</th>
      <th>Descricao</th>
     </tr>
    </thead>
    <tbody id='tbodyOpen1'>
    </tbody>
    </table>
 </div>
  
  
<div id='dialog-delete' title='Atenção!'>
  <p>Deleta o item?</p><br>
  <p id='delItem'></p>  
</div>

<div id='dialog-message' title='Message'>
    <p id='txtmsg'>  </p>
</div>
  
<!--<div class="loader" id="loader1"></div>-->
<script>
var modal1 = document.getElementById('tutorial');
var span1 = document.getElementsByClassName('close_tutorial')[0];
span1.onclick = function() {
  modal1.style.display = 'none';
};
function tutorialon() {
  document.getElementById('tutorial').style.display = 'block';
}
function tutorialoff() {
  document.getElementById('tutorial').style.display = 'none';
}



</script>
</body>
</html>