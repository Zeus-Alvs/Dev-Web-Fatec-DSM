<?php
    session_start();
    if(isset($_SESSION['email'])){
        $arquivo = fopen("contas.txt","r");

        while(($linha = fgets($arquivo)) !== false){
            $linha = trim($linha);
            $linhas = explode(':',$linha);
            $chave = $linhas[0];
            $chave = trim($linhas[0]);
            $array_linhas = $linhas[1];
            $valores = explode('|', $array_linhas);

            $contas[$chave] = $valores;
                
        }
        
        $email = $_SESSION['email'];
        $conta = $contas[$email];
        $nome = $conta[0];

        fclose($arquivo);
    }
    else{
    header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        
        <h2>Bem-vindo, <?php echo $nome;?>!</h2>
        <h3>E-mail: <?php echo $email ?></h3>
        <p><a href="logout.php" class="botao" >Logout</a></p>

    </main>
</body>
</html>