<?php
session_start();
include "config.php"; // Inclui o arquivo config.php para estabelecer a conexão com o banco de dados
include "contagem.php"; // Inclui outros arquivos necessários

// Verifica se a sessão de usuário está ativa
if(!isset($_SESSION['cpf'])){
    header("location: index.php"); // Redireciona para a página de login se o usuário não estiver logado
    exit;
}

// Restante do código do painel.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seu Painel</title>
    <!-- Links para os arquivos CSS e JS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/9464b2a436.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Barra de navegação -->
    <nav>
        <ul>
            <li><a href="painel.php">Painel</a></li>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>

    <!-- Conteúdo do painel -->
    <div class="container">
        <h1>Bem-vindo ao seu painel, <?php echo $_SESSION['cpf']; ?></h1>
        <p>Aqui você pode acessar e gerenciar suas informações.</p>
        <!-- Adicione mais conteúdo conforme necessário -->
    </div>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 SeuSite. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
