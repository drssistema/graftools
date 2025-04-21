var Total_Folhas=0;
var Total_Rolos=0;
var Total_Rolos_Bob_Fornec=0;
var Total_Jogos=0;
var Puxada_Total=0;
var Intervalo_Puxada=0;
var Total_Batidas=0;
var Larg_Total_Utilizada=0;
var Larg_Normal_Crown_MP=0;
var Larg_Duplo_Crown_MP=0;
var Larg_Normal_Kurz=0;
var Larg_Duplo_Kurz=0;
var Larg_Bob_Fornec=0;
var Larg_mm_Bob_Fornec=0;
var Chk_J2_Prim=0;
var Chk_J2_Seg=0;
var Resto_Bobina=0;
var Opcao_Bobina=0;
var Opcao_Rolo=0;
var Min_Mts_Lin=0;
var Res_A=0;
var Res_B=0;
var Res_C=0;
var Res_D=0;
var Res_E=0;
var Res_F=0;
var Res_G=0;

/*
Public Function SO_NUMERO_SO_UMA_VIRGULA(ByVal KeyAscii As MSForms.ReturnInteger, texto As String) As String
    Select Case KeyAscii
    Case 44, 8, 48 To 57
    If KeyAscii = 44 Then If InStr(1, texto, ",", vbTextCompare) > 0 Then KeyAscii = 0
        Case Else
        KeyAscii = 0
    End Select
    SO_NUMERO_SO_UMA_VIRGULA = texto
End Function



Sub ShowForm_Sair_Selecao()
On Error GoTo Erro
Dim Qtd_Plans As Integer
Dim NomePlan As String
NomePlan = ActiveWorkbook.Name
Qtd_Plans = Workbooks.Count
    Application.EnableCancelKey = xlDisabled
    Windows(NomePlan).Activate
    Sheets(1).Select
    Sheets(1).Range("A1").Select
    Workbooks(NomePlan).Save
    If Qtd_Plans > 1 Then
        ThisWorkbook.Application.WindowState = xlMaximized
        Windows(NomePlan).Close
    Else
        Windows(NomePlan).Close
        Application.Quit
        ActiveWorkbook.Application.Quit
    End If
   
    Exit Sub
Erro:
   MsgBox ("ERRO!!!"), vbCritical, "Erro na Rotina [Modulo1].ShowForm_Sair_Selecao()"
End Sub
*/

function Limpar_Var_Res() {
    Res_A = 0;
    document.getElementById('Text_Res_A').value = '';
    Res_B = 0;
    Text_Res_B.Text = 0
    Res_C = 0;
    document.getElementById('Text_Res_C').value = '';
// Res_D = Empty
    document.getElementById('Text_Res_D').value = '';
//   Res_E = Empty
    document.getElementById('Text_Res_E').value = '';
//   Res_F = Empty
    document.getElementById('Text_Res_F').value = '';
//   Res_G = Empty
    document.getElementById('Text_Res_G').value = '';
//   Res_H = Empty
//  Text_Res_H.Text = Empty
//   Res_I = Empty
//  Text_Res_I.Text = Empty
}

function Limpar_Campos_J1_Prim() {
//------- J1_Prim
    document.getElementById('J1_Prim_Opt_Ativo_Sim').checked = true;
    document.getElementById('J1_Prim_Opt_Ativo_Nao').checked = false;
    document.getElementById('Text_J1_Prim_BAT_LONGA').value = '';
    document.getElementById('Text_J1_Prim_BAT_CURTA').value = '';
    document.getElementById('Text_J1_Prim_N_BAT_CURTA').value = '';
    document.getElementById('Text_J1_Prim_PUXADA').value = '';
    document.getElementById('Text_J1_Prim_TOT_BAT').value = '';
    document.getElementById('Text_J1_Prim_LARG_ROLO').value = '';
    document.getElementById('ChkBox_J1_Prim_Nenhum').checked = false;
    document.getElementById('ChkBox_J1_Prim_J2_Prim').checked = false;
    document.getElementById('ChkBox_J1_Prim_J1_Seg').checked = false;
    document.getElementById('ChkBox_J1_Prim_Todos').checked = false;
    document.getElementById('Text_J1_Prim_Puxada_Limpeza').value = '';
    document.getElementById('Text_J1_Prim_BAT_CURTA_2').value = '';
    document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').value = '';
}

