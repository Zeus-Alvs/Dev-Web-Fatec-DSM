<?php
    require 'config.php';
    session_start();
    if(isset($_SESSION['produto_id'])){
    $query = $pdo->prepare("SELECT * FROM servico WHERE id = ?");
    $query->execute([$_SESSION['produto_id']]);
    $produtos = $query->fetch();
    }
    else{
        header('Location: index.php');
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

        <section id="produtos" class="produtos-vendidos">
            <div class="container">
                <div class="lista-produtos">
                    
                    <div class="card-produto">
                        <h3>Checkout do Cookie</h3>
                        <img src="<?php echo $produtos['foto']?>">
                        <h4><?php echo $produtos['titulo']?></h4>
                        <p><?php echo $produtos['descricao']?></p><br>
                        <a href="avaliar.php" class="compra">Finalizar compra</a>
                    </div>
                </div>
            </div>
        </section>
    
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