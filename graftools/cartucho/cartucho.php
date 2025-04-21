<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Cartucho</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="konva.min.js"></script>
<script src="jquery-3.7.1.min.js"></script>
<script src="jquery.inputmask.js"></script>
<script src="jspdf.min.js"></script>

<style>

body {
  font-family: Arial, Helvetica, sans-serif;
  overflow : hidden;
}

/* Style the header */
.header {
  background-color: #bbb;
  padding: 5px;
  text-align: center;
  font-size: 10px;
  height : 4vh;
}

/* Create three unequal columns that floats next to each other */
.column {
  float: left;
  padding: 0px;
  /*height: 50%;*/  /* Should be removed. Only for demonstration */
  height: 91vh;
}

/* Left and right column */
.column.side {
  width: 20%;
}

/* Middle column */
.column.middle {
  width: 80%;
  overflow:auto;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Style the footer */
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #bbb;
  padding: 2px;
  text-align: center;
  font-size: 5px;
  height: 3vh;
}



input[type=text]:focus {
   background-color: yellow;
}


/* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
@media (max-width: 1024px) {
  .column.side {
    width: 20%;
  }
  .column.middle {
    width: 80%;
  }
}

.icon-rotate {
   background-image: url(icons-rotate.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-clear {
   background-image: url(icons-clear.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-zoomIn {
   background-image: url(icons-zoom-in.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-zoomOut {
   background-image: url(icons-zoom-out.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-reset {
   background-image: url(icons-reset.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-width {
   background-image: url(icons-width.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-pdf {
   background-image: url(icons-pdf.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-png {
   background-image: url(icons-png.png);
   background-repeat: no-repeat;
   background-position: center;
   background-size: cover;
   padding: 12px;
   width: 0.1vw;
   height: 0.1vw;
}
.icon-tutorial {
   background-image: url(icons-tutorial.png);
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
  /*background-color: rgba(0,0,0,0.5);*/
  z-index: 2;
  cursor: pointer;
  overflow: auto;
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  
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
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 3;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  display: none;
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
var stage;
var layer;
var group;
var tr;
var selectionRectangle;
var szWidth = 0;
var szHeight = 0;			        
var scaleFit = 1;

var width_auto;
var height_auto;

var zoomStep = 0.1;
		
var scale1 = 1;
var scaleBy = 1;

let   
   rotateBy = 90,  // per-step angle of rotation 
   startPos = {x: 10, y: 10},    
   lineV,
   lineH,
   circle,
   cross;



var vscale = 72.0 / 25.4;

/*
25.4   72     72*10/25.4
10      x 

25.4  1
250   x

72  - 1
120   y    y = 120/72
*/

function setDot(mm) {
   let vinch = mm / 25.4;
   let vdot = vinch * 72;   
   return vdot;
}
function setMM(vdot) {
   //let vinch = (vdot  * scaleFit) / 72;
   let vinch = vdot / 72;
   let vmm = vinch * 25.4;   
   return vmm;
}
function setMM2(vdot) {
   let vinch = (vdot  * scaleFit) / 72;
   //let vinch = vdot / 72;
   let vmm = vinch * 25.4;   
   return vmm;
}

function setPaperAltura() {
    var valtura = setDot(document.getElementById("alturaPapel").value);
    stage.height(valtura);
    stageRect.height(valtura);
    stageRect.draw();
    layer.draw();
        
}
function setPaperLargura() {
    var vlargura = setDot(document.getElementById("larguraPapel").value);
    stage.width(vlargura);
    stageRect.width(vlargura);
    stageRect.draw();
    layer.draw();
}

function fitToWidth() {
   let box = document.querySelector('.column.middle');
   let widthBox = box.offsetWidth;
   let heightBox = box.offsetHeight;
   scaleFit = widthBox / stage.width();
   //console.log("scale = "+scaleFit);
   stage.setAttrs({ scaleX: scaleFit, scaleY: scaleFit });
   scale1 = stage.scaleX(); 
   
}

function getScaledPointerPosition() {
  var pointerPosition = stage.getPointerPosition();
  //console.log(pointerPosition);
  var stageAttrs = stage.attrs;
  //console.log(stageAttrs);
  if (typeof stageAttrs.scaleX === 'undefined') {
      return {x: pointerPosition.x, y: pointerPosition.y};
  }
  //console.log(stageAttrs.x);
  
  //var x = (pointerPosition.x - stageAttrs.x) / stageAttrs.scaleX;
  //var y = (pointerPosition.y - stageAttrs.y) / stageAttrs.scaleY;
  var x = (pointerPosition.x) / stageAttrs.scaleX;
  var y = (pointerPosition.y) / stageAttrs.scaleY;
  return {x: x, y: y};
}      

function getScaledPosition(vpos) {
  var stageAttrs = stage.attrs;
  //console.log(stageAttrs.scaleX);
  if (typeof stageAttrs.scaleX === 'undefined') {
      return vpos;
  }
  return vpos / stageAttrs.scaleX;
}      

function getScaledSize(vsize) {
  var stageAttrs = stage.attrs;
  //console.log(stageAttrs.scaleX);
  if (typeof stageAttrs.scaleX === 'undefined') {
      return vsize;
  }
  return vsize / stageAttrs.scaleX;
}      


