<?php
include '../../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Vdb_CLI_ID = $_POST['Vdb_CLI_ID'];
    $Vdb_CLI_RZ_SOCIAL = $_POST['Vdb_CLI_RZ_SOCIAL'];
    $Vdb_TOT_FLS = $_POST['Vdb_TOT_FLS'];
    $Vdb_NUM_CALC = $_POST['Vdb_NUM_CALC'];
    $Vdb_NUM_PROJ = $_POST['Vdb_NUM_PROJ'];
    $Vdb_NUM_FACA = $_POST['Vdb_NUM_FACA'];
    $Vdb_NUM_OP = $_POST['Vdb_NUM_OP'];
    $Vdb_DATA_CAD = date('Y-m-d');
    $Vdb_FITA_HOT = $_POST['Vdb_FITA_HOT'];
    $Vdb_SENTIDO_FITA = $_POST['Vdb_SENTIDO_FITA'];
    $Vdb_QUEBRA = $_POST['Vdb_QUEBRA'];
    $Vdb_LARG_B_F = $_POST['Vdb_LARG_B_F'];
    $Vdb_MAX_MTS_BOB = $_POST['Vdb_MAX_MTS_BOB'];

    $Vdb_TOT_FLS_QUEBRA = $Vdb_TOT_FLS + ($Vdb_TOT_FLS * ($Vdb_QUEBRA / 100));

    $sql = "INSERT INTO db 
    (db_CLI_ID, db_CLI_RZ_SOCIAL, db_TOT_FLS, db_NUM_CALC, db_NUM_PROJ, 
    db_NUM_FACA, db_NUM_OP, db_DATA_CAD, db_FITA_HOT, db_SENTIDO_FITA, 
    db_QUEBRA, db_LARG_B_F, db_MAX_MTS_BOB)
    VALUES 
    (
    '$Vdb_CLI_ID', 
    '$Vdb_CLI_RZ_SOCIAL', 
    '$Vdb_TOT_FLS', 
    '$Vdb_NUM_CALC', 
    '$Vdb_NUM_PROJ', 
    '$Vdb_NUM_FACA', 
    '$Vdb_NUM_OP', 
    '$Vdb_DATA_CAD',
    '$Vdb_FITA_HOT',
    '$Vdb_SENTIDO_FITA',
    '$Vdb_QUEBRA',
    '$Vdb_LARG_B_F',
    '$Vdb_MAX_MTS_BOB'
    );";

    if ($conn->query($sql) === TRUE) {
        echo "Registro inserido com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Incluir Novo Cálculo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        td {
            padding: 10px;
        }

        input, select {
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .botao {
            background-color: #007BFF;
            border: none;
            color: white;
            padding: 12px 24px;
            margin: 15px 10px 0 0;
            border-radius: 10px;
            box-shadow: 0 5px #0056b3;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .botao:hover {
            background-color: #0056b3;
            box-shadow: 0 3px #003d80;
            transform: translateY(2px);
        }

        .botao:active {
            box-shadow: 0 2px #003d80;
            transform: translateY(4px);
        }
    </style>
    <script>
        function calcularTotFlsQuebra() {
            let totFls = parseFloat(document.getElementById('Vdb_TOT_FLS').value) || 0;
            let quebra = parseFloat(document.getElementById('Vdb_QUEBRA').value) || 0;
            let totFlsQuebra = totFls + (totFls * (quebra / 100));
            document.getElementById('Vdb_TOT_FLS_QUEBRA').value = totFlsQuebra.toFixed(2);
        }
    </script>
</head>
<body>
    <h1>Incluir Novo Cálculo</h1>
    <form method="POST">
        <table>
            <tr>
                <td>Data Sistema:</td>
                <td><input type="date" name="Vdb_DATA_CAD" required></td>
            </tr>
            <tr>
                <td>ID Cliente:</td>
                <td><input type="number" name="Vdb_CLI_ID" required></td>
                <td>Razão Social:</td>
                <td><input type="text" name="Vdb_CLI_RZ_SOCIAL" required></td>
                <td>Total Folhas:</td>
                <td><input type="number" id="Vdb_TOT_FLS" name="Vdb_TOT_FLS" required oninput="calcularTotFlsQuebra()"></td>
            </tr>
            <tr>
                <td>Número Cálculo:</td>
                <td><input type="number" name="Vdb_NUM_CALC" required></td>
                <td>Projeto:</td>
                <td><input type="text" name="Vdb_NUM_PROJ" required></td>
                <td>Faca:</td>
                <td><input type="text" name="Vdb_NUM_FACA" required></td>
            </tr>
            <tr>
                <td>OP:</td>
                <td><input type="text" name="Vdb_NUM_OP" required></td>
                <td>Fita Hot:</td>
                <td><input type="text" name="Vdb_FITA_HOT" required></td>
                <td>Sentido Fita:</td>
                <td><input type="text" name="Vdb_SENTIDO_FITA" required></td>
            </tr>
            <tr>
                <td>Quebra (%):</td>
                <td><input type="number" id="Vdb_QUEBRA" name="Vdb_QUEBRA" step="0.01" required oninput="calcularTotFlsQuebra()"></td>
                <td>Total c/ Quebra:</td>
                <td><input type="number" id="Vdb_TOT_FLS_QUEBRA" readonly></td>
                <td>Larg. Bobina Final:</td>
                <td><input type="text" name="Vdb_LARG_B_F" required></td>
            </tr>
            <tr>
                <td>Mts por Bobina:</td>
                <td><input type="text" name="Vdb_MAX_MTS_BOB" required></td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center;">
                    <button type="submit" class="botao">Salvar</button>
                    <button type="reset" class="botao">Limpar</button>
                    <button type="button" class="botao" onclick="window.location.href='index.php'">Voltar</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
