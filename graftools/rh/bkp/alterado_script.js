function downloadPDF() 
{
  const item = document.querySelector(".Content");

  var opt = {
  margin: 1,
  filename: "PO RHS 006 Movimentação Pessoal Rev 00.pdf",
  html2canvas: { scale: 2 },
  jsPDF: { unit: "in", format: "A4", orientation: "portrait" },
 };

  html2pdf().set(opt).from(item).save();
}

function pegardata() 
{
  const data = new Date()

  const dia = String(data.getDate()).padStart(2, '0') // 1 -> 01

  const mes = String(data.getMonth() + 1).padStart(2, '0') // jan = 0, 3 -< 03

  const ano = data.getFullYear() // 2023

  const dataAtual = ${dia}/${mes}/${ano}

  console.log(dataAtual)
  
}

function pegardata_II() 
{
  const myDate = new Date().toLocaleDateString();
  console.log(myDate); // 29/07/2022 
  const myInput = document.querySelector("#date-input");
  myInput.value = myDate;
}