function Limpar_Campos_J2_Prim() {
//'------- J2_Prim
    document.getElementById('J2_Prim_Opt_Ativo_Sim').checked = false;
    document.getElementById('J2_Prim_Opt_Ativo_Nao').checked = true;
    document.getElementById('Text_J2_Prim_BAT_LONGA').value = '';
    document.getElementById('Text_J2_Prim_BAT_CURTA').value = '';
    document.getElementById('Text_J2_Prim_N_BAT_CURTA').value = '';
    document.getElementById('Text_J2_Prim_PUXADA').value = '';
    document.getElementById('Text_J2_Prim_TOT_BAT').value = '';
    document.getElementById('Text_J2_Prim_LARG_ROLO').value = '';
    document.getElementById('Text_J2_Prim_Puxada_Limpeza').value = '';
    document.getElementById('Text_J2_Prim_BAT_CURTA_2').value = '';
    document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').value = '';
}

function Limpar_Campos_J1_Seg() {
//'------- J1_Seg
    document.getElementById('J1_Seg_Opt_Ativo_Sim').checked = false;
    document.getElementById('J1_Seg_Opt_Ativo_Nao').checked = true;
    document.getElementById('Text_J1_Seg_BAT_LONGA').value = '';
    document.getElementById('Text_J1_Seg_BAT_CURTA').value = '';
    document.getElementById('Text_J1_Seg_N_BAT_CURTA').value = '';
    document.getElementById('Text_J1_Seg_PUXADA').value = '';
    document.getElementById('Text_J1_Seg_TOT_BAT').value = '';
    document.getElementById('Text_J1_Seg_LARG_ROLO').value = '';
    //document.getElementById('ChkBox_J1_Seg_Nenhum').checked = false;
    //document.getElementById('ChkBox_J1_Seg_J2_Seg').checked = false;
    document.getElementById('Text_J1_Seg_Puxada_Limpeza').value = '';
    document.getElementById('Text_J1_Seg_BAT_CURTA_2').value = '';
    document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').value = '';
}

function Limpar_Campos_J2_Seg() {
//'------- J2_Seg
    document.getElementById('J2_Seg_Opt_Ativo_Sim').checked = false;
    document.getElementById('J2_Seg_Opt_Ativo_Nao').checked = true;
    document.getElementById('Text_J2_Seg_BAT_LONGA').value = '';
    document.getElementById('Text_J2_Seg_BAT_CURTA').value = '';
    document.getElementById('Text_J2_Seg_N_BAT_CURTA').value = '';
    document.getElementById('Text_J2_Seg_PUXADA').value = '';
    document.getElementById('Text_J2_Seg_TOT_BAT').value = '';
    document.getElementById('Text_J2_Seg_LARG_ROLO').value = '';
    document.getElementById('Text_J2_Seg_Puxada_Limpeza').value = '';
    document.getElementById('Text_J2_Seg_BAT_CURTA_2').value = '';
    document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').value = '';
}

function Desabilita_J1_Principal() {
    //Frame_JOB1_Prim.Enabled = False
    document.getElementById('Text_J1_Prim_LARG_ROLO').disabled = true;
    document.getElementById('Text_J1_Prim_Puxada_Limpeza').disabled = true;
    document.getElementById('Text_J1_Prim_BAT_CURTA').disabled = true;
    document.getElementById('Text_J1_Prim_N_BAT_CURTA').disabled = true;
    document.getElementById('Text_J1_Prim_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J1_Prim_BAT_LONGA').disabled = true;
    document.getElementById('Text_J1_Prim_PUXADA').disabled = true;
    document.getElementById('Text_J1_Prim_TOT_BAT').disabled = true;
    document.getElementById('Btn_Limpar_JOB1_Prim').disabled = true;
    document.getElementById('ChkBox_J1_Prim_Nenhum').checked = false;
    document.getElementById('ChkBox_J1_Prim_J1_Seg').checked = false;
    document.getElementById('ChkBox_J1_Prim_J2_Prim').checked = false;
    document.getElementById('ChkBox_J1_Prim_Todos').removeAttribute('checked');
}

