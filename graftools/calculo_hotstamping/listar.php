<?php
include '../../includes/config.php';
session_start();
if(!empty($_SESSION['id'])){
	echo "<h4>";
	echo "Formulário Criado por .: ".$_SESSION['nome']." <br>";
	echo "</h4>";
    $registros_por_pagina = 10;
    $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $offset = ($pagina_atual - 1) * $registros_por_pagina;
    
    $coluna_ordenacao = isset($_GET['ordenar']) ? $_GET['ordenar'] : 'db_ID';
    $ordem = isset($_GET['ordem']) && $_GET['ordem'] === 'asc' ? 'asc' : 'desc';
    
    //$sql = "SELECT * FROM db ORDER BY db_ID DESC LIMIT $registros_por_pagina OFFSET $offset";
    
    $sql = "SELECT * FROM db ORDER BY $coluna_ordenacao $ordem LIMIT $registros_por_pagina OFFSET $offset";
    $result = $conn->query($sql);	

}else{
	$_SESSION['msg'] = "Área restrita";
	header("Location: ../loginhot.php");	
}
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
            <th><a href="?ordenar=db_id&ordem=<?php echo ($coluna_ordenacao == 'db_id' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">id</a></th>
            <th><a href="?ordenar=db_CLI_RZ_SOCIAL&ordem=<?php echo ($coluna_ordenacao == 'db_CLI_RZ_SOCIAL' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Razão Social</a></th>
            <th><a href="?ordenar=db_TOT_FLS&ordem=<?php echo ($coluna_ordenacao == 'db_TOT_FLS' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Total Folhas</a></th>
            <th><a href="?ordenar=db_NUM_CALC&ordem=<?php echo ($coluna_ordenacao == 'db_NUM_CALC' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Nº Cálculo</a></th>
            <th><a href="?ordenar=db_NUM_PROJ&ordem=<?php echo ($coluna_ordenacao == 'db_NUM_PROJ' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Projeto</a></th>
            <th><a href="?ordenar=db_NUM_FACA&ordem=<?php echo ($coluna_ordenacao == 'db_NUM_FACA' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Nº Faca</a></th>
            <th><a href="?ordenar=db_NUM_OP&ordem=<?php echo ($coluna_ordenacao == 'db_NUM_OP' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Nº O.P</a></th>
            <th><a href="?ordenar=db_DATA_CAD&ordem=<?php echo ($coluna_ordenacao == 'db_DATA_CAD' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Data Cadastro</a></th>
            <th><a href="?ordenar=db_FITA_HOT&ordem=<?php echo ($coluna_ordenacao == 'db_FITA_HOT' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Fita Hot</a></th>
            <th><a href="?ordenar=db_SENTIDO_FITA&ordem=<?php echo ($coluna_ordenacao == 'db_SENTIDO_FITA' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Sentido Fita</a></th>
            <th><a href="?ordenar=db_QUEBRA&ordem=<?php echo ($coluna_ordenacao == 'db_QUEBRA' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Quebra</a></th>
            <th><a href="?ordenar=db_LARG_B_F&ordem=<?php echo ($coluna_ordenacao == 'db_LARG_B_F' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Larg. Bobina Forn.</a></th>
            <th><a href="?ordenar=db_MAX_MTS_BOB&ordem=<?php echo ($coluna_ordenacao == 'db_MAX_MTS_BOB' && $ordem == 'asc') ? 'desc' : 'asc'; ?>">Máx. Mts Bob.</a></th>
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
