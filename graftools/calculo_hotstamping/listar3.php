<?php
include '../../includes/config.php';

// Definindo o número de registros por página
$registros_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $registros_por_pagina;

// Consulta SQL para obter os dados paginados
$sql = "SELECT db_CLI_ID, db_CLI_RZ_SOCIAL, db_TOT_FLS, db_NUM_CALC, db_NUM_PROJ, 
               db_NUM_FACA, db_NUM_OP, DATE_FORMAT(db_DATA_CAD, '%d-%m-%Y') AS db_DATA_CAD, 
               db_FITA_HOT, db_SENTIDO_FITA, db_QUEBRA, db_LARG_B_F, db_MAX_MTS_BOB 
        FROM db 
        LIMIT $registros_por_pagina OFFSET $offset";

$result = $conn->query($sql);

// Contagem total de registros para paginação
$sql_total = "SELECT COUNT(*) as total FROM db";
$result_total = $conn->query($sql_total);
$total_registros = $result_total->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../menu/icones/favicon.ico" type="image/x-icon" />
    <title>Lista de Registros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 12px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
        @media screen and (max-width: 600px) {
            table {
                font-size: 12px;
            }
            th, td {
                padding: 6px;
            }
        }
    </style>
</head>
<body>

    <h1>Lista de Registros</h1>
    <table>
        <tr>
            <th>ID Cliente</th>
            <th>Razão Social</th>
            <th>Total Folhas</th>
            <th>Número Cálculo</th>
            <th>Projeto</th>
            <th>Número Faca</th>
            <th>Número OP</th>
            <th>Data Cadastro</th>
            <th>Fita HOT</th>
            <th>Sentido Fita</th>
            <th>Quebra</th>
            <th>Largura Bobina</th>
            <th>Máx. Metros Lineares</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= number_format($row['db_CLI_ID'], 0, '', '.') ?></td>
                <td><?= htmlspecialchars($row['db_CLI_RZ_SOCIAL']) ?></td>
                <td><?= number_format($row['db_TOT_FLS'], 0, '', '.') ?></td>
                <td><?= number_format($row['db_NUM_CALC'], 0, '', '.') ?></td>
                <td><?= number_format($row['db_NUM_PROJ'], 0, '', '.') ?></td>
                <td><?= number_format($row['db_NUM_FACA'], 0, '', '.') ?></td>
                <td><?= number_format($row['db_NUM_OP'], 0, '', '.') ?></td>
                <td><?= $row['db_DATA_CAD'] ?></td>
                <td><?= htmlspecialchars($row['db_FITA_HOT']) ?></td>
                <td><?= htmlspecialchars($row['db_SENTIDO_FITA']) ?></td>
                <td><?= number_format($row['db_QUEBRA'], 2, ',', '.') ?></td>
                <td><?= number_format($row['db_LARG_B_F'], 2, ',', '.') ?></td>
                <td><?= number_format($row['db_MAX_MTS_BOB'], 2, ',', '.') ?></td>
            </tr>
        <?php endwhile; ?>

    </table>
    
    <div class="pagination">
        <?php if ($pagina_atual > 1): ?>
            <a href="?pagina=<?= $pagina_atual - 1 ?>">&#171; Anterior</a>
        <?php endif; ?>

        <?php if ($pagina_atual < $total_paginas): ?>
            <a href="?pagina=<?= $pagina_atual + 1 ?>">Próxima &#187;</a>
        <?php endif; ?>
    </div>
    <tr>
        <td> </td>
    </tr>
    
    <a href="index.php"><button type="button">Voltar</button></a>
</body>
</html>
