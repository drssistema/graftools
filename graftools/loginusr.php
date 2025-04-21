<?php
    session_start();
	
    $msg = isset($_SESSION['msg'])? $_SESSION['msg']:"";
    $id =  isset($_SESSION['id'])? $_SESSION['id']:""; 
    $nome = isset($_SESSION['nome'])? $_SESSION['nome']:"";
    $root = isset($_SESSION['root'])? $_SESSION['root']:"";
    if(isset($_SESSION['msg'])){
       unset($_SESSION['msg']);
    }
	
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="David A Ribeiro da Silva">
    <link rel="shortcut icon" href="../menu/icones/favicon.ico" type="image/x-icon">
	
	<script src='jquery-3.7.1.min.js'></script>
	<script src='jquery-ui.js'></script>
	<link rel='stylesheet' href='jquery-ui.css'>
	<script src='jquery.inputmask.js'></script>
	<link href="datatables.min.css" rel="stylesheet">
	 
	<script src="datatables.min.js"></script>
	<script src="dataTables.keyTable.js"></script>
	<script src="keyTable.dataTables.js"></script>
	<link href="keyTable.dataTables.css" rel="stylesheet">

	<script src="scroller.dataTables.js"></script>
	<script src="dataTables.scroller.js"></script>
	<link href="scroller.dataTables.css" rel="stylesheet">

	<script src="dataTables.select.js"></script>
	<link href="select.dataTables.css" rel="stylesheet">
	
    <script language='JavaScript' type='text/JavaScript'>
	var msg='';
	var id='';
	var nome='';
	var rootUser='';
    function gerasenha(form) 
    {
        //location='https://www.drssistemas.com.br/graftools/geracripto.php' ;
        location='geracripto.php' ;
        
    }
    function telalogin(form) 
    {
        //location='https://www.drssistemas.com.br/graftools/login.php' ;
        location='loginusr.php' ;
        
    }
    function paginainicial(form) 
    {
        location='../index.html' ;
        
    }

    function menu_graftools(form) 
    {
        //location='https://www.drssistemas.com.br/graftools/menu_graftools.php' ;
        location='index.php' ;
        
    }
    msg = <?php echo "'".$msg."'" ?>;
    id = <?php echo "'".$id."'" ?>;
    nome = <?php echo "'".$nome."'" ?>;
    rootUser = <?php echo "'".$root."'" ?>;
	//console.log('msg='+msg);
	//console.log('id='+id);
	//console.log('nome='+nome);


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

