<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <style>
        h1, h3, h2{
            text-align: center;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .quizfundo{
            background-color:aquamarine;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: auto;
            text-align: center;
            border-radius: 5px;
            max-width: 45%;
        }
        .resposta{
            text-align: left;
            margin-left: 25%;
        }
        .quizfundo select {
            border-radius: 5px;
            padding: 2%;
            width: 90%;
            font-size: 16px;
        }
        .button{
            padding: 2%;
        }
        .button button {
            background-color: orange;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            padding: 2%;
            width: 90%;
        }

    </style>
</head>
<body>
<h1>Quiz de Conhecimentos Gerais</h1>
<?php  
    // definicao array quiz
    $quiz = [
        "Matematica" => [
            [
            'pergunta' => 'Quanto é 10 + 10?',
            'opcoes' => ['15', '18', '20', '30'],
            'resposta_correta' => '20'
            ],
            [
            'pergunta' => 'Quanto é 400 * 5?',
            'opcoes' => ['3400', '4000', '2000', '2800'],
            'resposta_correta' => '2000'
            ],
            [
            'pergunta' => 'Quanto é x * 10 = 900?',
            'opcoes' => ['8', '90', '100', '80'],
            'resposta_correta' => '90'
            ],
            [
            'pergunta' => 'Quanto é 10% de 120?',
            'opcoes' => ['15', '8', '12', '24'],
            'resposta_correta' => '12'
            ],
            [
            'pergunta' => 'Quanto é a raiz quadrada de 81?',
            'opcoes' => ['7', '8', '9', '10'],
            'resposta_correta' => '9'
            ]
        ],
    "Geografia" => [
            [
            'pergunta' => 'Qual é a capital do Brasil?',
            'opcoes' => ['São Paulo', 'Rio de Janeiro', 'Brasília', 'Praia Grande'],
            'resposta_correta' => 'Brasília'
            ],
            [
            'pergunta' => 'Qual é o maior deserto do mundo?',
            'opcoes' => ['Deserto do Saara', 'Deserto da Arábia', 'Deserto Grandão', 'Antártida'],
            'resposta_correta' => 'Antártida'
            ],
            [
            'pergunta' => 'Em qual continente fica o Egito?',
            'opcoes' => ['Ásia', 'África', 'Europa', 'América do Sul'],
            'resposta_correta' => 'África'
            ],
            [
            'pergunta' => 'Qual o maior oceano do mundo?',
            'opcoes' => ['Oceano Atlântico', 'Oceano Índico', 'Oceano Pacífico', 'Oceano Ártico'],
            'resposta_correta' => 'Oceano Pacífico'
            ],
            [
            'pergunta' => 'Qual país é conhecido como a "Terra do Sol Nascente"?',
            'opcoes' => ['China', 'Coreia do Sul', 'Tailândia', 'Japão'],
            'resposta_correta' => 'Japão'
            ]
        ],
    "Tecnologia" => [
            [
            'pergunta' => 'O que a sigla HTML significa?',
            'opcoes' => ['HyperText Markup Language', 'High-level Text Management Language', 'Hyperlink and Text Markup Language', 'Home Tool Markup Language'],
            'resposta_correta' => 'HyperText Markup Language'
            ],
            [
            'pergunta' => 'Qual empresa criou a linguagem de programação Python?',
            'opcoes' => ['Microsoft', 'Google', 'Apple', 'Nenhum dos anteriores'],
            'resposta_correta' => 'Nenhum dos anteriores'
            ],
            [
            'pergunta' => 'O que é um "bug" em programação?',
            'opcoes' => ['Um erro no código', 'Um tipo de software', 'Uma ferramenta de desenvolvimento', 'Uma funcionalidade extra'],
            'resposta_correta' => 'Um erro no código'
            ],
            [
            'pergunta' => 'Qual é o nome do criador do Facebook?',
            'opcoes' => ['Bill Gates', 'Steve Jobs', 'Mark Zuckerberg', 'Elon Musk'],
            'resposta_correta' => 'Mark Zuckerberg'
            ],
            [
            'pergunta' => 'O que é um IP?',
            'opcoes' => ['Internet Port', 'Inter Protocol', 'Internet Protocol', 'Internal Page'],
            'resposta_correta' => 'Internet Protocol'
            ]
        ]
    ];
    // Resultado do quiz
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tema']) && isset($_POST['respostas'])) {
        $temaSelecionado = $_POST['tema'];
        $respostasUsuario = $_POST['respostas'];
        $acertos = 0;
        $totalPerguntas = count($quiz[$temaSelecionado]);

        foreach($quiz[$temaSelecionado] as $indice => $pergunta) {
            if(isset($respostasUsuario[$indice]) && $respostasUsuario[$indice] === $pergunta['resposta_correta']){
                $acertos++;
            }
        }
        $pontuacao = ($acertos / $totalPerguntas) * 10;

        if ($pontuacao >= 8){
            $mensagem = "Parabéns!! Nota alta.";
            $classe = "success";
        }
        elseif ($pontuacao >= 5){
            $mensagem = "Muito bem mas pode melhorar!";
            $classe = "warning";
        }
        else {
            $mensagem = "Nota baixa horrivel! Treine mais.";
            $classe = "danger";
        }

        echo "<div class='quizfundo'>";
            echo "<h2>Resultado do Quiz - $temaSelecionado </h2>";
            echo "<p>Você acertou - $acertos - de $totalPerguntas perguntas. </p>";
            echo "<p>Sua pontuacao foi: $pontuacao </p>";
            echo "<p> $mensagem </p>";
            echo "<div class='button'>";
                echo "<a href='?'><button>Jogar Novamente</button></a>";
            echo "</div>";
        echo "</div>";
        
        
    // form quiz

    } elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tema'])){

        $temaSelecionado = $_POST['tema'];
        echo '<div class="quizfundo">';
        echo "<h3>Quiz de $temaSelecionado </h3>";
            echo '<form action="" method="post">';
            echo "<input type='hidden' name='tema' value='$temaSelecionado'>";
            
            foreach ($quiz[$temaSelecionado] as $indice => $pergunta){
                    echo '<div class="resposta">';
                    echo '<p>' .  ($indice + 1) . '. ' . $pergunta['pergunta'] . '</p>';
                    
                        foreach ($pergunta['opcoes'] as $opcao){
                            echo "<label>";
                                echo "<input type='radio' name='respostas[$indice]' value='$opcao' required>";
                                echo $opcao . '<br>';
                            echo "</label>";
                        }
                    echo "</div>";
                
            }
            
    ?>
    <div class="button">
        <button type="submit">Enviar respostas</button>
    </div>
    <?php
    echo "</div>";
    echo "</form>";
    
    }
    else {
    ?>

    <!-- form tema -->
        
        <form action="" method="post" class="quizfundo">
        <h3>Escolha um tema:</h3>
        <select name="tema">
            <?php
                foreach($quiz as $chave => $valor){
                    echo "<option value='$chave'>$chave</option>";
                }
            ?>
        </select>
        <div class="button">
                <button type="submit">Selecionar Tema</button>
        </div>
    </form>
    <?php
    }
    ?>
</body>
</html>

