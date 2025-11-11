<?php
    require 'config.php';
    session_start();
    
    $query = $pdo->prepare('SELECT * FROM usuario WHERE id = ?');
    $query->execute([$_SESSION['usuario_id']]);
    $usuario = $query->fetch();
    $query = $pdo->query("SELECT * FROM avaliacao"); 
    $avaliacoes = $query->fetchAll();
    $query = $pdo->query("SELECT * FROM contato"); 
    $contatos = $query->fetchAll();
    $query = $pdo->query("SELECT * FROM usuario"); 
    $usuarios = $query->fetchAll();
    $query = $pdo->query("SELECT * FROM servico"); 
    $produtos = $query->fetchAll();

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $idget = $_POST['idget'];
        if($idget === "1"){
            $query = $pdo->prepare("DELETE FROM avaliacao WHERE id = ?");
            $query->execute([$_POST['id']]);
        }
        else if($idget === "2"){
            $query = $pdo->prepare("DELETE FROM servico WHERE id = ?");
            $query->execute([$_POST['id']]);
        }
        else if($idget === "3"){
            $query = $pdo->prepare("DELETE FROM contato WHERE id = ?");
            $query->execute([$_POST['id']]);
        }
        else if($idget === "4"){
            $query = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
            $query->execute([$_POST['id']]);
        }
        
    }

    if($usuario['nivel'] != "admin"){
        header('Location: index.php');
    }
    else{
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍪 Cookie Delícia - Entrar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

<?php       
    if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])){
        $id = $_GET['id'];
        if($id === "1"){
?>
<section class="dashboard-tabela">
    <div class="container">
    <form action="dashboard.php">
        <button type="submit" class="back-button">
            <i class="fa-solid fa-angle-left back-icon"></i>
        </button>
    </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Estrelas</th>
                        <th>Comentário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($avaliacoes as $a): ?>
                    <tr>
                        <td><?php echo $a['id']?></td>
                        <td><?php echo $a['nome']?></td>
                        <td>
                            <?php for($i = 0; $i<$a['estrelas']; $i++){
                                echo "<img src='imagens/estrela.png' alt='avaliacao' class='star-icon'>";
                            }
                            ?>
                        </td>
                        <td><?php echo $a['comentario']?></td>
                        
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $a['id']?>">
                                <input type="hidden" name="idget" value="1">
                                <button type="submit" class="btn-tabela-acao">
                                    <i class="fa-solid fa-trash-can"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach?>

                </tbody>
            </table>
        </div>
    </div>
</section>
<?php
        }
        if($id === "3"){
?>
<section class="dashboard-tabela">
    <div class="container">
    <form action="dashboard.php">
        <button type="submit" class="back-button">
            <i class="fa-solid fa-angle-left back-icon"></i>
        </button>
    </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Mensagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($contatos as $c): ?>
                    <tr>
                        <td><?php echo $c['id']?></td>
                        <td><?php echo $c['nome']?></td>
                        <td><?php echo $c['email']?></td>
                        <td><?php echo $c['mensagem']?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $c['id']?>">
                                <input type="hidden" name="idget" value="3">
                                <button type="submit" class="btn-tabela-acao">
                                    <i class="fa-solid fa-trash-can"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</section>

<?php 
    }
        if($id === "2"){
?>
<section class="dashboard-tabela">
    <div class="container">
    <form action="dashboard.php">
        <button type="submit" class="back-button">
            <i class="fa-solid fa-angle-left back-icon"></i>
        </button>
    </form>
        <div class="table-header-controls">
            <a href="adicionar.php" class="btn-novo-servico">
                <i class="fa-solid fa-plus"></i> Novo Serviço
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 10%;">Foto</th>
                        <th style="width: 15%;">Título</th>
                        <th style="width: 45%;">Comentário</th>
                        <th style="width: 25%;">Ações</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?php echo $p['id']?></td>
                        <td>
                            <img src="<?php echo $p['foto']?>" alt="Cookies" class="tabela-foto">
                        </td>
                        <td><?php echo $p['titulo']?></td>
                        <td><?php echo $p['descricao']?></td>
                        <td class="table-actions">
                            <a href="adicionar.php?id=<?php echo $p['id']?>" class="btn-tabela-acao btn-editar">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $p['id']?>">
                                <input type="hidden" name="idget" value="2">
                                <button type="submit" class="btn-tabela-acao">
                                    <i class="fa-solid fa-trash-can"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php 
    }
        if($id === "4"){
?>

<section class="dashboard-tabela">
    <div class="container">
    <form action="dashboard.php">
        <button type="submit" class="back-button">
            <i class="fa-solid fa-angle-left back-icon"></i>
        </button>
    </form>
        <div class="table-header-controls">
            <a href="registrar.php" class="btn-novo-servico">
                <i class="fa-solid fa-plus"></i> Novo Usuário
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 10%;">Foto</th>
                        <th style="width: 20%;">Nome</th>
                        <th style="width: 25%;">E-mail</th>
                        <th style="width: 15%;">Nível</th>
                        <th style="width: 25%;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?php echo $u['id']?></td>
                        <td>
                            <img src="<?php echo $u['foto']?>" class="tabela-foto">
                        </td>
                        <td><?php echo $u['nome']?></td>
                        <td><?php echo $u['email']?></td>
                        <td><?php echo $u['nivel']?></td>

                        <td class="table-actions">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $p['id']?>">
                                <input type="hidden" name="idget" value="4">
                                <button type="submit" class="btn-tabela-acao">
                                    <i class="fa-solid fa-trash-can"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php
        }
    }
    else{
?>
    <main class="dashboard-page">
        <div class="container">
            <h2 class="dashboard-title">Dashboard</h2>
            
            <div class="dashboard-grid">
                
                <form class="dashboard-card" method="get">
                    <input type="text" name="id" value="1" style="display: none">
                    <i class="fa-solid fa-star icon-large"></i> 
                    <h3>Avaliações</h3>
                    <button type="submit" class="access-link">Acessar</button>
                </form>

                <form class="dashboard-card" method="get">
                    <input type="text" name="id" value="2" style="display: none">
                    <i class="fa-solid fa-utensils icon-large"></i> 
                    <h3>Serviços</h3>
                    <button type="submit" class="access-link">Acessar</button>
                </form>

                <form class="dashboard-card" method="get">
                    <input type="text" name="id" value="3" style="display: none">
                    <i class="fa-solid fa-envelope icon-large"></i> 
                    <h3>Contato</h3>
                    <button type="submit" class="access-link">Acessar</button>
                </form>

                <form class="dashboard-card" method="get">
                    <input type="text" name="id" value="4" style="display: none">
                    <i class="fa-solid fa-users icon-large"></i> 
                    <h3>Usuários</h3>
                    <button type="submit" class="access-link">Acessar</button>
                </form>

            </div>
        </div>
    </main>       
<?php
    }
}
?>  
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