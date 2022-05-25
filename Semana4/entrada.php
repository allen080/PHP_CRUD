<?php
    session_start();
    if(!isset($_SESSION["email"])) {
        header("location: erro.html");
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Página inicial</title>
        <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css" />
    </head>
    <body>
        <header class="w3-container w3-teal">
            <h1>Entrada</h1>
        </header>
        <main class="w3-container w3-half w3-margin-top">
            <?php
                $email = $_SESSION["email"];
                $nome = $_SESSION["nome"];
                echo "Olá " . htmlentities($nome);
                echo "<br />Seu e-mail é: " . htmlentities($email);
                //echo "Olá " . $email;
            ?>
            <p>
                <a href="logout.php" class="w3-button w3-black">Logout</a>
            </p>
        </main>
    </body>
</html>