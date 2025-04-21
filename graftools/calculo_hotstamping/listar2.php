<?php
include '../../includes/config.php';

$sql = "SELECT * FROM db";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../menu/icones/favicon.ico" type="image/x-icon" />
    <title>CONSULTA HOTSTAMPING</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center; /* Centralizar valores */
        }
    </style>
</head>
<body>
    <h1>CONSULTA DOS CÁLCULOS DE (HOTSTAMPING)</h1>
    <table>
        <tr>
            <th>Data Cadastro</th>
            <th>ID Cadastro</th>
            <th>Razão Social</th>
            <th>Núm Cálculo</th>
            <th>Núm Projeto</th>
            <th>Núm da Faca</th>
            <th>Núm da O.P.</th>
            <th>Cor Fita Hot</th>
            <th>Sentido Fita</th>
            <th>Quebra (%)</th>
            <th>Total Folhas</th>
            <th>Total FLS + Quebra</th>
            <th>Larg. Bob. Forn.</th>
            <th>Máx. Mts Lin.</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Formatar data como dia-mês-ano
                $data_cad = date("d-m-Y", strtotime($row["db_DATA_CAD"]));

                // Formatar números acima de 1.000 com pontuação
                $tot_fls = number_format($row["db_TOT_FLS"], 0, ",", ".");
                $tot_fls_quebra = number_format($row["db_TOT_FLS"] * (1 + ($row["db_QUEBRA"] / 100)), 0, ",", ".");
                $larg_b_f = number_format($row["db_LARG_B_F"], 0, ",", ".");
                $max_mts_bob = number_format($row["db_MAX_MTS_BOB"], 0, ",", ".");

                echo "<tr>
                    <td>$data_cad</td>
                    <td>{$row["db_CLI_ID"]}</td>
                    <td>{$row["db_CLI_RZ_SOCIAL"]}</td>
                    <td>{$row["db_NUM_CALC"]}</td>
                    <td>{$row["db_NUM_PROJ"]}</td>
                    <td>{$row["db_NUM_FACA"]}</td>
                    <td>{$row["db_NUM_OP"]}</td>
                    <td>{$row["db_FITA_HOT"]}</td>
                    <td>{$row["db_SENTIDO_FITA"]}</td>
                    <td>{$row["db_QUEBRA"]} %</td>
                    <td>$tot_fls</td>
                    <td>$tot_fls_quebra</td>
                    <td>$larg_b_f</td>
                    <td>$max_mts_bob</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='14'>Nenhum registro encontrado.</td></tr>";
        }
        ?>
    </table>
    <a href="index.php"><button type="button">Voltar</button></a>
</body>
</html>
