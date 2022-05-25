<?php 
    session_start();
    if(!isset($_SESSION["email"]) || !isset($_SESSION["nome"])) {
        header("location: erro.html");
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Editar Dados</title>
        <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css" />
        <link type="text/css" rel="stylesheet" href="./estilos/style.css">
    </head>
    <body style="font-size:14px">
        <header class="w3-container w3-light-blue" style="height:100px">
            <h3 id="infoNome" class="w3-center w3-margin-left w3-justify" style="font-size:22px;margin:0px"></h3>
            <h4 id="infoDados" class="w3-center w3-margin-left w3-justify campoHeader"></h4>        
        </header><br/><br/>
        
        <main class="w3-container w3-half w3-display-middle principal" style="border:1px ;margin-top:40px">
            <form class="w3-container" action="cadastro.php" method="post">
                <div class="w3-section">
                    <label for="nome"><b>Mudar Nome</b></label>
                    <input autofocus required class="campoReq w3-input w3-border w3-margin-bottom" type="text" placeholder="Digite seu Nome" name="nome" id="nome" />
                    
                    <label for="email"><b>Mudar E-mail</b></label>
                    <input required class="campoReq w3-input w3-border w3-margin-bottom" type="email" placeholder="Digite seu email" name="email" id="email" />
                    
                    <label for="dataNascimento"><b>Mudar Data de Nascimento</b></label>
                    <input required class="campoReq w3-input w3-border w3-margin-bottom" type="date" placeholder="Digite sua data de nascimento" name="dataNasc" id="dataNasc" />
                    
                    <label for="senha"><b>Mudar Senha</b></label>
                    <input required class="campoReq campoSenha w3-input w3-border" type="password" placeholder="Digite sua senha atual" name="senhaAtual" id="senhaAtual" />
                    <input required class="campoReq campoSenha novaSenha w3-input w3-border" type="password" placeholder="Digite a nova senha" name="novaSenha" id="novaSenha" />
                    <input required class="campoReq campoSenha novaSenha w3-input w3-border" type="password" placeholder="Repita a nova senha" name="novaSenhaRep" id="novaSenhaRep" />
                    <p id="senha_info"></p>

                    <input class="w3-check" type="checkbox" name="opcao" id="opcao" />
                    <label for="opcao">Exibir senhas</label>

                    <button class="w3-button w3-block w3-section w3-light-blue w3-padding w3-ripple" type="button"><strong>Alterar Campos</strong></button>
                </div>
            </form>
            <div class="" id="resposta"></div>
        </main>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/md5.js"></script>
        <script src="js/jquery.mask.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/organizarDados.js"></script>
        <noscript>
            Seu navegador não suporta código em JavaScript
        </noscript>

        <?php
            $nome = htmlentities(ucfirst(addslashes($_SESSION["nome"])));
            $email = htmlentities(addslashes($_SESSION["email"]));
            $dataNasc = htmlentities(addslashes($_SESSION["dataNasc"]));
            // formatar data para dia-mes-ano
            $dataNasc = date_format(date_create($dataNasc),'d-m-Y');
            
            echo "<script>setInfosTitulo('$nome','$email','$dataNasc')</script>";
        ?>
    </body>
</html>