function makeLayer() {
      
   var width = setDot(document.getElementById("larguraPapel").value);
   var height = setDot(document.getElementById("alturaPapel").value);
   
   //console.log(width);
   //console.log(height);

   //stage = new Konva.Stage({
   //  container: 'container',
   //  width: width,
   //  height: height,
   //});

   layer = new Konva.Layer();
   stage.add(layer);
   
   stageRect = new Konva.Rect({
      size: stage.size(),
      name: 'stagerect',
      stroke: "lime"
   });
   layer.add(stageRect);

   
   tr = new Konva.Transformer({
      nodes: [],
      keepRatio: false,
      enabledAnchors: ["top-left",
                       "top-right",
                       "bottom-left",
                       "bottom-right",
      ],
      shouldOverdrawWholeArea: true,
      boundBoxFunc: function (oldBoundBox, newBoundBox) {
         // "boundBox" is an object with
         // x, y, width, height and rotation properties
         // transformer tool will try to fit nodes into that box

         // the logic is simple, if new width is too big
         // we will return previous state
         if (Math.abs(newBoundBox.width) > MAX_WIDTH) {
           return oldBoundBox;
         }
         if (Math.abs(newBoundBox.width) < MIN_WIDTH) {
           return oldBoundBox;
         }

         return newBoundBox;
      },
                       
   });
   tr.resizeEnabled(true);
   tr.rotateEnabled(false);
   layer.add(tr);
   selectionRectangle = new Konva.Rect({
     fill: 'rgba(0,0,255,0.5)',
     visible: false,
   });
   layer.add(selectionRectangle);

   var x1, y1, x2, y2;
   var selecting = false;
   var selected = [];
   stage.on('mousedown touchstart', (e) => {
     // do nothing if we mousedown on any shape
     //console.log(e.target.attrs.name);
     //if (e.target !== stage) {
     //  return;
     //}
     if (e.target.attrs.name !== "stagerect") {
       return;
     }
     e.evt.preventDefault();
     //x1 = stage.getPointerPosition().x;
     //y1 = stage.getPointerPosition().y;
     //x2 = stage.getPointerPosition().x;
     //y2 = stage.getPointerPosition().y;

     x1 = getScaledPointerPosition().x;
     y1 = getScaledPointerPosition().y;
     x2 = getScaledPointerPosition().x;
     y2 = getScaledPointerPosition().y;


     selectionRectangle.width(0);
     selectionRectangle.height(0);
     selectionRectangle.moveToTop();
     selecting = true;
   });

   stage.on('mousemove touchmove', (e) => {
     // do nothing if we didn't start selection
     if (!selecting) {
       return;
     }
     e.evt.preventDefault();
     //x2 = stage.getPointerPosition().x;
     //y2 = stage.getPointerPosition().y;

     x2 = getScaledPointerPosition().x;
     y2 = getScaledPointerPosition().y;
     
     //console.log("x2 = "+x2);
     selectionRectangle.setAttrs({
       visible: true,
       x: Math.min(x1, x2),
       y: Math.min(y1, y2),
       width: Math.abs(x2 - x1),
       height: Math.abs(y2 - y1),
     });
   });

   stage.on('mouseup touchend', (e) => {
     // do nothing if we didn't start selection
     selecting = false;
     //console.log("mouseup1");
     //console.log("x="+e.target.parent.x());
     x2 = getScaledPointerPosition().x;
     y2 = getScaledPointerPosition().y;
     //console.log("x3 = "+x2);
    
     var oldScale = stage.scaleX();
     stage.setAttrs({ scaleX: 1, scaleY: 1 });
     var absPos = e.target.parent.getAbsolutePosition();
     updatePosition(absPos.x,absPos.y);
     stage.setAttrs({ scaleX: oldScale, scaleY: oldScale });
     
     if (!selectionRectangle.visible()) {
        //tr.nodes([]);
        selected = [];
        return;
     }
     //console.log("mouseup2");
     e.evt.preventDefault();
     // update visibility in timeout, so we can check it in click event
     selectionRectangle.visible(false);
     var shapes = stage.find('.group1');
     var box = selectionRectangle.getClientRect();
     selected = shapes.filter((shape) =>
       Konva.Util.haveIntersection(box, shape.getClientRect())
     );
     tr.nodes(selected);
     //console.log("selected= "+selected);
   });

   let currentShape;
   // clicks should select/deselect shapes
   stage.on('click tap', function (e) {
     // if we are selecting with rect, do nothing
     if (selected.length > 0)
        return;
     //currentShape = e.target.parent;
     //console.log(currentShape); 
     //console.log('click1 tap');
     //console.log(tr.nodes());
     //console.log("x="+e.target.parent.x());

     if (selectionRectangle.visible()) {
       return;
     }
     //console.log('click2');
     //console.log("nodes= "+tr.nodes()); 
     //console.log(e.target.attrs.name);
     // if click on empty area - remove all selections
     //if (e.target === stage) {
     if (e.target.attrs.name === "stagerect" && selected.length ===0) {
        tr.nodes([]);
        return;
     }
     //console.log('click3');
     //console.log(e.target.hasName('rect'));
     //console.log(e);
     // do nothing if clicked NOT on our rectangles
     if (selected.length === 0) {
        if (!e.target.parent.hasName('group1')) {
           tr.nodes([]);
           return;
        }
     }
     //console.log('click4 tap');

     // do we pressed shift or ctrl?
     //const metaPressed = e.evt.shiftKey || e.evt.ctrlKey || e.evt.metaKey;
     const metaPressed = e.evt.shiftKey;
     const isSelected = tr.nodes().indexOf(e.target.parent) >= 0;
     //console.log('metapressed='+metaPressed);
     //console.log('isselected='+isSelected);

     if (!metaPressed && !isSelected) {
       // if no key pressed and the node is not selected
       // select just one
       tr.nodes([e.target.parent]);
       //console.log('click5 tap');
       //console.log(tr.nodes());
     } else if (metaPressed && isSelected) {
       // if we pressed keys and node was selected
       // we need to remove it from selection:
       const nodes = tr.nodes().slice(); // use slice to have new copy of array
       // remove node from array
       nodes.splice(nodes.indexOf(e.target.parent), 1);
       tr.nodes(nodes);
       //console.log('click6 tap');
     } else if (metaPressed && !isSelected) {
       // add the node into selection
       //console.log(tr.nodes());
       const nodes = tr.nodes().concat([e.target.parent]);
       tr.nodes(nodes);
       //console.log('click7 tap');
       //console.log(nodes);
     }
     //console.log('click8 tap');
     var oldScale = stage.scaleX();
     stage.setAttrs({ scaleX: 1, scaleY: 1 });
     var absPos = e.target.parent.getAbsolutePosition();
     updatePosition(absPos.x,absPos.y);
     stage.setAttrs({ scaleX: oldScale, scaleY: oldScale });
     //console.log(stage.position());
     //x2 = getScaledPointerPosition().x;
     //y2 = getScaledPointerPosition().y;
     //console.log("x4 = "+x2);
     //console.log("group = "+absPos.x);
     //console.log("group1 = "+e.target.parent.x());
     //cross.position({x: e.target.parent.x()+(e.target.parent.getClientRect().width), y: e.target.parent.y()+(e.target.parent.getClientRect().height)});
     //cross.position({x: e.target.parent.x(), y: e.target.parent.y()});
     //cross.moveToTop();      
   });
   tr.nodes([]);


   // create the rotation target point cross-hair marker
   //rotateBy = 90;  // per-step angle of rotation 
   //startPos = {x: 10, y: 10};    
   //lineV = new Konva.Line({points: [0, -20, 0, 20], stroke: 'cyan', strokeWidth: 1});
   //lineH = new Konva.Line({points: [-20, 0,  20, 0], stroke: 'cyan', strokeWidth: 1});
   //circle = new Konva.Circle({x: 0, y: 0, radius: 10, fill: 'transparent', stroke: 'cyan', strokeWidth: 1});
   //cross = new Konva.Group({draggable: true, x: startPos.x, y: startPos.y});

   // Add the elements to the cross-hair group
   //cross.add(lineV, lineH, circle);
   //layer.add(cross);
   //cross.position(startPos); 
   //cross.moveToTop(); 
 
   //let box = document.querySelector('.column.middle');
   //let widthBox = box.offsetWidth;
   //let heightBox = box.offsetHeight;
   //scaleFit = widthBox / width;
   
   scaleFit = 0.2;
 
   stage.setAttrs({ scaleX: scaleFit, scaleY: scaleFit });
   scale1 = stage.scaleX(); 


}

