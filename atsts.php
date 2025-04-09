<?php
// Inclui o arquivo de configuração
require_once('config.php');

// Verifica se o IP do usuário foi recebido
if(isset($_POST['ip'])) {
    // Obtém o IP do usuário
    $userIP = $_POST['ip'];

    // Realize a conexão com o banco de dados usando as credenciais do arquivo config.php
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verifica a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifique se já existe um registro para este IP na tabela
    $sql = "SELECT * FROM usuarios WHERE ip = '$userIP'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Se já existir um registro para este IP, atualize o status
        $sql_update = "UPDATE usuarios SET status = 'ativo' WHERE ip = '$userIP'";
        if ($conn->query($sql_update) === TRUE) {
            echo "O status do usuário foi atualizado para ativo.";
        } else {
            echo "Erro ao atualizar o status do usuário: " . $conn->error;
        }
    } else {
        // Se não existir um registro para este IP, insira um novo registro
        $sql_insert = "INSERT INTO usuarios (ip, status) VALUES ('$userIP', 'ativo')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Um novo registro foi inserido para este IP com status ativo.";
        } else {
            echo "Erro ao inserir um novo registro: " . $conn->error;
        }
    }

    // Feche a conexão com o banco de dados
    $conn->close();
} else {
    // Se o IP não foi recebido, responda com "inativo"
    echo "inativo";
}
?>
