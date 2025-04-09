<?php

$host = "localhost"; // Endereço do servidor MySQL
$dbname = "banqi_db"; // Nome do banco de dados
$username = "root"; // Nome de usuário do MySQL (no seu caso, root)
$password = ""; // Senha do MySQL (no seu caso, em branco)

try {
    // Conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Habilita o modo de erro do PDO para lançar exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Em caso de erro na conexão, exibe uma mensagem de erro
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    die(); // Interrompe o script
}
?>