function Desabilita_J1_Espelho() {
    //Frame_JOB1_Seg.Enabled = False
    document.getElementById('Text_J1_Seg_LARG_ROLO').disabled = true;
    document.getElementById('Text_J1_Seg_Puxada_Limpeza').disabled = true;
    document.getElementById('Text_J1_Seg_BAT_CURTA').disabled = true;
    document.getElementById('Text_J1_Seg_N_BAT_CURTA').disabled = true;
    document.getElementById('Text_J1_Seg_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J1_Seg_BAT_LONGA').disabled = true;
    document.getElementById('Text_J1_Seg_PUXADA').disabled = true;
    document.getElementById('Text_J1_Seg_TOT_BAT').disabled = true;
}

function Desabilita_J2_Principal() {
    //Frame_JOB2_Prim.Enabled = False
    document.getElementById('Text_J2_Prim_LARG_ROLO').disabled = true;
    document.getElementById('Text_J2_Prim_Puxada_Limpeza').disabled = true;
    document.getElementById('Text_J2_Prim_BAT_CURTA').disabled = true;
    document.getElementById('Text_J2_Prim_N_BAT_CURTA').disabled = true;
    document.getElementById('Text_J2_Prim_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J2_Prim_BAT_LONGA').disabled = true;
    document.getElementById('Text_J2_Prim_PUXADA').disabled = true;
    document.getElementById('Text_J2_Prim_TOT_BAT').disabled = true;
    //document.getElementById('Btn_Limpar_JOB2_Prim').disabled = true;
    //document.getElementById('Frame_Puxar_J1.Enabled = False
//'    Opt_Puxar_J1.Enabled = False
//'    Opt_N_Puxar_J1.Enabled = True
    document.getElementById('Opt_Puxar_J1').checked = false;
    document.getElementById('Opt_N_Puxar_J1').checked = false;
}

function Desabilita_J2_Espelho() {
    //Frame_JOB2_Seg.Enabled = False
    document.getElementById('Text_J2_Seg_LARG_ROLO').disabled = true;
    document.getElementById('Text_J2_Seg_Puxada_Limpeza').disabled = true;
    document.getElementById('Text_J2_Seg_BAT_CURTA').disabled = true;
    document.getElementById('Text_J2_Seg_N_BAT_CURTA').disabled = true;
    document.getElementById('Text_J2_Seg_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').disabled = true;
    document.getElementById('Text_J2_Seg_BAT_LONGA').disabled = true;
    document.getElementById('Text_J2_Seg_PUXADA').disabled = true;
    document.getElementById('Text_J2_Seg_TOT_BAT').disabled = true;
}

function Habilita_J1_Principal() {
    //Frame_JOB1_Prim.Enabled = True
    document.getElementById('Text_J1_Prim_LARG_ROLO').disabled = false;
    document.getElementById('Text_J1_Prim_Puxada_Limpeza').disabled = false;
    document.getElementById('Text_J1_Prim_BAT_CURTA').disabled = false;
    document.getElementById('Text_J1_Prim_N_BAT_CURTA').disabled = false;
    document.getElementById('Text_J1_Prim_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J1_Prim_N_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J1_Prim_BAT_LONGA').disabled = true;
    document.getElementById('Text_J1_Prim_PUXADA').disabled = false;
    document.getElementById('Text_J1_Prim_TOT_BAT').disabled = false;
    document.getElementById('Btn_Limpar_JOB1_Prim').disabled = false;
    document.getElementById('ChkBox_J1_Prim_Nenhum').disabled = false;
    document.getElementById('ChkBox_J1_Prim_J1_Seg').disabled = false;
    document.getElementById('ChkBox_J1_Prim_J2_Prim').disabled = false;
    document.getElementById('ChkBox_J1_Prim_Todos').disabled = false;
}

function Habilita_J1_Espelho() {
    //Frame_JOB1_Seg.Enabled = True
    document.getElementById('Text_J1_Seg_LARG_ROLO').disabled = false;
    document.getElementById('Text_J1_Seg_Puxada_Limpeza').disabled = false;
    document.getElementById('Text_J1_Seg_BAT_CURTA').disabled = false;
    document.getElementById('Text_J1_Seg_N_BAT_CURTA').disabled = false;
    document.getElementById('Text_J1_Seg_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J1_Seg_N_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J1_Seg_BAT_LONGA').disabled = false;
    document.getElementById('Text_J1_Seg_PUXADA').disabled = false;
    document.getElementById('Text_J1_Seg_TOT_BAT').disabled = false;
}