var dialogFUser;
var dialogFUserDetail;
var dialogFMsg;
var dialogFDel;
var vOper;
$(document).ready(function() {
   function addUser() {
	 vOper = 'Insert';  
	 $('#txtId').val('0');
	 $('#txtNome').val('');
	 $('#txtEmail').val('');
	 $('#txtUser').val('');
     $('#txtUser').removeAttr('disabled');
	 $('#txtPwd').val('');
	 $('#txtSenhaAtual').text('');
	 document.getElementById('txtRoot').checked = false;
	 dialogFUserDetail.dialog('open');
   } 
   function updUser() {
	 vOper = 'Update';  
     $('#txtUser').attr('disabled','disabled');
	 $('#txtPwd').val('');
		
	 dialogFUserDetail.dialog('open');
   }
   function delUser() { 
     vOper = 'Del'; 
	 $('#delItem').text($('#txtNome').val());
	 vTypeDel = 'User';
	 dialogFDel.dialog('open');
   }
   function saveUser() {
     if (empty($('#txtNome').val())) {
	   $('#txtmsgbox').text('Falta Nome');
	   dialogFMsg.dialog('open');
       return;
     }		 
     if (empty($('#txtUser').val())) {
	   $('#txtmsgbox').text('Falta Usuário');
	   dialogFMsg.dialog('open');
       return;
     }		 
	 let vExist = false; 
	 if (vOper == 'Insert') {  
		  tableUser
			.column(3)
			.data()
			.each(function (value, index) {
				//console.log('Data in index: ' + index + ' is: ' + value);
				if (value.toUpperCase() == $('#txtUser').val().toUpperCase()) {
				   let row = index;
				   $('#txtmsgbox').text('Usuario '+$('#txtUser').val()+' ja existe');
				   dialogFMsg.dialog('open');
				   vExist = true;
				}
			});			  
     }
	 if (vExist)  
		 return;
	   
	 let vrowUser = Number($('#txtRow').val());
	 let vid = Number($('#txtId').val());
	 let vnome = $('#txtNome').val();
	 let vemail = $('#txtEmail').val();
	 let vusuario = $('#txtUser').val();
	 let vsenha = $('#txtPwd').val();
     let vroot = '0';
	 if (document.getElementById('txtRoot').checked == true) {
	    vroot = '1';	 
	 }	 

	 let qtrans='{';
	 qtrans = qtrans+'"id":'+vid+',';
	 if (vOper == 'Insert')
	    qtrans = qtrans+'"transaction":"ins",';
	 else if (vOper == 'Update')
	    qtrans = qtrans+'"transaction":"upd",';
     else 
	    qtrans = qtrans+'"transaction":"del",';
	 
	 qtrans = qtrans+'"table":"User",';
	 qtrans = qtrans+'"nome":"'+vnome+'",';
	 qtrans = qtrans+'"email":"'+vemail+'",';
	 qtrans = qtrans+'"usuario":"'+vusuario+'",';
	 qtrans = qtrans+'"senha":"'+vsenha+'",';
	 qtrans = qtrans+'"root":"'+vroot+'"';
	 qtrans = qtrans+'}';
	 //console.log(qtrans);
	 $.post('setUser.php',
	 {
	   q : qtrans
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
			let obj = JSON.parse(data);
			if (obj.codigo=="ERROR") {
			  $('#txtmsg').text('Erro = '+obj.error);
			  dialogFMsg.dialog('open');
			  return;
			}
		    if (vOper == 'Update') {	 
			   tableUser.cell(vrowUser, 1).data($('#txtNome').val());
			   tableUser.cell(vrowUser, 2).data($('#txtEmail').val());
               if (vsenha!='') {
			      vsenha = obj.pwd;			   
			      tableUser.cell(vrowUser, 4).data(vsenha);
			   }	  
			   tableUser.cell(vrowUser, 5).data(vroot);
	           dialogFUserDetail.dialog('close');
	           tableUser.cell(':eq('+(vrowUser*6)+')').focus();	
			} else if (vOper == 'Insert') {
               vid = obj.error;		
               vsenha = obj.pwd;			   
		       tableUser.row.add([vid,vnome,vemail,vusuario,vsenha,vroot]).draw();
	           dialogFUserDetail.dialog('close');
			   let vrowCount = tableUser.rows().count()-1;
	           tableUser.cell(':eq('+(vrowCount*6)+')').focus();	
               tableUser.row(vrowCount).scrollTo();			   
			}   
			else {
			   tableUser.row(vrowUser).remove().draw();
	           tableUser.cell(':eq('+((vrowUser-1)*6)+')').focus();	
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });
   }
   
   dialogFUser = $('#frmUser').dialog({
     autoOpen: false,
     height: 400,
     width: 'auto',
     modal: true,
     buttons: {
	   'Incluir': addUser,
	   'Alterar': updUser,
	   'Deletar': delUser,
       Cancel: function() {
	      dialogFUser.dialog('close');
	   }  
	 },
	 close: function() {
		//alert('close'); 
		loadUser(); 
	 }
   });

   dialogFUserDetail = $('#frmUserDetail').dialog({
     autoOpen: false,
	 height: 400, 
	 width: 'auto',
     modal: true,
	 buttons: {
	   'Gravar': saveUser,
       Cancel: function() {
	      dialogFUserDetail.dialog('close');
	   }	   
	 },
   })
   
   dialogFDel = $('#dialog-delete').dialog({
      autoOpen: false,
	  resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Delete": function() {
          $( this ).dialog( "close" );
		  if (vTypeDel == 'User')
   	          saveUser();
        },
        Cancel: function() {
		  if (vTypeDel == 'User')
	          tableUser.cell(':eq('+(rowUser*5)+')').focus();	
          $( this ).dialog( "close" );
        }
      }
   });
   
   dialogFMsg = $( "#dialog-message" ).dialog({
      autoOpen: false,
	  modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
   });


function loadUser() {
	 $.post('getUser.php',
	 {
	   q : 'User'
	 },
	 function(data,status,xhr) {
	    if (status == 'success') { 
			let obj = JSON.parse(data);
			for (let i in obj.user) { 
			   let id = obj.user[i].id;
			   let nome = obj.user[i].nome;
			   let email = obj.user[i].email;
			   let usuario = obj.user[i].usuario;
			   let senha = obj.user[i].senha;
			   let root = obj.user[i].root;
		       tableUser.row.add([id,nome,email,usuario,senha,root]).draw();
			}
		}
		if (status == 'error') {
		    $('#txtmsg').text('Error: '+xhr.status+': '+xhr.statusText);
			dialogFMsg.dialog('open');
		}
	 });

}


function showUser() {
    if (tableUser.rows().count() == 0) {
		loadUser();
	}
    dialogFUser.dialog('open');
    tableUser.columns.adjust().draw();	
}

var tableUser;
var rowUser;
var vpwd;
makeTableUser();   

function makeTableUser() {
	tableUser = new DataTable('#tbUser1', {
		keys: true,
		paging:true,
		info:false,
		ordering:false,
		scrollX: false,
		scroller: true,
		scrollY: 200,
		searching: false,    
        columnDefs: [{target:4,visible:false}],		
	});
	 
	tableUser
		//.on('click', 'tbody tr', function (e) {
		//    let data = tableCaixaEmb.row(this).data();
		//    console.log('You clicked on ' + data[0] + "'s row");
		//})
		.on('key', function (e, datatable, key, cell, originalEvent) {
			//console.log('Key press: ' + key + ' for cell <i>' + cell.data() + '</i>');
			
		})
		.on('key-focus', function (e, datatable, cell) {
		    rowUser = cell.index().row;
            let data = tableUser.row(cell.index().row).data();			
            document.getElementById('txtRow').value = rowUser;  			
            document.getElementById('txtId').value = data[0];  			
            document.getElementById('txtNome').value = data[1]; 			
            document.getElementById('txtEmail').value = data[2]; 			
            document.getElementById('txtUser').value = data[3]; 			
            $('#txtSenhaAtual').text(data[4]);
            //console.log(data[5]); 			
			if (data[5]=='1') 
				document.getElementById('txtRoot').checked = true;
			else 
				document.getElementById('txtRoot').checked = false;
		});
		//.on('key-blur', function (e, datatable, cell) {
		//    console.log('Cell blur: <i>' + cell.data() + '</i>');
		//});
}
if (msg=='Login' && id!='') {
   $('#txtmsg').text(''); 
   showUser();
}
if (msg!='Login') {	   
    $('#txtmsg').text(msg); 
}					   

   
});


	
    </script>
    <title> *** Graf Tools - Login  ***</title>
    <style>
		table
			{
				align-self: center;
				font-size: 15px;
				background-color: deepskyblue; 
			}
	</style>
