<?php
session_start();
include "config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos do formulário estão definidos
    if (isset($_POST["cpf"]) && isset($_POST["senha"]) && isset($_POST["ip"])) {
        // Obtém os dados do formulário
        $cpf = $_POST["cpf"];
        $senha = $_POST["senha"];
        $ip = $_POST["ip"];

        try {
            // Prepara a query de inserção
            $sql = "INSERT INTO usuarios (cpf, senha, ip) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            // Executa a query
            $stmt->execute([$cpf, $senha, $ip]);

            // Redireciona para a próxima página após a inserção bem-sucedida
            $_SESSION['erororor'] = "Conta criada com sucesso!";
            header("Location: acesso.php");
            exit();
        } catch (PDOException $e) {
            // Em caso de erro na execução da query
            $_SESSION['erororor'] = "Erro ao criar conta. Por favor, tente novamente.";
            header("Location: acesso.php");
            exit();
        }
    } else {
        // Se os campos do formulário não estiverem definidos
        $_SESSION['erororor'] = "Por favor, preencha todos os campos do formulário.";
        header("Location: acesso.php");
        exit();
    }
}
?>