function setProperties() {
   //console.log("setProperties");
   var vcartucho = document.getElementById("cartucho").value;
   //console.log(vcartucho);
   removeProperties();
   stage.destroyChildren();
   makeLayer();

   if (vcartucho === "SFB") {
      makeProperties(1,"<p style='width:11vw;font-size:0.8vw;'>Frente</p>",'<input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="SFBv_SC_Fre" onchange="makeDraw()"/>',"<p style=font-size:1vw;>mm</p>");
      makeProperties(2,"<p style='width:11vw;font-size:0.8vw;'>Altura</p>",'<input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="SFBv_SC_Alt" required onchange="makeDraw()"/>',"<p style=font-size:1vw;>mm</p>");
      makeProperties(3,"<p style='width:11vw;font-size:0.8vw;'>Lateral</p>",'<input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="SFBv_SC_Lat" required onchange="makeDraw()"/>',"<p style=font-size:1vw;>mm</p>");
      makeProperties(4,"<p style='width:11vw;font-size:0.8vw;'>Boca</p>",'<input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="SFBv_SC_Boca" required onchange="makeDraw()"/>',"<p style=font-size:1vw;>mm</p>");
      makeProperties(5,"<p style='width:11vw;font-size:0.8vw;'>Aba de Cola<p>",'<input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="SFBv_SC_Colagem" required onchange="makeDraw()"/>',"<p style=font-size:1vw;>mm</p>");
      makeProperties(6,"<p style='width:11vw;font-size:0.8vw;'>Refile</p>",'<input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="SFBv_SC_Refile" required onchange="makeDraw()"/>',"<p style=font-size:1vw;>mm</p>");
      makeProperties(7,"",'',"");
      makeProperties(8,"",'<button type="button" id="btn_SFB"  style="width: 5vw;font-size: 0.8vw" onclick="btn_SFB()">Auto</button>',"");
      document.getElementById("SFBv_SC_Fre").focus();
  }   

  if (vcartucho === "HTM") {
  } 
  
  document.getElementById("xposition").value="0";
  document.getElementById("yposition").value="0";

  document.getElementById("rotate").disabled = false;
  document.getElementById("clear").disabled = false;
  document.getElementById("stage1ZoomIn").disabled = false;
  document.getElementById("stage1ZoomOut").disabled = false;
  document.getElementById("reset").disabled = false;
  document.getElementById("fitToWidth").disabled = false;
  document.getElementById("savepdf").disabled = false;
  document.getElementById("saveimg").disabled = false;
  document.getElementById("xposition").disabled = false;
  document.getElementById("yposition").disabled = false;

  
  $(".decimal").inputmask('decimal', {'autoUnmask': true,
		    radixPoint:',',
		    allowMinus: true,
		    rightAlign: true,
		    inputtype:"text",
		    digits: 3,
			unmaskAsNumber: true,
  });
  
  
  $("input").on("keydown",function(e) {
      var keyCode = e.keyCode || e.which;
      if (e.keyCode === 13) {
         e.preventDefault();
         try {
            $("input")[$("input").index(this)+1].focus();
         } catch (ex) {
         	document.getElementById("larguraPapel").focus();
         }         
      }
  
  });   
    
}


function makeDraw() {
   //console.log("makedraw");
   var vcartucho = document.getElementById("cartucho").value;
   //console.log(vcartucho);
   if (vcartucho === "SFB") {
      SFB(); 
   }   
  
   if (vcartucho === "HTM") {
      HTM(); 
   }
}

function empty(e) {
  switch (e) {
    case "":
    case 0:
    case "0":
    case null:
    case false:
    case undefined:
      return true;
    default:
      return false;
  }
}

function drawRect(x,y,width,height,pfill) {
  var box = new Konva.Rect({
    x: x,
    y: y,
    width: width,
    height: height,
    name: "rect",
    fill: pfill,
    stroke: "black",
    strokeWidth: 1,
  });
  return box;

}

function drawLine(points,pfill) {
   var poly = new Konva.Line({
     points: points,
     fill: pfill,
     stroke: "black",
     strokeWidth: 1,
     closed: true,
     name: "rect",
   });
   return poly;
}

function drawLineRefile(points,pfill) {
   var poly = new Konva.Line({
     points: points,
     fill: pfill,
     stroke: "red",
     strokeWidth: 1,
     closed: false,
     name: "rect",
   });
   return poly;
}