function Habilita_J2_Principal() {
    //Frame_JOB2_Prim.Enabled = True
    document.getElementById('Text_J2_Prim_LARG_ROLO').disabled = false;
    document.getElementById('Text_J2_Prim_Puxada_Limpeza').disabled = false;
    document.getElementById('Text_J2_Prim_BAT_CURTA').disabled = false;
    document.getElementById('Text_J2_Prim_N_BAT_CURTA').disabled = false;
    document.getElementById('Text_J2_Prim_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J2_Prim_N_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J2_Prim_BAT_LONGA').disabled = false;
    document.getElementById('Text_J2_Prim_PUXADA').disabled = false;
    document.getElementById('Text_J2_Prim_TOT_BAT').disabled = false;
    //document.getElementById('Btn_Limpar_JOB2_Prim.').disabled = false;
    //document.getElementById('Frame_Puxar_J1').disabled = false;
    document.getElementById('Opt_Puxar_J1').disabled = false;
    document.getElementById('Opt_N_Puxar_J1').disabled = false;
}

function Habilita_J2_Espelho() {
    //Frame_JOB2_Seg.Enabled = True
    document.getElementById('Text_J2_Seg_LARG_ROLO').disabled = false;
    document.getElementById('Text_J2_Seg_Puxada_Limpeza').disabled = false;
    document.getElementById('Text_J2_Seg_BAT_CURTA').disabled = true;
    document.getElementById('Text_J2_Seg_N_BAT_CURTA').disabled = false;
    document.getElementById('Text_J2_Seg_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J2_Seg_N_BAT_CURTA_2').disabled = false;
    document.getElementById('Text_J2_Seg_BAT_LONGA').disabled = false;
    document.getElementById('Text_J2_Seg_PUXADA').disabled = false;
    document.getElementById('Text_J2_Seg_TOT_BAT').disabled = false;
}

function Resultado_A() {
    if (document.getElementById('Text_Total_Folhas').value != "")
        Total_Folhas = Number(Number(document.getElementById('Text_Total_Folhas').value).toFixed(4));
    else {
        Res_A = 0;
        return;
    }
    if (document.getElementById('Text_J1_Prim_PUXADA').value != "")
        Puxada_Total = Number(Number(document.getElementById('Text_J1_Prim_PUXADA').value).toFixed(4));
    else {
        Res_A = 0;
        return;
    }
    if (Text_J1_Prim_TOT_BAT.Text != "")
        Total_Batidas = Number(Number(document.getElementById('Text_J1_Prim_TOT_BAT').value).toFixed(4));
    else {
        Res_A = 0;
        return
    }
    if (Total_Folhas == 0 || Puxada_Total == 0 || Total_Batidas == 0) return;
    Res_A = (Total_Folhas * (Puxada_Total / 1000)) / Total_Batidas;
//'    MsgBox "Resultado_A =  " & Res_A
    document.getElementById('Text_Res_A').value = Number(Res_A.toFixed(2));
}

function Resultado_B() {
    while (Res_B == 0) {
        Res_A = Number(document.getElementById('Text_Res_A').value);          //' Resultado A (Primeiro Resultado mts lineares)
        if ($('#Lbl_Larg_Produzir_Hot').text() != "")
            Larg_Total_Utilizada = Number(Number($('#Lbl_Larg_Produzir_Hot').text()).toFixed(4)); //' Largura Total Utilizada
        else {
            Res_B = 0;
            break;
        }
//'       Larg_Total_Utilizada = Larg_Total_Utilizada / 1000
        Res_B = Res_A * (Larg_Total_Utilizada / 1000);
//'        MsgBox "Resultado_B =  " & Res_B
        document.getElementById('Text_Res_B').value = Number(Res_B.toFixed(2));
        Total_Rolos_Bob_Fornec = Larg_mm_Bob_Fornec / (Larg_Total_Utilizada / Total_Rolos)
    }
}
function Resultado_C() {
    if (Opcao_Bobina == true) {
        while (Res_C == 0) {
            Larg_Bob_Fornec = Number(Number(document.getElementById('LBL_Larg_Bob_Fornec').value).toFixed(4));
            Res_C = Res_B / (Larg_Bob_Fornec)
//'           MsgBox "Resultado_C =  " & Res_C
            document.getElementById('Text_Res_C').value = Number(Res_C.toFixed(2));
        }
	}	
    else {
        Res_C = Res_A;
        document.getElementById('Text_Res_C').value = Number(Res_C.toFixed(2));
    }
}

