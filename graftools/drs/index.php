<?php

//echo "<h1>VAI !!!!</h1>";


// Carregar o Composer
require 'C:/wamp64/www/drs/vendor/autoload.php';

// Referenciar o namespace Dompdf
use Dompdf\Dompdf;

// Instanciar e usar a classe dompdf
$dompdf = new Dompdf();

// Instanciar o metodo loadHtml e enviar o conteudo do PDF
$dompdf->loadHtml('DRS SISTEMAS - Gerar PDF com PHP');

// Configurar o tamanho e a orientação do papel
// portrait - Imprimir no formato Retrato
// landscape - Imprimir no formato Paisagem
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Gerar o PDF
$dompdf->stream('arquivo.pdf');