//SFB - Sacola com furos - Fechamento Bobst
function SFB() {
   var SFBv_SC_Fre, SFBv_SC_Lat, SFBv_SC_Alt, SFBv_SC_Boca, SFBv_SC_Colagem, SFBv_SC_Refile;
   var SFBo_Fr1, SFBo_Fr2, SFBo_La1, SFBo_La2, SFBo_Boca1, SFBo_Boca2,
       SFBo_Fundo1, SFBo_Fundo2, SFBo_Aba1, SFBo_Aba2, SFBo_Colagem;   
       
   SFBv_SC_Fre = document.getElementById("SFBv_SC_Fre").value;
   SFBv_SC_Alt = document.getElementById("SFBv_SC_Alt").value;
   SFBv_SC_Lat = document.getElementById("SFBv_SC_Lat").value;
   SFBv_SC_Boca = document.getElementById("SFBv_SC_Boca").value;
   SFBv_SC_Colagem = document.getElementById("SFBv_SC_Colagem").value;
   SFBv_SC_Refile = document.getElementById("SFBv_SC_Refile").value;
   
       
   var llateral = true;
   var yaltura_lat = 0;
   var valtura_lat = 0;     
   
   var laltura_boca = true;
   var xaltura_boca = 0;
   var yaltura_boca = 0;
   var valtura_boca = 0;     
     
   var lcolagem = true;
   var lrefile = true;    
       
   if (empty(SFBv_SC_Fre)) {
      SFBv_SC_Fre = 10; 
   }
   if (empty(SFBv_SC_Lat)) {
      SFBv_SC_Lat = 10;
      llateral = false;
      valtura_lat = setDot(10);  
   }   
   if (empty(SFBv_SC_Alt)) {
      SFBv_SC_Alt = 10;
   }   
   if (empty(SFBv_SC_Boca)) {
      SFBv_SC_Boca = 10;
      laltura_boca = false;
      valtura_boca = setDot(10);
   }
   if (empty(SFBv_SC_Colagem)) {
      SFBv_SC_Colagem = 10;
      lcolagem = false;
   }
   if (empty(SFBv_SC_Refile)) {
      SFBv_SC_Refile = 0;
      lrefile = false;   
   }
	
   SFBv_SC_Fre = setDot(SFBv_SC_Fre);
   SFBv_SC_Lat = setDot(SFBv_SC_Lat);
   SFBv_SC_Alt = setDot(SFBv_SC_Alt);
   SFBv_SC_Boca = setDot(SFBv_SC_Boca);
   SFBv_SC_Colagem = setDot(SFBv_SC_Colagem);
   SFBv_SC_Refile = setDot(SFBv_SC_Refile);
   
   width_auto = (2 * SFBv_SC_Fre) + (2 * SFBv_SC_Lat) + SFBv_SC_Colagem + (2 * SFBv_SC_Refile);
   height_auto = SFBv_SC_Alt + SFBv_SC_Boca + (2 * SFBv_SC_Refile);  

   
   if (llateral)
      valtura_lat = SFBv_SC_Alt;
   if (laltura_boca)
      valtura_boca = SFBv_SC_Boca;


   var scaleAux = stage.scaleX();   
   stage.destroyChildren();
   makeLayer();
   //stage.setAttrs({ scaleX: scaleAux, scaleY: scaleAux });

   var oldScale = stage.scaleX();
   stage.setAttrs({ scaleX: 1, scaleY: 1 });

   var vshape = [];
   
   var vcolor = "#ADD8E6";   
   var xOrig = setDot(0);   
   var yOrig = setDot(0);
   
   var x1 = xOrig+SFBv_SC_Refile;
   var xRefile = x1;
   var y1 = yOrig+SFBv_SC_Alt+SFBv_SC_Boca+SFBv_SC_Refile;
   
   xaltura_boca = x1;
   
   //frente1
   SFBo_Fr1 = [];
   SFBo_Fr1[0] = SFBv_SC_Fre;   
   SFBo_Fr1[1] = SFBv_SC_Alt;   
   
   var frect1 = drawRect(x1,y1-SFBv_SC_Alt,SFBo_Fr1[0],SFBo_Fr1[1],vcolor);
   layer.add(frect1);
   vshape.push(frect1);   
   
   //fundo1
   SFBo_Fundo1 = [];
   SFBo_Fundo1[0] = SFBv_SC_Fre;   
   SFBo_Fundo1[1] = (SFBv_SC_Lat / 2)+setDot(10);   

   var frectFundo1;
   if (llateral) {   
      frectFundo1 = drawRect(x1,y1,SFBo_Fundo1[0],SFBo_Fundo1[1],vcolor);
      layer.add(frectFundo1);   
      vshape.push(frectFundo1);   
   }   
   
   x1 = x1 + Number(frect1.width());

   //lateral1
   SFBo_La1 = [];
   SFBo_La1[0] = SFBv_SC_Lat;   
   SFBo_La1[1] = SFBv_SC_Alt;   

   yaltura_lat = y1 - ((SFBv_SC_Alt-valtura_lat) / 2) - SFBv_SC_Alt; 

   var lrect1;
   if (llateral)
      lrect1 = drawRect(x1,y1-SFBv_SC_Alt,SFBo_La1[0],SFBo_La1[1],vcolor);
   else {
      if (valtura_lat === SFBv_SC_Alt)
         lrect1 = drawRect(x1,y1-SFBv_SC_Alt,SFBo_La1[0],valtura_lat,vcolor);
      else   
         lrect1 = drawRect(x1,y1-(SFBv_SC_Alt - valtura_lat)/2,SFBo_La1[0],valtura_lat,vcolor);
   }   
   layer.add(lrect1);  
   vshape.push(lrect1);   
   
   //aba1
   SFBo_Aba1 = [];
   SFBo_Aba1[0] = SFBv_SC_Lat;   
   SFBo_Aba1[1] = (SFBv_SC_Lat / 2)-setDot(5);   

//[20, 200,100,300,100,500,20,600],   
   var xcola = [];
   var ycola = [];
   var vcorteCola = setDot(5);
   xcola[0] = x1;
   ycola[0] = y1;
   xcola[1] = x1+setDot(5);
   ycola[1] = y1+SFBo_Aba1[1];         
   xcola[2] = x1+SFBo_Aba1[0]-setDot(5);
   ycola[2] = y1+SFBo_Aba1[1];         
   xcola[3] = x1+SFBv_SC_Lat;
   ycola[3] = y1;         
   
   var vpolyAba1 = [xcola[0],ycola[0],xcola[1],ycola[1],xcola[2],ycola[2],xcola[3],ycola[3]];      
   var lrectAba1;    
   if (llateral) {   
      lrectAba1 = drawLine(vpolyAba1,vcolor);
      layer.add(lrectAba1);  
      vshape.push(lrectAba1);   
   }
   x1 = x1 + Number(lrect1.width());

   //frente2
   SFBo_Fr2 = [];
   SFBo_Fr2[0] = SFBv_SC_Fre;   
   SFBo_Fr2[1] = SFBv_SC_Alt;   
   
   var frect2 = drawRect(x1,y1-SFBv_SC_Alt,SFBo_Fr2[0],SFBo_Fr2[1],vcolor);
   layer.add(frect2);   
   vshape.push(frect2);   

   //fundo2
   SFBo_Fundo2 = [];
   SFBo_Fundo2[0] = SFBv_SC_Fre;   
   SFBo_Fundo2[1] = SFBv_SC_Lat-setDot(20);  
   
   height_auto = height_auto + SFBo_Fundo2[1]; 

   var rectFundo2;
   if (llateral) {   
      frectFundo2 = drawRect(x1,y1,SFBo_Fundo2[0],SFBo_Fundo2[1],vcolor);
      layer.add(frectFundo2);   
      vshape.push(frectFundo2);   
   }

   x1 = x1 + Number(frect2.width());
   
   //lateral2  
   SFBo_La2 = [];
   SFBo_La2[0] = SFBv_SC_Lat;   
   SFBo_La2[1] = SFBv_SC_Alt;   

   var lrect2;
   if (llateral)
      lrect2 = drawRect(x1,y1-SFBv_SC_Alt,SFBo_La1[0],SFBo_La2[1],vcolor);
   else {
      if (valtura_lat === SFBv_SC_Alt)
         lrect2 = drawRect(x1,y1-SFBv_SC_Alt,SFBo_La2[0],valtura_lat,vcolor);
      else  
         lrect2 = drawRect(x1,y1-(SFBv_SC_Alt-valtura_lat)/2,SFBo_La2[0],valtura_lat,vcolor);
   }
   layer.add(lrect2);   
   vshape.push(lrect2);   

   //aba2
   SFBo_Aba2 = [];
   SFBo_Aba2[0] = SFBv_SC_Lat;   
   SFBo_Aba2[1] = (SFBv_SC_Lat / 2)-setDot(5);   

//[20, 200,100,300,100,500,20,600],   
   xcola = [];
   ycola = [];
   vcorteCola = setDot(5);
   xcola[0] = x1;
   ycola[0] = y1;
   xcola[1] = x1+setDot(5);
   ycola[1] = y1+SFBo_Aba1[1];         
   xcola[2] = x1+SFBo_Aba2[0]-setDot(5);
   ycola[2] = y1+SFBo_Aba2[1];         
   xcola[3] = x1+SFBv_SC_Lat;
   ycola[3] = y1;         
   
   
   var vpolyAba2 = [xcola[0],ycola[0],xcola[1],ycola[1],xcola[2],ycola[2],xcola[3],ycola[3]];      
   var lrectAba2;   
   if (llateral) { 
      lrectAba2 = drawLine(vpolyAba2,vcolor);
      layer.add(lrectAba2);  
      vshape.push(lrectAba2);   
   }
   x1 = x1 + Number(lrect2.width());
   
   
   
   //boca
   var vlargura_boca = (SFBv_SC_Fre * 2) + (SFBv_SC_Lat * 2)   
   
   SFBo_Boca1 = [];
   SFBo_Boca1[0] = vlargura_boca;   
   SFBo_Boca1[1] = SFBv_SC_Boca * 0.40;

   yaltura_boca = y1 - SFBv_SC_Boca - SFBv_SC_Alt; 
   
   var brect1;
   if (laltura_boca) {   
      brect1 = drawRect(xaltura_boca,yaltura_boca,SFBo_Boca1[0],SFBo_Boca1[1],vcolor);
   }   
   else {
      brect1 = drawRect(xaltura_boca+(SFBo_Boca1[0]/2),yaltura_boca,SFBv_SC_Boca,SFBo_Boca1[1],vcolor);
   }   
   layer.add(brect1);  
   vshape.push(brect1);   

      
   SFBo_Boca2 = [];
   SFBo_Boca2[0] = vlargura_boca;   
   SFBo_Boca2[1] = SFBv_SC_Boca * 0.60;

   yaltura_boca = y1 - SFBo_Boca2[1] - SFBv_SC_Alt; 
   var brect2;  
   if (laltura_boca) {   
       brect2 = drawRect(xaltura_boca,yaltura_boca,SFBo_Boca2[0],SFBo_Boca2[1],vcolor);
   }    
   else { 
       brect2 = drawRect(xaltura_boca+(SFBo_Boca2[0]/2),yaltura_boca,SFBv_SC_Boca,SFBo_Boca2[1],vcolor);
   }
   layer.add(brect2);   
   vshape.push(brect2);   
      
   //colagem   
   SFBo_Colagem = SFBv_SC_Colagem;
   var valtura_colagem = SFBv_SC_Alt + SFBv_SC_Boca;
   var yaltura_colagem = y1 - SFBv_SC_Boca - SFBv_SC_Alt;   

//[20, 200,100,300,100,500,20,600],   
   xcola = [];
   ycola = [];
   vcorteCola = setDot(10);
   xcola[0] = x1;
   ycola[0] = yaltura_colagem;
   xcola[1] = x1+SFBo_Colagem;
   ycola[1] = yaltura_colagem+vcorteCola;         
   xcola[2] = x1+SFBo_Colagem;
   ycola[2] = yaltura_colagem+valtura_colagem-vcorteCola;         
   xcola[3] = x1;
   ycola[3] = yaltura_colagem+valtura_colagem;         
   
   
   var vpoly = [xcola[0],ycola[0],xcola[1],ycola[1],xcola[2],ycola[2],xcola[3],ycola[3]];      
   var crect1;  
   if (lcolagem) {    
      crect1 = drawLine(vpoly,'yellow');
   } else {
      if (SFBo_Colagem === SFBv_SC_Alt)
         crect1 = drawRect(x1,y1-SFBv_SC_Alt,SFBo_Colagem,SFBo_Colagem,'yellow');
      else
         crect1 = drawRect(x1,y1-(SFBv_SC_Alt - SFBo_Colagem) / 2,SFBo_Colagem,SFBo_Colagem,'yellow');
   }      
   layer.add(crect1);
   vshape.push(crect1);   
   x1 = x1 + Number(crect1.width());
      
    
   //refile
   var vAlturaRefileEsq = SFBv_SC_Alt + SFBv_SC_Boca;
   var vLarguraRefileTop = (SFBv_SC_Fre * 2) + (SFBv_SC_Lat * 2); 
   yRefile = y1 - SFBv_SC_Alt -SFBv_SC_Boca;
   var vpolyRefile = [xRefile-SFBv_SC_Refile,y1+SFBo_Fundo1[1]+SFBv_SC_Refile,xRefile-SFBv_SC_Refile,y1-vAlturaRefileEsq-SFBv_SC_Refile];
   var lrecRefile;
   if (lrefile) {
      //left side      
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);   
      vshape.push(lrecRefile);   
      
      //top side
      vpolyRefile = [xRefile-SFBv_SC_Refile,y1-vAlturaRefileEsq-SFBv_SC_Refile,xRefile+vLarguraRefileTop+SFBv_SC_Refile,yRefile-SFBv_SC_Refile];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   
      
      //right side
      vpolyRefile = [xcola[0]+SFBv_SC_Refile,ycola[0]-SFBv_SC_Refile,xcola[1]+SFBv_SC_Refile,ycola[1]-SFBv_SC_Refile,xcola[2]+SFBv_SC_Refile,ycola[2]+SFBv_SC_Refile,xcola[3]+SFBv_SC_Refile,ycola[3]+SFBv_SC_Refile];      
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   
      
      //bottom 1 side
      vpolyRefile = [xRefile-SFBv_SC_Refile,y1+SFBo_Fundo1[1]+SFBv_SC_Refile,xRefile+SFBv_SC_Fre+SFBv_SC_Refile,y1+SFBo_Fundo1[1]+SFBv_SC_Refile];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   

      vpolyRefile = [xRefile+SFBv_SC_Fre+SFBv_SC_Refile,y1+SFBo_Fundo1[1]+SFBv_SC_Refile,xRefile+SFBv_SC_Fre+SFBv_SC_Refile,y1+SFBo_Aba1[1]+SFBv_SC_Refile];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   
      
      //bottom 2 side
      vpolyRefile = [xRefile+SFBv_SC_Fre+SFBv_SC_Refile,y1+SFBo_Aba1[1]+SFBv_SC_Refile,xRefile+SFBv_SC_Fre+SFBo_Aba1[0]-SFBv_SC_Refile,y1+SFBo_Aba1[1]+SFBv_SC_Refile];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   

      vpolyRefile = [xRefile+SFBv_SC_Fre+SFBo_Aba1[0]-SFBv_SC_Refile,y1+SFBo_Aba1[1]+SFBv_SC_Refile,xRefile+SFBv_SC_Fre+SFBo_Aba1[0]-SFBv_SC_Refile,y1+SFBo_Fundo2[1]+SFBv_SC_Refile];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   
      
      //bottom 3 side
      vpolyRefile = [xRefile+SFBv_SC_Fre+SFBo_Aba1[0]-SFBv_SC_Refile,y1+SFBo_Fundo2[1]+SFBv_SC_Refile,xRefile+SFBv_SC_Fre+SFBo_Aba1[0]+SFBo_Fundo2[0]+SFBv_SC_Refile,y1+SFBo_Fundo2[1]+SFBv_SC_Refile];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   

      vpolyRefile = [xRefile+SFBv_SC_Fre+SFBo_Aba1[0]+SFBo_Fundo2[0]+SFBv_SC_Refile,y1+SFBo_Fundo2[1]+SFBv_SC_Refile,xRefile+SFBv_SC_Fre+SFBo_Aba1[0]+SFBo_Fundo2[0]+SFBv_SC_Refile,y1+SFBo_Aba2[1]+SFBv_SC_Refile];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   
      
      //bottom 4 side
      var xrefil = [];
      var yrefil = [];
      xrefil[0] = xRefile+SFBv_SC_Fre+SFBo_Aba1[0]+SFBo_Fundo2[0]+SFBv_SC_Refile+setDot(5);
      yrefil[0] = y1+SFBo_Aba2[1]+SFBv_SC_Refile;         
      xrefil[1] = xRefile+SFBv_SC_Fre+SFBo_Aba1[0]+SFBo_Fundo2[0]+SFBo_Aba2[0]+SFBv_SC_Refile-setDot(5);
      yrefil[1] = y1+SFBo_Aba2[1]+SFBv_SC_Refile;         
      xrefil[2] = xRefile+SFBv_SC_Fre+SFBo_Aba1[0]+SFBo_Fundo2[0]+SFBo_Aba2[0]+SFBv_SC_Refile;
      yrefil[2] = y1+SFBv_SC_Refile;         
      
      vpolyRefile = [xrefil[0],yrefil[0],xrefil[1],yrefil[1],xrefil[2],yrefil[2]];
      lrecRefile = drawLineRefile(vpolyRefile,"");
      layer.add(lrecRefile);
      vshape.push(lrecRefile);   
   }
   
   group = new Konva.Group({
      x: xOrig,
      y: yOrig,
      name: "group1",
      draggable: true,
   });

   group.on('dragstart', function(e) {
	  // stop dragging original rect
	  //console.log(e);
	  //console.log("crtl="+e.evt.ctrlKey);
	  //console.log(e.target.parent);
	 		
	  if (!e.evt.ctrlKey) {
          return;
	  }    
	  group.stopDrag();
	 		
	  // clone it
	 var clone = group.clone({
	  	x : group.x()+50,
	  	y : group.y()+50,
	  	name : 'group1',
	 });
	 //tr.nodes(tr.nodes().concat([clone]));
	 // events will also be cloned
	 // so we need to disable dragstart
	 clone.off('dragstart');
	 		
	 // then add to layer and start dragging new shape
	 layer.add(clone);
	 clone.startDrag();
	 
   });

   
   vshape.forEach((element) => {
      group.add(element);
      //console.log(element);      
   });
   //console.log("end draw");
   //console.log(vshape);
   layer.add(group);

   document.getElementById("xwidth").value = setMM(width_auto);   
   document.getElementById("yheight").value =setMM(height_auto);   
   console.log("width="+width_auto+" height="+height_auto);
   console.log("width="+setMM(width_auto)+" height="+setMM(height_auto));

   stage.setAttrs({ scaleX: oldScale, scaleY: oldScale });

}
      