function Resultado_D() {
	//'**************************************************************************************************************************
	//'* Pegar a Largura da Bobina do Fornecedor e Dividir pela Largura de um rolo de Hotstamping (Larg menor da área da puxada)*
	//'**************************************************************************************************************************
	var Var_Qualquer=0;
	var Mai_Tot_RL_B_Fornec=0;
	var Men_Tot_RL_B_Fornec=0;
	var Mai_Sld_RL_B_Fornec=0;
	var Men_Sld_RL_B_Fornec=0;
	var Var_Res_D_001=0;
	var Var_Res_D_002=0;
	var Maior=0;
	var Menor=0;
	var Saldo_Rolos=0;
	var Contador=0;
	var Bob_Adicional=0;
	var Min_Mult_Bobs=0;
	var Var_Media_Rolo=0;
	var Var_Resto_Bobina=0;
	var Num=0;
	var Mensagem='';
	var Cont_Mult=0;
	var RES_DD=0;
	var sld_rolos=0;
	var Var_Num_Bobinas=0;
	var Var_Qtd_Bobinas=0;
	var Mts_Lin_por_Bob=0;
	var Num_Bobs_Maior=0;
	var Num_Bobs_Menor=0;
	var Mts_Lin_Maior=0;
	var Mts_Lin_Menor=0;
	var WText_Res_C=0;
	var WLbl_Max_Lineares=0;
	var WLbl_Min_Lineares=0;
	var Num_Jogos=0;
	Contador = 0;
	Min_Mult_Bobs = 0;
	Var_Res_D_001 = 0;
	Var_Res_D_002 = 0;
	RES_DD = 0;
	Var_Media_Rolo = Larg_Total_Utilizada / Total_Rolos;
	Num_Jogos = 0;


	//'*************************************************************************************************
	//' ROTINA PARA ISOLAR OS DECIMAIS PARA O CALCULO DE TOTAL DE ROLOS DENTRO DA BOBINA DO FORNECEDOR *
	//'*************************************************************************************************
	Mai_Tot_RL_B_Fornec = Number(Total_Rolos_Bob_Fornec.toFixed(0));
	if (Mai_Tot_RL_B_Fornec == Total_Rolos_Bob_Fornec) {
		Men_Tot_RL_B_Fornec = 0;
	}	
	else if (Mai_Tot_RL_B_Fornec > Total_Rolos_Bob_Fornec) {
		Mai_Tot_RL_B_Fornec = Mai_Tot_RL_B_Fornec - 1;
		Men_Tot_RL_B_Fornec = (Total_Rolos_Bob_Fornec - Mai_Tot_RL_B_Fornec);
	}	
	else if (Mai_Tot_RL_B_Fornec < Total_Rolos_Bob_Fornec) {
		Men_Tot_RL_B_Fornec = (Total_Rolos_Bob_Fornec - Mai_Tot_RL_B_Fornec);
	}
	Res_D = Mai_Tot_RL_B_Fornec;
	//'*************************************************************************************************

	//'*************************************************************************************************
	//' ROTINA PARA LOCALIZAR A QUANTIDADE DE JOGOS                                                    *
	//'*************************************************************************************************
	RES_DD = Number((Res_D / Total_Rolos).toFixed(2));
	let vaux1 = RES_DD;
	Var_Res_D_001 = Math.round(vaux1);
	if (Var_Res_D_001 == RES_DD) {
		Var_Res_D_002 = 0;
	}	
	else if (Var_Res_D_001 > RES_DD) {
		Var_Res_D_001 = Var_Res_D_001 - 1;
		Var_Res_D_002 = RES_DD - Var_Res_D_001;
	}	
	else if (Var_Res_D_001 < RES_DD) { 
		Var_Res_D_002 = RES_DD - Var_Res_D_001;
	}
	//'*************************************************************************************************


	//'*************************************************************************************************
	//' ROTINA PARA ISOLAR OS DECIMAIS PARA O CALCULO DE SALDO DE ROLOS DENTRO DA BOBINA DO FORNECEDOR *
	//'*************************************************************************************************
	Mai_Sld_RL_B_Fornec = Number((Res_D / Total_Rolos).toFixed(0));
	if (Mai_Sld_RL_B_Fornec == (Res_D / Total_Rolos)) {
		Men_Sld_RL_B_Fornec = 0;
	}	
	else if (Mai_Sld_RL_B_Fornec > (Res_D / Total_Rolos)) {
		Mai_Sld_RL_B_Fornec = Mai_Sld_RL_B_Fornec - 1;
		Men_Sld_RL_B_Fornec = ((Res_D / Total_Rolos) - Mai_Sld_RL_B_Fornec);
	}	
	else if (Mai_Sld_RL_B_Fornec < (Res_D / Total_Rolos)) {
		Men_Sld_RL_B_Fornec = ((Res_D / Total_Rolos) - Mai_Sld_RL_B_Fornec);
	}
	Saldo_Rolos = Total_Rolos * Men_Sld_RL_B_Fornec;
	//'*************************************************************************************************

	//'*************************************************************************************************
	//' ROTINA PARA LOCALIZAR OS MÚLTIPLOS PARA COMPRAR BOBINAS COM O FORNECEDOR DE HOT STAMPING       *
	//'*************************************************************************************************
	while (Contador < 99) {
		if (Saldo_Rolos < Total_Rolos) {
			Cont_Mult = 2;
			while (Cont_Mult < 99) {
				Num = Saldo_Rolos * Cont_Mult;
				if (Num % Total_Rolos == 0) {
					Mensagem = "Numero é multiplo de (" + Total_Rolos + ") ";
					Cont_Mult = 99;
				}	
				else {
					Mensagem = "Numero NÃO É multiplo de (" + Total_Rolos + ") ";
					Cont_Mult = Cont_Mult + 1;
				}
	//'           MsgBox Mensagem & Num
			}
			if (Num > Total_Rolos) {
				Bob_Adicional = Number((Num / Saldo_Rolos).toFixed(2));
				Bob_Adicional = (Total_Rolos + Saldo_Rolos) - Saldo_Rolos;
				Contador = 99;
			}	
			else {
				Bob_Adicional = Number(Num.toFixed(0));
				Contador = 99;
			}
		}	
		else if (Saldo_Rolos == Total_Rolos) {
			Bob_Adicional = 0;
			Contador = 99;
		}	
		else if (Saldo_Rolos > Total_Rolos) {
			let Num0;
			let Num1;
			let Num2; 
			Num0 = Saldo_Rolos / Total_Rolos;
			Num1 = Number(Num1.toFixed(0));
			Num2 = Num0 - Num1;

			if (Num2 > 0) 
				Bob_Adicional = Number((Total_Rolos * Num2).toFixed(0));
			if (Num2 == 0)
				Bob_Adicional = 0;
			Contador = 99;
		}
	}

	Min_Mult_Bobs = Number(Bob_Adicional.toFixed(0));
	//'*************************************************************************************************

	//'*************************************************************************************************
	//' ROTINA PARA INFORMAR TODAS AS CARACTERÍSTICA DESTA COMPRA DE BOBINA DE HOT STAMP C/O FORNECEDOR*
	//'*************************************************************************************************
	Var_Resto_Bobina = Number(Number($('#Lbl_Resto_Bobina').text()).toFixed(0));

	if (Res_D * (Larg_Total_Utilizada / Total_Rolos) > Larg_mm_Bob_Fornec)
		Res_D = Res_D - 1;

	let vaux = "Cada Bobina do Fornecedor de " + Larg_mm_Bob_Fornec + " mm, faz até " 
			   + Res_D + " ROLO(S) de " + Var_Media_Rolo.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}) + " mm, sendo: " 
			   + Var_Res_D_001 + " JOGO(S) com " + Total_Rolos 
			   + " ROLO(S) de " + Var_Media_Rolo.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}) + " mm. ";
	$('#Lbl_Msg_1').text(vaux);
	 


	if (Saldo_Rolos == 0 && Resto_Bobina > 0) {
		vaux = "Ficando um saldo de " + Saldo_Rolos.toFixed(0) 
			   + " ROLO(S) p/cada Bobina, e 1 ROLO c/ um saldo restante de " + Resto_Bobina +
			   " mm. "; //"Será(ão) " + Var_Res_D_001 + " Entrada(s) de Máq. na SBL1";
		$('#Lbl_Msg_2').text(vaux);
	}
	else {
		vaux = "Ficando um saldo de " + Saldo_Rolos.toFixed(0) 
			   + " ROLO(S) de " + Var_Media_Rolo.toLocaleString('pt-BR',{minimumFractionDigits: 2,maximumFractionDigits: 2}) + " mm para cada Bobina. ";
		$('#Lbl_Msg_2').text(vaux);
	}

	//'If Min_Mult_Bobs > 1 Then '********* UTILIZAR APÓS A QUANT TOTAL DE BOBINAS
	//'    Lbl_Msg_3.Caption = "Sendo necessário comprar do fornecedor múltiplos de " _
	//'    & Min_Mult_Bobs & " Bobina(s). Será(ão) " & VBA.FormatNumber(((Res_D * Min_Mult_Bobs) / Total_Rolos), 0) & " Entrada(s) de Máq. na SBL1"
	//'ElseIf Res_D > Total_Rolos Then
	//'    Lbl_Msg_3.Caption = "Será(ão) " & VBA.FormatNumber((Res_D / Total_Rolos), 0) & " Entrada(s) de Máq. na SBL1"
	//'End If

	WText_Res_C = Number(Number(document.getElementById('Text_Res_C').value).toFixed(0));
	WLbl_Max_Lineares = Number(Number(document.getElementById('Lbl_Max_Lineares').value).toFixed(0));
	WLbl_Min_Lineares = Number(Number(document.getElementById('Lbl_Min_Lineares').value).toFixed(0));

	if (WText_Res_C > WLbl_Max_Lineares) {
		Var_Num_Bobinas = WText_Res_C / WLbl_Max_Lineares;
		Num_Bobs_Maior = Number(Number(Var_Num_Bobinas).toFixed(0));
		if (Num_Bobs_Maior == Var_Num_Bobinas) 
			Num_Bobs_Menor = 0;
		else if (Num_Bobs_Maior > Var_Num_Bobinas) 
			Num_Bobs_Menor = Var_Num_Bobinas - (Num_Bobs_Maior - 1);
		else if (Num_Bobs_Maior < Var_Num_Bobinas) {
			Num_Bobs_Maior = Num_Bobs_Maior;
			Num_Bobs_Menor = 0
			Num_Bobs_Menor = Number((Var_Num_Bobinas - Num_Bobs_Maior).toFixed(2));
			if (Num_Bobs_Menor < 0.1)
				Num_Bobs_Maior = Num_Bobs_Maior;
			else
				Num_Bobs_Maior = Num_Bobs_Maior + 1;
		}
	}	
	else {
		Num_Bobs_Maior = 1;
		Num_Bobs_Menor = 0;
	}

	if (Min_Mult_Bobs == 0) { 
		Var_Qtd_Bobinas = Num_Bobs_Maior;
	}	
	else if (Min_Mult_Bobs > 0 && Min_Mult_Bobs < 2) { 
		Var_Qtd_Bobinas = Num_Bobs_Maior;
	}	
	else if (Min_Mult_Bobs > 1 && Min_Mult_Bobs < Num_Bobs_Maior) {
		Cont_Mult = 2;
		while (Cont_Mult < 99) {
			Num = Min_Mult_Bobs * Cont_Mult;
			if ((Num % Min_Mult_Bobs == 0) && Num >= Num_Bobs_Maior) 
				Cont_Mult = 99;
			else
				Cont_Mult = Cont_Mult + 1;
		}
		Var_Qtd_Bobinas = Num;
		Num_Jogos = Var_Qtd_Bobinas * Res_D;
		Num_Jogos = Num_Jogos / Total_Rolos;
	}	
	else if (Min_Mult_Bobs > Num_Bobs_Maior) {
		Var_Qtd_Bobinas = Min_Mult_Bobs
	}

	Mts_Lin_por_Bob = WText_Res_C / Var_Qtd_Bobinas;
	Mts_Lin_por_Bob = Mts_Lin_por_Bob / WLbl_Min_Lineares;

	if (Min_Mult_Bobs > 1) { //'********* UTILIZAR APÓS A QUANT TOTAL DE BOBINAS
		$('#Lbl_Msg_3').text("Sendo necessário comprar do fornecedor múltiplos de " 
		+ Min_Mult_Bobs + " Bobina(s). Será(ão) " + Num_Jogos + " Entrada(s) de Máq. na SBL1");
	}
	else if (Res_D > Total_Rolos) {
		$('#Lbl_Msg_3').text("Será(ão) " + (Res_D / Total_Rolos).toFixed(0) + " Entrada(s) de Máq. na SBL1");
	}

	Mts_Lin_Maior = Number(Mts_Lin_por_Bob.toFixed(0));
	if (Mts_Lin_Maior == Mts_Lin_por_Bob) {
		Mts_Lin_Menor = 0;
	}	
	else if (Mts_Lin_Maior > Mts_Lin_por_Bob) {
		Mts_Lin_Menor = 0;
	}	
	else if (Mts_Lin_Maior < Mts_Lin_por_Bob) {
		Mts_Lin_Maior = Mts_Lin_Maior + 1;
		Mts_Lin_Menor = 0;
	}
	Mts_Lin_por_Bob = Mts_Lin_Maior * WLbl_Min_Lineares;

	document.getElementById('Text_Res_D').value = Number(Var_Qtd_Bobinas.toFixed(2));

	if (Num_Bobs_Menor < 0.1 && Mts_Lin_por_Bob > 2440) 
		document.getElementById('Text_Res_E').value = 2440;
	else
		document.getElementById('Text_Res_E').value = Number(Mts_Lin_por_Bob.toFixed(2));

	let Total_Mts_Lin;
	Total_Mts_Lin = Var_Qtd_Bobinas * Mts_Lin_por_Bob;

	if (Total_Mts_Lin < Min_Mts_Lin) {
	//'    Text_Res_G.Value = VBA.FormatNumber(Min_Mts_Lin, 2)
		document.getElementById('Text_Res_G').value = Number((Number(document.getElementById('Text_Res_D').value) * Number(document.getElementById('Text_Res_E').value)).toFixed(2));
	}
	else {
	//'    Text_Res_G.Value = VBA.FormatNumber(Total_Mts_Lin, 2)
		document.getElementById('Text_Res_G').value = Number((Number(document.getElementById('Text_Res_D').value) * Number(document.getElementById('Text_Res_E').value)).toFixed(2));
	}

	if (document.getElementById('Text_Res_G').value == Number(Min_Mts_Lin.toFixed(2))) {
	//'    Text_Res_F.Value = VBA.FormatNumber((Min_Mts_Lin * Larg_Bob_Fornec), 2)
		document.getElementById('Text_Res_F').value = Number((Number(document.getElementById('Text_Res_G').value) * Larg_Bob_Fornec).toFixed(2));
		//MsgBox "TIRAGEM MÍNIMA DE 156,16 m2 !!!", vbInformation
        $('#txtmsg').text('TIRAGEM MÍNIMA DE 156,16 m2 !!!');
        dialogFMsg.dialog('open');
		
		$('#Lbl_Min_Compra').text("Mínimo Compra!!!");
	}	
	else {
	//'    Text_Res_F.Value = VBA.FormatNumber((Total_Mts_Lin * Larg_Bob_Fornec), 2)
		document.getElementById('Text_Res_F').value = Number((Number(document.getElementById('Text_Res_G').value) * Larg_Bob_Fornec).toFixed(2));
		$('#Lbl_Min_Compra').text('');
	}
}

function Gerar_Combo_Fornecedor() {
  let x = document.getElementById('Cmb_Fornecedor');
  while (x.options.length > 0)
    x.remove(0);
  let option = document.createElement('option');
  option.text = 'Crown / MP';
  option.value = 'Crown';
  x.add(option);
  let option2 = document.createElement('option');
  option2.text = 'Kurz';
  option2.value = 'Kurz';
  x.add(option2);


    //Cmb_Fornecedor.Clear
    //Cmb_Fornecedor.AddItem "Crown / MP"
    //Cmb_Fornecedor.AddItem "Kurz"
}
