function gerarPdf() {
  const item = document.querySelector(".Content");

  var opt = {
    margin: 20,
    filename: "PO RHS 006 Movimentação Pessoal Rev 00.pdf",
    html2canvas: { scale: 2 },
    jsPDF: { unit: "mm", format: "A4", orientation: "landscape" },
  };

  html2pdf().set(opt).from(item).save();
}

function downloadPDF() {
  const item = document.querySelector(".Content");

  var opt = {
    margin: 1,
    filename: "PO RHS 006 Movimentação Pessoal Rev 00.pdf",
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "A4", orientation: "portrait" },
  };

  html2pdf().set(opt).from(item).save();
}