function btn_SFB() {
   makeDraw();	   

   var lrotate = true;
   //console.log(group);
   try {   
   		if (lrotate) {
      		var clone = group.clone({
  	     		x : group.x()+width_auto,
         		y : group.y()+2*height_auto,
         		rotation : 180,
  	     		name : 'group1',
      		});
   		} else {
      		var clone = group.clone({
  	     		x : group.x(),
         		y : group.y()+height_auto,
         		rotation : 0,
  	     		name : 'group1',
      		});
   		}   
   		layer.add(clone);
   } catch(ex)  {
   }
   
}; 


//HTM - Cartucho Hotmelt
function HTM() {


}



function removeProperties() {
   var table = document.getElementById("tbProperties");
   console.log(table.rows.length);
   while(table.rows.length > 1) {
      table.deleteRow(1);
   }   
}

function makeProperties(vrow,cel1,cel2,cel3) {
   var table = document.getElementById("tbProperties");
   var row = table.insertRow(vrow);
   var cell1 = row.insertCell(0);
   var cell2 = row.insertCell(1);
   var cell3 = row.insertCell(2);
   cell1.innerHTML = cel1;  
   cell2.innerHTML = cel2;  
   cell3.innerHTML = cel3;  
}


function updatePosition(x,y) {
  //console.log("updatePostion="+x+" "+y);
  
  document.getElementById("xposition").value=setMM(x);
  document.getElementById("yposition").value=setMM(y);
    
}


