<?php
    require 'config.php';
    session_start();

    $query = $pdo->query("SELECT * FROM avaliacao"); 
    $avaliacoes = $query->fetchAll();
    $query = $pdo->query("SELECT * FROM servico");
    $produtos = $query->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === "POST"){

        $query = $pdo->prepare("INSERT INTO contato (nome, email, mensagem)
        VALUES (?, ?, ?)");
        $query->execute([$_POST['nome'], $_POST['email'], $_POST['mensagem']]);
        header("Location: index.php");
        exit; 
    }
    if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])){
        $produto_id = $_GET['id'];
        $_SESSION['produto_id'] = $produto_id;
        header("Location: checkout.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍪 Cookie Delícia - Seus cookies favoritos!</title>
    <link rel="stylesheet" href="style.css">
    </head>
<body>

    <header>
        <div class="logo">
            <img src="imagens/cookie.png" alt="icone" class="icone">
            <h1>Cookie Delícia</h1>
        </div>
        <nav>
            <a href="#inicio">Início</a>
            <a href="#produtos">Produtos</a>
            <a href="#avaliacoes">Avaliações</a>
            <a href="#contato">Contato</a>
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

    <main>
        
        <section id="inicio" class="hero">
            <div class="container">
                <h2>Seja Bem-Vindo à Sua Dose Diária de Felicidade!</h2>
                <p>Nossos cookies são feitos com ingredientes frescos, muito carinho e a receita da vovó. Crocantes por fora, macios por dentro. Experimente!</p>
                <a href="registrar.php" class="btn-cta">Quero Me Inscrever</a>
            </div>
        </section>

        <section id="produtos" class="produtos-vendidos">
            <div class="container">
                <h3>Os Mais Vendidos da Semana</h3>
                <div class="lista-produtos">
                <?php foreach ($produtos as $p): ?>
                    <form class="card-produto" method="get">
                        <input type="text" name="id" value="<?php echo $p['id']?>" style="display: none">
                        <img src="<?php echo $p['foto']?>">
                        <h4><?php echo $p['titulo']?></h4>
                        <p><?php echo $p['descricao']?></p><br>
                        <button type="submit" class="compra">Comprar</button>
                    </form>
                <?php endforeach ?>
                </div>
            </div>
        </section>

        <section id="avaliacoes" class="avaliacoes">
            <div class="container">
                <h3>O que Nossos Clientes Dizem</h3>
                <div class="lista-avaliacoes">

                <?php foreach ($avaliacoes as $a): ?>    
                    <blockquote class="avaliacao">
                        <p><?php for($i = 0; $i<$a['estrelas']; $i++){
                            echo "<img src='imagens/estrela.png' alt='avaliacao'>";
                        }
                            ?></p>
                        <p><?php echo $a['comentario']?></p>
                        <footer>— <?php echo $a['nome']?></footer>
                    </blockquote>
                <?php endforeach ?>
                </div>
            </div>
        </section>

    </main>

    <footer id="contato">
        <div class="container">
            <div class="contato-info">
                <br><br><br>
                <h4>Contato</h4>
                <p>✉️ email@cookiedelicia.com.br</p>
                <p>📞 (XX) 9XXXX-XXXX</p>
                <p>📍 Rua dos Cookies, 123 - Cidade Saborosa</p>
            </div>
            <form action="#" method="post" class="fale-conosco">
                <h4>Fale Conosco</h4>

                <input type="text" name="nome" required placeholder="Seu Nome"><br><br>

                <input type="email" name="email" required placeholder="Seu Email"><br><br>

                <textarea name="mensagem" rows="4" cols="50" required placeholder="Sua Mensagem"></textarea><br><br>

                <input type="submit" value="Enviar Mensagem" class="btn-cta">
            </div>
        </div>
        <p class="copy">&copy; 2025 Cookie Delícia. Todos os direitos reservados.</p>
    </footer>

</body>
</html>