<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('user_', true) . '.' . $extensao;
        $caminho_foto = 'imagens/users/' . $nome_arquivo;

        if(!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)){
            echo 'Erro ao salvar a foto.';
        }
    }
    else{
        echo 'Erro no upload da foto.';
    }
    $query = $pdo->query('SELECT id FROM usuario');
    $admin = $query->fetch();
    if($admin === false){
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $query = $pdo->prepare("INSERT INTO usuario (nome, email, senha, foto, nivel) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$_POST['nome'], $_POST['email'], $senha_hash, $caminho_foto, "admin"]);
    }
    else{
    $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $query = $pdo->prepare("INSERT INTO usuario (nome, email, senha, foto) VALUES (?, ?, ?, ?)");
    $query->execute([$_POST['nome'], $_POST['email'], $senha_hash, $caminho_foto ]);
    }

    header("Location: login.php");
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
            <h2>Registrar</h2>
            <form method="POST" class="caixa-form">
                
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required placeholder="Seu Nome">

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required placeholder="seu.email@exemplo.com">
                
                <label for="foto">Foto:</label>
                <input type="file" name="foto" accept="imagens/*" style="margin-bottom: 20px;">

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required placeholder="********">
                
                <button type="submit" class="btn-cta">Registrar</button>
                
                <p class="outra-opcao"><a href="login.php">Já tem uma conta?</a></p>
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