/*
COM - Cartucho Comum (Diagonal ou Paralelo)
<option value="COM" style="font-size:0.8vw;">COM - Cartucho Comum (Diagonal ou Paralelo)</option>
HTM - Cartucho Hotmelt
FSA - Cartucho Fundo Semi-Automatico
<option value="FSA" style="font-size:0.8vw;">FSA - Cartucho Fundo Semi-Automatico</option>
AUT - Cartucho Fundo Automatico
<option value="AUT" style="font-size:0.8vw;">AUT - Cartucho Fundo Automatico</option>
OUT - Cartucho Outros
<option value="OUT" style="font-size:0.8vw;">OUT - Cartucho Outros</option>
SFB - Sacola com furos - Fechamento Bobst
SCV - Sacola convencional c/ furos / ilhós
<option value="SCV" style="font-size:0.8vw;">SCV - Sacola convencional c/ furos / ilhós</option>
EBU - Envelope Baby USA
<option value="EBU" style="font-size:0.8vw;">EBU - Envelope Baby USA</option>
CJG - Caixa Conjugada
<option value="CJG" style="font-size:0.8vw;">CJG - Caixa Conjugada</option>
CTF - Caixa T/F Simples
<option value="CTF" style="font-size:0.8vw;">CTF - Caixa T/F Simples</option>
ECM - Caixa E-Commerce
<option value="ECM" style="font-size:0.8vw;">ECM - Caixa E-Commerce</option>
CTF - Caixa Tampa e Fundo c/ Reforço
<option value="CTF" style="font-size:0.8vw;">CTF - Caixa Tampa e Fundo c/ Reforço</option>
CTF2 - Caixa T/F - Fundo Colado
<option value="CTF2" style="font-size:0.8vw;">CTF2 - Caixa T/F - Fundo Colado</option>
FCF - Fundo c/ Parede p/ Caixa Fosforo
<option value="FCF" style="font-size:0.8vw;">FCF - Fundo c/ Parede p/ Caixa Fosforo</option>
CCG - Cinta p/ Caixa Gaveta
<option value="CCG" style="font-size:0.8vw;">CCG - Cinta p/ Caixa Gaveta</option>
CCF - Cinta p/ Caixa Fosforo
<option value="CCF" style="font-size:0.8vw;">CCF - Cinta p/ Caixa Fosforo</option>
CML - Caixa Maleta c/ Fundo Semi-Automatico
<option value="CML" style="font-size:0.8vw;">CML - Caixa Maleta c/ Fundo Semi-Automatico</option>

*/
</script>

</head>
<body>


<div class="header" id="top_header">
 <button type="button" id="btnTutorial" class="icon-tutorial" title="Tutorial" style="width: 1vw;font-size: 1vw" onclick="tutorialon()"></button>
 <button type="button" id="rotate" class="icon-rotate" title="Girar" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id="clear" class="icon-clear" title="Estado Original" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='stage1ZoomIn' class="icon-zoomIn" title="Aumentar" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='stage1ZoomOut' class="icon-zoomOut" title="Diminuir" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='reset' class="icon-reset" title="Tamanho Normal" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='fitToWidth' class="icon-width" title="Ajusta na largura" style="width: 1vw;font-size: 1vw" onclick="fitToWidth()"></button>
 <button type="button" id='savepdf' class="icon-pdf" style="width: 1vw;font-size: 1vw"></button>
 <button type="button" id='saveimg' class="icon-png" style="width: 1vw;font-size: 1vw"></button>
 <label for = "xposition" style="font-size: 0.5vw;">X:</label>
 <input type="text" id="xposition" style="width: 3vw;font-size: 0.6vw"  class="decimal" disabled value="0"></input>
 <label for = "yposition" style="font-size: 0.5vw;">Y:</label>
 <input type="text" id="yposition" style="width: 3vw;font-size: 0.6vw" class="decimal" disabled value="0"></input>
 <label for = "xwidth" style="font-size: 0.5vw;">Larg.:</label>
 <input type="text" id="xwidth" style="width: 3vw;font-size: 0.6vw"  class="decimal" disabled value="0"></input>
 <label for = "yheight" style="font-size: 0.5vw;">Alt.:</label>
 <input type="text" id="yheight" style="width: 3vw;font-size: 0.6vw" class="decimal" disabled value="0"></input>
 <script>
    document.getElementById("rotate").disabled = true;
    document.getElementById("clear").disabled = true;
    document.getElementById("stage1ZoomIn").disabled = true;
    document.getElementById("stage1ZoomOut").disabled = true;
    document.getElementById("reset").disabled = true;
    document.getElementById("fitToWidth").disabled = true;
    document.getElementById("savepdf").disabled = true;
    document.getElementById("saveimg").disabled = true;
    document.getElementById("xposition").disabled = true;
    document.getElementById("yposition").disabled = true;
    
	xposition.addEventListener('keydown', function (e) {
	    //console.log("xposition");
	  	if (e.keyCode === 13) {
       		var x = document.getElementById("xposition").value;
       		if (Number(x) === "NaN")
          		return; 
       		var y = document.getElementById("yposition").value;
       		if (Number(y) === "NaN")
          		return;
       		console.log("xposition="+x+" yposition="+y)   
	   		var nodes = tr.nodes();
	   		nodes.forEach((item,index) => {
                var oldScale = stage.scaleX();
                stage.setAttrs({ scaleX: 1, scaleY: 1 });
          		item.absolutePosition({x: setDot(x), y:setDot(y)});
          		updatePosition(item.x(),item.y());
                stage.setAttrs({ scaleX: oldScale, scaleY: oldScale});
          		return;
	   		});
        }
    });
	yposition.addEventListener('keydown', function (e) {
	  	if (e.keyCode === 13) {
       		var x = document.getElementById("xposition").value;
       		if (Number(x) === "NaN")
          		return; 
       		var y = document.getElementById("yposition").value;
       		if (Number(y) === "NaN")
          		return;
       		console.log("xposition="+x+" yposition="+y)   
	   		var nodes = tr.nodes();
	   		nodes.forEach((item,index) => {
                var oldScale = stage.scaleX();
                stage.setAttrs({ scaleX: 1, scaleY: 1 });
          		item.absolutePosition({x: setDot(x), y:setDot(y)});
          		updatePosition(item.x(),item.y());
                stage.setAttrs({ scaleX: oldScale, scaleY: oldScale});
          		return;
	   		});
        }
    });
    
