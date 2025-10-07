<?php
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $email = $_POST['email'];
        $senha = $_POST['senha'];

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
        if(isset($contas[$email])){
            $conta = $contas[$email];
            $senhaConta = trim($conta[1]);
            
            if($senha === $senhaConta){
                session_start();
                $_SESSION['email'] = $email;
                header('Location: usuario.php');
                exit;
            }
            else{
                $mensagemErro = "Senha incorreta!";
                setcookie("Msg", $mensagemErro, time() + 1);
                header('Location: login.php');
            }
        }
        else{
            $mensagemErro = "E-mail incorreto!";
            setcookie("Msg", $mensagemErro, time() + 1);
            header('Location: login.php');
        }
        fclose($arquivo);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <main class="container">
        <h2>Login</h2>

        <form method="POST" action="#">
            <h3>E-mail:</h3>
            <input type="text" name="email" value="<?php if(isset($_COOKIE['email'])){
                echo $_COOKIE['email']; 
            }?>">
            <h3>Senha: </h3>
            <input type="text" name="senha">
            <input type="submit" value="Entrar" class="botao">
            <p><a href="index.php" class="botao" >Cadastrar</a></p>

        </form>
<?php
    if(isset($_COOKIE['Msg'])){
        echo "<h2>" . $_COOKIE['Msg'] . "</h2>";
    }
?>

    </main>
</body>
</html>