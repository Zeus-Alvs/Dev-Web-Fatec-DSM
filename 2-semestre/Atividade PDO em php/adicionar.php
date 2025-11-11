<?php
require 'config.php';
session_start();
if($_SESSION['usuario_nivel'] != "admin"){
    header('Location: index.php');
}
else{
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['editar'] === "2") {
    
    $caminho_foto = null; 

    $query_old_foto = $pdo->prepare("SELECT foto FROM servico WHERE id = ?");
    $query_old_foto->execute([$_POST['id']]); 
    $foto_antiga = $query_old_foto->fetchColumn(); 

    $caminho_foto = $foto_antiga;

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('user_', true) . '.' . $extensao;
        $caminho_foto = 'imagens/' . $nome_arquivo; 
        
        if(!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)){
            echo 'Erro ao salvar a nova foto.';
            
        } 
}

    $query = $pdo->prepare("UPDATE servico SET titulo = ?, foto = ?, descricao = ? WHERE id = ?");
    $query->execute([$_POST['titulo'], $caminho_foto, $_POST['descricao'], $_POST['id']]); 
    
    header("Location: dashboard.php");
    exit;
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('user_', true) . '.' . $extensao;
        $caminho_foto = 'imagens/' . $nome_arquivo;

        if(!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)){
            echo 'Erro ao salvar a foto.';
        }
    }
    else{
        echo 'Erro no upload da foto.';
    }
    $query = $pdo->prepare("INSERT INTO servico (titulo, descricao, foto) VALUES (?, ?, ?)");
    $query->execute([$_POST['titulo'], $_POST['descricao'], $caminho_foto ]);

    header("Location: dashboard.php");
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

<?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $idget = $_GET['id'];
    $query = $pdo->prepare("SELECT * FROM servico WHERE id = ?");
    $query->execute([$idget]); 
    $produtos = $query->fetch();
?>
<main class="caixa-page">
    <div class="caixa-container">
        <h2>Editar Produto</h2>
        <form method="POST" class="caixa-form" enctype="multipart/form-data">
            
            <input type="hidden" name="id" value="<?php echo $idget ?>">
            
            <input type="hidden" name="editar" value="2"> 

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" 
                   value="<?php echo $produtos['titulo']?>"
                   required placeholder="<?php echo $produtos['titulo']?>">
            
            <label for="foto">Foto Atual:</label>
            <img src="<?php echo $produtos['foto']?>" alt="Foto Atual" style="max-width: 100px; margin-bottom: 10px;">
            
            <label for="nova_foto">Mudar Foto (Opcional):</label>
            <input type="file" name="foto" accept="image/*" style="margin-bottom: 20px;">

            <label for="descricao">Descricao:</label>
            <input type="text" id="descricao" name="descricao" 
                   value="<?php echo $produtos['descricao']?>"
                   required placeholder="<?php echo $produtos['descricao']?>">
            
            <button type="submit" class="btn-cta">Atualizar</button>
            
            <p class="outra-opcao"><a href="dashboard.php">Voltar para Dashboard</a></p>
        </form>
    </div>
</main>  

<?php } else { ?>
    <main class="caixa-page">
        <div class="caixa-container">
            <h2>Novo Produto</h2>
            <form method="POST" class="caixa-form">
                
                <label for="nome">Titulo:</label>
                <input type="text" id="titulo" name="titulo" required>
                
                <label for="foto">Foto:</label>
                <input type="file" name="foto" accept="imagens/*" style="margin-bottom: 20px;">

                <label for="nome">Descricao:</label>
                <input type="text" id="descricao" name="descricao" required>
                
                <button type="submit" class="btn-cta">Adicionar</button>
                
                <p class="outra-opcao"><a href="dashboard.php">Voltar para Dashboard</a></p>
            </form>
        </div>
    </main>    
<?php } ?>

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

<?php } ?>