</script> 
 
</div>


  <div class="column side"  id="column_prop1" style="background-color:#f1f1f1;">
     <label for = "cartucho" style="font-size: 0.8vw;">Item</label>
     <select name = "cartucho" id="cartucho" style="width:16vw;font-size: 0.8vw;" onchange="setProperties()">
     <option value="COM" style="font-size:0.8vw;">COM - Cartucho Comum (Diagonal ou Paralelo)</option>
     <option value="HTM" style="font-size:0.8vw;">HTM - Cartucho Hotmelt</option>
     <option value="FSA" style="font-size:0.8vw;">FSA - Cartucho Fundo Semi-Automatico</option>
     <option value="AUT" style="font-size:0.8vw;">AUT - Cartucho Fundo Automatico</option>
     <option value="OUT" style="font-size:0.8vw;">OUT - Cartucho Outros</option>
     <option value="SFB" style="font-size:0.8vw;">SFB - Sacola com furos - Fechamento Bobst</option>
     <option value="SCV" style="font-size:0.8vw;">SCV - Sacola convencional c/ furos / ilhós</option>
     <option value="EBU" style="font-size:0.8vw;">EBU - Envelope Baby USA</option>
     <option value="CJG" style="font-size:0.8vw;">CJG - Caixa Conjugada</option>
     <option value="CTF" style="font-size:0.8vw;">CTF - Caixa T/F Simples</option>
     <option value="ECM" style="font-size:0.8vw;">ECM - Caixa E-Commerce</option>
     <option value="CTF" style="font-size:0.8vw;">CTF - Caixa Tampa e Fundo c/ Reforço</option>
     <option value="CTF2" style="font-size:0.8vw;">CTF2 - Caixa T/F - Fundo Colado</option>
     <option value="FCF" style="font-size:0.8vw;">FCF - Fundo c/ Parede p/ Caixa Fosforo</option>
     <option value="CCG" style="font-size:0.8vw;">CCG - Cinta p/ Caixa Gaveta</option>
     <option value="CCF" style="font-size:0.8vw;">CCF - Cinta p/ Caixa Fosforo</option>
     <option value="CML" style="font-size:0.8vw;">CML - Caixa Maleta c/ Fundo Semi-Automatico</option>
     </select>

     <table id="tbPaperSize" style="width: 100%">
       <tr>
          <th colspan="3" style="font-size: 0.8vw;">Área Imprimível </th>
       </tr>
       <tr>   
          <td style="width:90%;font-size: 0.8vw;">Largura Papel</td>
          <td><input type="text" style="width: 5vw;font-size: 0.8vw;" class="decimal" id="larguraPapel" value=1000 onchange="setPaperLargura()"/></td>
          <td style="font-size: 1vw;">mm</td>
       </tr>
       <tr>   
          <td style="width:90%;font-size: 0.8vw;">Altura Papel</td>
          <td><input type="text" style="width: 5vw;font-size: 0.8vw" class="decimal" id="alturaPapel" value=1000 onchange="setPaperAltura()"/></td>
          <td style="font-size: 1vw;">mm</td>
       </tr>
     </table>

     
     <table id="tbProperties" style="width: 100%;">
       <tr>
          <th colspan="3" style="font-size: 0.8vw;">Medidas</th>
       </tr>       
       <tr>
          <td></td>
          <td></td>
          <td></td>
       </tr>
     </table>
  </div>
  <div class="column middle" id="container" style="background-color:#f0f0f0;">
  </div>

  <script>
  	   $(".decimal").inputmask('decimal', {'autoUnmask': true,
		 		radixPoint:',',
		   		allowMinus: true,
		   		rightAlign: true,
		   		inputtype:"text",
		        digits: 3,
				unmaskAsNumber: true,
  	   });
		
	   var width = setDot(document.getElementById("larguraPapel").value);
	   var height = setDot(document.getElementById("alturaPapel").value);
	   
	   //console.log(width);
	   //console.log(height);
	
	   stage = new Konva.Stage({
	     container: 'container',
	     width: width,
	     height: height,
	   });
      layer = new Konva.Layer();
      stage.add(layer);
    
      
      function rotatePoint({ x, y }, rad) {
          const rcos = Math.cos(rad)
          const rsin = Math.sin(rad)
          return { x: x * rcos - y * rsin, y: y * rcos + x * rsin }
      }

      function rotateAroundCenter(node, rotation) {
          //width_auto = (2 * SFBv_SC_Fre) + (2 * SFBv_SC_Lat) + SFBv_SC_Colagem + (2 * SFBv_SC_Refile);
          //height_auto = SFBv_SC_Alt + SFBv_SC_Boca + (2 * SFBv_SC_Refile);  

          const vnode = node.getClientRect();
          //console.log(vnode);
          //const topLeft = { x: -node.width() / 2, y: -node.height() / 2 }
          //const topLeft = { x: (-vnode.width * stage.scaleX())/2 , y: (-vnode.height * stage.scaleY())/2  }
          const topLeft = { x: -width_auto / 2, y: -height_auto / 2 }
          const current = rotatePoint(topLeft, Konva.getAngle(node.rotation()))
          const rotated = rotatePoint(topLeft, Konva.getAngle(rotation))
          const dx = rotated.x - current.x,
              dy = rotated.y - current.y

          //console.log(topLeft);
          //console.log(dx);
          //console.log(dy);
          node.rotation(rotation);
          node.x(node.x() + dx);
          node.y(node.y() + dy);

          //return node
      }      
      
		// Rotate a shape around any point.
		// shape is a Konva shape
		// angleDegrees is the angle to rotate by, in degrees
		// point is an object {x: posX, y: posY}
		function rotateAroundPoint(shape, angleDegrees, point) {
		  let angleRadians = angleDegrees * Math.PI / 180; // sin + cos require radians
		  
		  const x =
		    point.x +
		    (shape.x() - point.x) * Math.cos(angleRadians) -
		    (shape.y() - point.y) * Math.sin(angleRadians);
		  const y =
		    point.y +
		    (shape.x() - point.x) * Math.sin(angleRadians) +
		    (shape.y() - point.y) * Math.cos(angleRadians);
		   
		  shape.position({x: x, y: y});  // move the rotated shape in relation to the rotation point.
		  shape.rotation(shape.rotation() + angleDegrees); // rotate the shape in place around its natural rotation point
		  
		}
      
      
		document.getElementById('rotate').addEventListener(
		  'click',
		  function () {
		     //rotateAroundCenter(group, group.rotation()+90);
		     //group.rotate(90);
		     //layer.draw();
		     
             //console.log(szWidth+" "+szHeight);		     
		     
		     var nodes = tr.nodes();
		     let vitem = 0;
		     nodes.forEach((item,index) => {
		       vitem++;
		       //console.log("count item "+vitem);
		     });
		     if (vitem > 1) { 
		        alert("Só rotaciona somente um.");
		        return;
		     }
		     nodes.forEach((item,index) => {
		        //console.log(item);
                rotateAroundCenter(item, item.rotation() + 90);
		        //item.rotate(90);
		        //layer.draw();
		        //console.log("index = "+index+" item = "+item);
                //cross.move({x: item.x()+(item.getClientRect().width/2), y: item.x()+(item.getClientRect().height/2)});
                //cross.position({x: item.x()+(item.getClientRect().width), y: item.y()+(item.getClientRect().height)});
                //cross.moveToTop();      

                //rotateAroundPoint(item, rotateBy, {x: cross.x(), y: cross.y()});

		     });
		     
		  },
		);      
		document.getElementById('clear').addEventListener(
		  'click',
		  function () {
		     //stage.destroyChildren();
		     //layer.draw();    
		     makeDraw();	   
		     
		  },
		); 
		 
		
		
		document.getElementById('stage1ZoomIn').addEventListener(
		  'click',
		  function () {
		    zoomStage1(zoomStep);
  		    //console.log(stage.scaleX());
  		    scaleFit = stage.scaleX();
		  },
		);      
		document.getElementById('stage1ZoomOut').addEventListener(
		  'click',
		  function () {
		    zoomStage1(-zoomStep);
  		    //console.log(stage.scaleX());
  		    scaleFit = stage.scaleX();
		  },
		);      
		
		
		function zoomStage1(inc) {
		  scale1 = scale1 + inc;
		  if (scale1 >=0.1) {
		     stage.setAttrs({ scaleX: scale1, scaleY: scale1 });
		  } else {
		  	  scale1 = 0.1;
		  }   
		  scaleFit = stage.scaleX();
		}
		document.getElementById('reset').addEventListener(
		  'click',
		  function () {
		  			scale1 = 1;
		  			scaleFit = 1;
		  			stage.scale({ x: scale1, y: scale1 });
		  },
		);      
				
			
		var container = stage.container();
		
		// make it focusable
		
		container.tabIndex = 1;
		// focus it
		// also stage will be in focus on its click
		container.focus();
		
		const DELTA = setDot(1);
		
		container.addEventListener('keydown', function (e) {
		  var nodes = tr.nodes();
		  nodes.forEach((item,index) => {
		    //console.log(index+":  "+item);
		  	if (e.keyCode === 37) {
		    	   item.x(item.x() - DELTA);
		  	} else if (e.keyCode === 38) {
		    	   item.y(item.y() - DELTA);
		  	} else if (e.keyCode === 39) {
		    	   item.x(item.x() + DELTA);
		  	} else if (e.keyCode === 40) {
		    	   item.y(item.y() + DELTA);
		  	}
            updatePosition(item.x(),item.y());
		  	
		  });
		  e.preventDefault();
		});      			       		
		document.getElementById('savepdf').addEventListener('click', function () {
  		  document.getElementById("loader").style.display = "block";
  		  document.getElementById("loader").style.display = "none";
  		  document.getElementById("loader").style.display = "block";
		  var scale2 = 1;
		  stage.scale({ x: scale2, y: scale2 });

		  var pdf = new jsPDF('p', 'pt', [stage.width(), stage.height()]);
		  pdf.setTextColor('#000000');
		  // first add texts
		  stage.find('Text').forEach((text) => {
		    const size = text.fontSize() / 0.75; // convert pixels to points
		    pdf.setFontSize(size);
		    pdf.text(text.text(), text.x(), text.y(), {
		      baseline: 'top',
		      angle: -text.getAbsoluteRotation(),
		    });
		  });
		  // then put image on top of texts (so texts are not visible)
		  stageRect.stroke("white");
		  tr.nodes([]);


		  pdf.addImage(
		    stage.toDataURL({ pixelRatio: 1 }),
		    0,
		    0,
		    stage.width(),
		    stage.height()
		  );
		
		  pdf.save('cartucho.pdf');
		  
		  stageRect.stroke("lime");
          stage.setAttrs({ scaleX: scaleFit, scaleY: scaleFit });
 		  document.getElementById("loader").style.display = "none";
          
		});   			       		


      function downloadURI(uri, name) {
        var link = document.createElement('a');
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        delete link;
      }

      document.getElementById('saveimg').addEventListener(
        'click',
        function () {
          stageRect.stroke("white");
          tr.nodes([]);
	      var scale2 = 1;
		  stage.scale({ x: scale2, y: scale2 });
          var dataURL = stage.toDataURL({ pixelRatio: 1 });
          downloadURI(dataURL, 'cartucho.png');
		  stageRect.stroke("lime");
          stage.setAttrs({ scaleX: scaleFit, scaleY: scaleFit });
        },
        false
      );

      $('#cartucho').get(0).selectedIndex = -1;
  </script>