</head>
<body>
    <center>
    <table id="menu_login" cellspacing="1" cellpadding='1' border='0' style="background-color: rgb(240, 240, 240)">
	    <tr>
		    <td colspan="1">
                <br>
                <center><input type='button' value='GERAR SENHA CRIPTOGRAFADA' onClick='gerasenha(this.form)' target="_blank" style="background-color:cornflowerblue;"></center>
                <br>
		    </td>
		    <td colspan="1">
                <br>
			    <center><input type='button' value='MENU INICIAL - DRSSISTEMAS' onClick='paginainicial(this.form)' target="_blank" style="background-color:khaki;"></center>
                <br>
		    </td>
            <td colspan="1">
                <br>
                <center><input type='button' value='ATUALIZAR PÁGINA !' onClick='telalogin(this.form)' target="_blank" style="background-color: aquamarine;"></center>
                <br>
            </td>
	    </tr>
    </table>
    </center>
    <center><table cellspacing="3" cellpadding='0' border='2'>
        <tr>
            <td colspan='1'>
                <br>
                <center><img align="center" src="../Imagens e Logos/Imagens/LOGO6_DRS.jpg" width="80px" height="80px"/></center>
            </td>
            <td colspan='1'>
                <br>
                <center><img align="center" src="../Imagens e Logos/Imagens/acab_grafico.jpg" width="100px" height="60px"/></center>
            </td>
                <br><br>
        </tr>
        <tr>
            <td colspan='2'>
                <center><h2>[   L O G I N  ( ADM )    ]</h2><br></center>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
           <!-- <center><h2>[     Área restrita     ]</h2></center> -->    
                <center><h2></h2></center>
                <center><h2 id="txtmsg"><font color="red">
                </font></h2></center>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="minusculo">
                <form name="abertura" method="POST" action="validausr.php"> 
                    <h3>
                        <p>
                            <center>
                            <br>
                            <img align="center" src="../Imagens e Logos/Imagens/users.bmp" width="25px" height="25px"/>
                            <label> Usuário</label>
                   <!-- <input type="text" id="usu_login" name="usu_login" style="text-transform: lowercase;" placeholder="digite o seu  login...> -->
                            <input type="text" id="usuario" name="usuario" placeholder="digite o seu login...">
                            <br><br><br>
                            
                            <img align="center" src="../Imagens e Logos/Imagens/img_cadeado.jpg" width="25px" height="25px"/>
                            <label> Senha   </label>
                            <input type='password' id="senha" name='senha' placeholder="digite a sua senha...">
                            <br>
                            </center>
                            <h2><center>
			                
                            <input class="cor_btn" type="submit" name="btnLogin" value="Acessar" style="background-color: aquamarine;">
                            <input type='Reset' value='Limpar Campos' style="background-color: antiquewhite;"><br><br>
                            <input type='button' value='Voltar ao Menu Inicial - Graf Tools' style="background-color: cornflowerblue;" onClick='menu_graftools(this.form)'><br>
                            </center></h2>
                            <center>
                            <h5><mark>
                            <!-- <input type='button' value='ATUALIZAR !' onClick='telalogin(this.form)'><br> -->
                            <!-- <a href="https://www.drssistemas.com.br/graftools/login.php" rel="external">ATUALIZAR !</a> -->
                            </mark></h5>
                            </center>
                        </p>
                    </h3>
                </form>
            </td>
        </tr>
    </table></center>    
	
