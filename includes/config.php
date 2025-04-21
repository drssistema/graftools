<?php
// Caminho absoluto até o .env
$envPath = $_SERVER['DOCUMENT_ROOT'] . '/.env';

// DEBUG: Mostrar caminho que está sendo verificado
// echo "<pre>";
// echo "Tentando carregar .env de: " . $envPath . "\n";
// echo "file_exists: " . (file_exists($envPath) ? 'SIM' : 'NÃO') . "\n";
// echo "</pre>";


if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);

    // Detectar se está rodando local ou produção
    $serverHost = $_SERVER['HTTP_HOST'] ?? 'localhost';

    if (strpos($serverHost, 'localhost') !== false || strpos($serverHost, '127.0.0.1:3307') !== false) {
        // Localhost
        $host = $env['DB_HOST_LOCAL'];
        $user = $env['DB_USER_LOCAL'];
        $pass = $env['DB_PASS_LOCAL'];
        $dbname = $env['DB_NAME_LOCAL'];
    } else {
        // Produção
        $host = $env['DB_HOST_PROD'];
        $user = $env['DB_USER_PROD'];
        $pass = $env['DB_PASS_PROD'];
        $dbname = $env['DB_NAME_PROD'];
    }

    // Criar a conexão
    $conn = mysqli_connect($host, $user, $pass, $dbname);

    if (!$conn) {
        die("Erro na conexão: " . mysqli_connect_error());
    }
} else {
    die("Arquivo .env nao encontrado.");
}
?>
