<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="icones/favicon.ico" type="image/x-icon">
	<script language='JavaScript' type='text/JavaScript'>	
		function abertura2(form)
	        {
	            {              
					location='http://www.drssistemas.com.br/menu/abertura_graftools.htm' ;
	            }
	        }
	</script>

	<title>Gerar PDF com conteudo HTML</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
	<h1>Gerar PDF com conteúdo HTML</h1>

	<button onclick="gerarPdf()">Gerar PDF</button>
	<!-- 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" 
		integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwkvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" 
		crossorigin="anonymous">
	</script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" 
	integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" 
	crossorigin="anonymous" 
	referrerpolicy="no-referrer">
	</script>
	-->
	<script>
		function gerarPdf() 
		{
			// Instanciar o jsPDF
			var doc = new jsPDF();

			// Conteúdo HTML que deve estar no PDF
			doc.fromHTML('<h1>Gerar PDF com conteúdo HTML</h1>', 15, 15);

			//Gerar PDF
			doc.save('Arq_PDF.pdf');
		}
	</script>
	<form name='abertura'>
    	<input type='button' value=' VOLTAR MENU CADASTRO ' onClick='abertura2(this.form)'>
    </form>
</body>

</html>