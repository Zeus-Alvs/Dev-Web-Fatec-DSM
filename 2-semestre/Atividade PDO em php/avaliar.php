<?php
    require 'config.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST"){

        $query = $pdo->prepare("INSERT INTO avaliacao (nome, estrelas, comentario)
        VALUES (?, ?, ?)");
        $query->execute([$_POST['nome'], $_POST['estrelas'], $_POST['comentario']]);
        header("Location: index.php");
        exit; 
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍪 Cookie Delícia - Entrar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="imagens/cookie.png" alt="icone" class="icone">
            <h1>Cookie Delícia</h1>
        </div>
        <nav>
            <a href="index.php#inicio">Início</a>
            <a href="index.php#produtos">Produtos</a>
            <a href="index.php#avaliacoes">Avaliações</a>
            <a href="index.php#contato">Contato</a>
        </nav>
        <?php if(isset($_SESSION['usuario_id'])){
        ?>
        <div class="login">
            <img src="<?php echo $_SESSION['usuario_foto'] ?>" alt="usuario">
            <p> <?php echo $_SESSION['usuario_nome'] ?></p>
            <a href="logout.php" class="btn-login">Sair</a>
        </div>
        <?php } else{ ?>
        <div class="login">
            <a href="login.php" class="btn-login">Entrar</a>
        </div>
        <?php } ?>
    </header>

    <main class="caixa-page">
        <div class="caixa-container">
            <h2>Avaliar Produto</h2>
            <form method="POST" class="caixa-form">
                
                <label for="nome">Nome:</label>
                <input type="text" name="nome" required>
                
                <label for="estrelas">Estrelas(1 a 5)</label>
                <input type="text" name="estrelas" required>

                <label for="comentario">Comentário:</label>
                <textarea name="comentario" rows="4" cols="50" required></textarea>

                <button type="submit" class="btn-cta">Salvar Avaliação</button>

                <p class="outra-opcao"><a href="index.php">Voltar para a página inicial</a></p>
            </form>
        </div>
    </main>
    
    <footer id="contato" style="padding: 0;">
        <div class="container">
            <div class="contato-info">
                <br><br><br>
                <h4>Contato</h4>
                <p>✉️ email@cookiedelicia.com.br</p>
                <p>📞 (XX) 9XXXX-XXXX</p>
                <p>📍 Rua dos Cookies, 123 - Cidade Saborosa</p>
            </div>
        </div>
        <p class="copy">&copy; 2025 Cookie Delícia. Todos os direitos reservados.</p>
    </footer>

</body>
</html>