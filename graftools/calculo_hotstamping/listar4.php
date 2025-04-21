<?php
include '../../includes/config.php';

$registros_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $registros_por_pagina;

$sql = "SELECT * FROM db ORDER BY db_ID DESC LIMIT $registros_por_pagina OFFSET $offset";
$result = $conn->query($sql);
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
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            display: inline-block;
        }
        .next {
            background-color: blue;
            color: white;
        }
        .prev {
            background-color: green;
            color: white;
        }
        .back {
            background-color: lightyellow;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Lista de Registros</h1>
    <table>
        <tr>
            <th>ID</th>
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
            <th>Máx. Mts Lineares</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo number_format($row['db_id'], 0, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($row['db_CLI_RZ_SOCIAL']); ?></td>
                <td><?php echo number_format($row['db_TOT_FLS'], 0, ',', '.'); ?></td>
                <td><?php echo number_format($row['db_NUM_CALC'], 0, '', '.'); ?></td>
                <td><?php echo number_format($row['db_NUM_PROJ'], 0, '', '.'); ?></td>
                <td><?php echo number_format($row['db_NUM_FACA'], 0, '', '.'); ?></td>
                <td><?php echo number_format($row['db_NUM_OP'], 0, '', '.'); ?></td>
                <td><?php echo date('d-m-Y', strtotime($row['db_DATA_CAD'])); ?></td>
                <td><?php echo htmlspecialchars($row['db_FITA_HOT']); ?></td>
                <td><?php echo htmlspecialchars($row['db_SENTIDO_FITA']); ?></td>
                <td><?php echo number_format($row['db_QUEBRA'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($row['db_LARG_B_F'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($row['db_MAX_MTS_BOB'], 2, ',', '.'); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="pagination">
        <?php if ($pagina_atual > 1): ?>
            <a href="?pagina=<?php echo $pagina_atual - 1; ?>" class="prev">Anterior</a>
        <?php endif; ?>

        <a href="index.php" class="back">Voltar</a>

        <?php if ($result->num_rows == $registros_por_pagina): ?>
            <a href="?pagina=<?php echo $pagina_atual + 1; ?>" class="next">Próxima</a>
        <?php endif; ?>
    </div>
</body>
</html>
