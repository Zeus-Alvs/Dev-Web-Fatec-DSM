<?php

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];
        $contas = [];

        $arquivo = fopen("contas.txt", "a");
        fwrite($arquivo, $email . ":" . $nome . "|" . $senha . "\n");
        fclose($arquivo);
        setcookie("email", $email, time() + 5);

        
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="container">
        <h2>Cadastro</h2>

        <form method="POST" action="#">
            <h3>Nome: </h3>
            <input type="text" name="nome">
            <h3>E-mail:</h3>
            <input type="text" name="email">
            <h3>Senha: </h3>
            <input type="text" name="senha">
            <input type="submit" value="Salvar" class="botao">
            <p><a href="login.php" class="botao" >Login</a></p>
        </form>

    </main>

</body>
</html>

