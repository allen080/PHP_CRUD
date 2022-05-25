<?php
    /*
        Considerar Banco de Dados "ifsp" com a tabela "usuario" 
        e os campos nome, cpf, dataNasc, email e senha criados (todos string).
    */
    header('Content-Type: application/json; charset=utf-8');

    function formatarQuery($conexao,$query,$dados){
        // formata uma query para ser enviada pro DB
        $query = sprintf($query, $conexao->real_escape_string($dados));
        return $query;
    }

    function jaCadastrado($conexao,$procurar){
        // verifica se um usuario está contido no DB
        $sqlQuery = "SELECT * FROM usuario WHERE email='%s'";
        $sqlQuery = formatarQuery($conexao,$sqlQuery,$procurar);
 
        return $conexao->query($sqlQuery)->num_rows > 0;
    }

    function senhaValida($conexao,$emailAtual,$senhaAtual){
        // verifica se uma senha de usuario está no DB
        $sqlQuery = formatarQuery($conexao,"SELECT * FROM usuario WHERE email='%s'",$emailAtual);
        $sqlQuery .= formatarQuery($conexao," AND senha='%s'",$senhaAtual);

        return $conexao->query($sqlQuery)->num_rows > 0;
    }
    
    $response = array(
        'logado'=>true,
        'valido'=>false,
        'emailCadastrado'=>false,
        'novasSenhasDiferentes'=>false,
        'mudarSenhasIguais'=>false,
        'senhaAtualIncorreta'=>false,
        'camposVazios'=>false
    );

    session_start();

    if(empty($_SESSION) || !isset($_SESSION["email"])){ // usuario nao esta logado no sistema
        $response["logado"] = false;
    } else if(!empty($_POST)){
        $trocar = $_POST["trocar"]; // pega os dados que irão ser trocados
        $emailAtual = addslashes($_SESSION["email"]); // pega o email atual logado
        // pega os dados atuais   
        $nome = addslashes($_POST["nome"]);
        $email = addslashes($_POST["email"]);
        $dataNasc = addslashes($_POST["dataNasc"]);
        $senhaAtual = addslashes($_POST["senhaAtual"]);
        $novaSenha = addslashes($_POST["novaSenha"]);
        $novaSenhaRep = addslashes($_POST["novaSenhaRep"]);

        require "conexao.php"; // Conectar ao banco de dados

        if(isset($trocar['novaSenha']) && $novaSenha != $novaSenhaRep){ // checa se as senhas digitadas são iguais
            $response['novasSenhasDiferentes'] = true;
        } else if(isset($trocar['novaSenha']) && $senhaAtual == $novaSenha){ // checa se as senhas digitadas são iguais
            $response['mudarSenhasIguais'] = true;
        } else if(isset($trocar['email']) && jaCadastrado($conexao,$email)){ // verifica se o novo email da edição já está contido no DB
            $response['emailCadastrado'] = true;
        } else if(isset($trocar['senhaAtual']) && !senhaValida($conexao,$emailAtual,$senhaAtual)){ // verifica se digitou a senha certa no campo de senha atual
            $response['senhaAtualIncorreta'] = true;
        } else if(!in_array(true, $trocar)){ // verifica se algum campo de edição foi preenchido
            $response['camposVazios'] = true;
        } else { 
            // realiza a edição 
            $sql = "UPDATE usuario SET ";
            $usuario = array();

            // pega os campos que serão editados
            if(isset($trocar["nome"])){
                $sql .= formatarQuery($conexao,"nome='%s', ",$nome);
                $usuario["nome"] = $nome;
            }
            if(isset($trocar["email"])){
                $sql .= formatarQuery($conexao,"email='%s', ",$email);
                $usuario["email"] = $email;
            }
            if(isset($trocar["dataNasc"])){
                $sql .= formatarQuery($conexao,"dataNasc='%s', ",$dataNasc);
                $usuario["dataNasc"] = $dataNasc;
            }
            if(isset($trocar["senhaAtual"])){
                $sql .= formatarQuery($conexao,"senha='%s', ",$novaSenha);
            }

            $sql = substr($sql,0,-2); // remove os ultimos ', '
            $sql .= formatarQuery($conexao," WHERE email='%s'",$emailAtual); // formata o final da query

            if(isset($trocar["senhaAtual"]))
                $sql .= formatarQuery($conexao," AND senha='%s'",$senhaAtual);

            // Atualiza os dados
            $edicaoResp = mysqli_query($conexao,$sql);

            if(empty($edicaoResp->num_rows)){ // edição efetuada com sucesso
                $response['valido'] = true;
                
                // troca os campos da sessão pelos novos campos editados
                if(isset($trocar["nome"]))
                    $_SESSION["nome"] = $nome;
                if(isset($trocar["email"]))
                    $_SESSION["email"] = $email;
                if(isset($trocar["dataNasc"]))
                    $_SESSION["dataNasc"] = $dataNasc;
            }
        }
        
        mysqli_close($conexao);
    }

    // Envia o json para o JS tratar
    echo json_encode($response);
?>