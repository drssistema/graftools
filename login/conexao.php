<?php
$host = "mysql.uhserver.com";
$port = "3306";
$user = "adm_principal";
$pwd = "688657Swf@";
$dbname = "dbferramentas";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