<div id='frmUser' title='Usuarios'>
 <div>
  <table id='tbUser1' class='display' cellspacing='0' style='width:100%;border:1px solid black;border-collapse:collapse;'>
   <thead>
   <tr>
   <th>Id</th>
   <th>Nome</th>
   <th>Email</th>
   <th>Usuario</th>
   <th>Senha</th>
   <th>Root</th>
   </tr>
   </thead>
   <tbody id='tbodyUser1'>
   </tbody>
  </table>
 </div>
</div>
<div id='frmUserDetail' title='Usuario'>
<div>
  <input type='text' id='txtRow' style='width:5vw;' disabled></input>
  <table>
   <tr>
     <td>Id</td>
     <td><input type='text' id='txtId' disabled></input></td>
   </tr>
   <tr>
     <td>Nome</td>
     <td><input type='text' id='txtNome' style='width:10vw'></input></td>
   </tr>
   <tr>
     <td>Email</td>
     <td><input type='text' id='txtEmail' style='width:10vw'></input></td>
   </tr>
   <tr>
     <td>Usuario</td>
     <td><input type='text' id='txtUser' style='width:10vw'></input></td>
   </tr>
   <tr>
     <td>Senha</td>
     <td><input type='text' id='txtPwd' style='width:10vw'></input></td>
   </tr>
   <tr>
     <td>Senha Atual</td>
     <td><p id='txtSenhaAtual'></p></td>
   </tr>
   <tr>
     <td>Root (Tem acesso ao Cad. Usuários)</td>
     <td><input type='checkbox' id='txtRoot' style='width:10vw'></input></td>
   </tr>
  </table>
</div>
</div>

<div id='dialog-message' title='Message'>
  <p id='txtmsgbox'></p>
</div>
<div id='dialog-delete' title='Atenção!'>
  <p>Deleta o item?</p><br>
  <p id='delItem'></p>  
</div>
	
</body>
</html>