<div class="tutorial" id="tutorial" onclick="tutorialoff()">
  <span onclick="document.getElementById('tutorial').style.display='none'" class="close" title="Close Modal">&times;</span>
  <span class="close_tutorial">&times;</span>
  <div class="tutorialtext" id="tutorialtext">
  <p style="font-size: 1vw;">
    Para mover um objeto clique com o mouse no objeto para ficar selecionado e mova com o mouse ou use as setas do lado esquerdo.
    <br>
    Para mover usando o X: ou Y: selecione o objeto com o mouse para ficar selecionado. Coloque a medida e tecle Enter.
  </p>   

  <p style="font-size: 1vw;">
    Para girar um objeto clique com o mouse no objeto que ficará selecionado e clique no botão girar.
    <br>
    A origem(x,y) do objeto move junto com o giro. Portanto o (x,y) fica diferente da posição original.
  </p>   
  <p style="font-size: 1vw;">
    Para clonar um objeto clique com o mouse no objeto e pressione a tecla Ctrl e arraste com o mouse.
    Só pode ser clonado a partir do original. O clone não pode ser clonado.
  </p>   
  
  </div>

  <script>
	var modal = document.getElementById("tutorial");
	var span = document.getElementsByClassName("close_tutorial")[0];
	span.onclick = function() {
	  modal.style.display = "none";
	}
	function tutorialon() {
	  document.getElementById("tutorial").style.display = "block";
	}
	
	function tutorialoff() {
	  document.getElementById("tutorial").style.display = "none";
	}
	
  </script>

</div>

<div class="loader" id="loader"></div>

<div class="footer" id="bottom_footer">
  <p style="font-size: 0.6vw;text-align: right">Powered by DRSSISTEMAS</p>
</div>

</body>
</html>
