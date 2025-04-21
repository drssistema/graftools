function downloadPDF() {
    const item = document.querySelector(".Content");
  
    var opt = {
      margin: [10, 10, 10, 10],
      filename: "Formulário Movimentação de Pessoal - MP - REV._ 00.pdf",
      html2canvas: { scale: 2 },
      jsPDF: { unit: "mm", format: "a4", orientation: "l" },
    };
  
    html2pdf().set(opt).from(item).save();
  }