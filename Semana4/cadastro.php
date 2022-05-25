<?php
    /*
        Considerar Banco de Dados "ifsp" com a tabela "usuario" 
        e os campos nome, cpf, dataNasc, email e senha criados (todos string).
    */
    function formatarQuery($conexao,$query,$dados){
        // formata uma query para ser enviada pro DB
        $query = sprintf($query, $conexao->real_escape_string($dados));
        return $query;
    }

    header('Content-Type: application/json; charset=utf-8');

    $response = array(
        'valido'=>false,
        'jaCadastrado'=>false,
        'cpfInvalido'=>false,
        'senhasDiferentes'=>false
    );

    if(!empty($_POST)) {
        $nome = addslashes($_POST["nome"]);
        $email = addslashes($_POST["email"]);
        $dataNasc = addslashes($_POST["dataNasc"]);
        $cpf = addslashes($_POST["cpf"]);
        $senha = addslashes($_POST["senha"]);
        $senhaRep = addslashes($_POST["senha_rep"]);

        require "verificarCPF.php";

        if(!validarCPF($cpf)){ // checa se o CPF é válido
            $response['cpfInvalido'] = true;
        } else if($senha != $senhaRep){ // checa se as senhas digitadas são iguais
            $response['senhasDiferentes'] = true;
        } else if(!empty(trim($nome)) && !empty(trim($email)) && !empty(trim($cpf)) && !empty(trim($senha))) {
            require "conexao.php";

            $sql = formatarQuery($conexao,"SELECT email, nome FROM usuario WHERE cpf='%s'",$cpf);
            $sql .= formatarQuery($conexao,"OR email='%s'",$email);
            $resultado = $conexao->query($sql);

            if($resultado->num_rows > 0){ // usuario já cadastrado
                $response['jaCadastrado'] = true;
            } else { // cadastrar usuário
                $cadastroResp = mysqli_query($conexao, "INSERT INTO usuario (nome, email, dataNasc, cpf, senha) VALUES ('$nome','$email','$dataNasc','$cpf','$senha');");               
                
                if(empty($cadastroResp->num_rows)){
                    $response['valido'] = true;
                }
            }

            mysqli_free_result($resultado);
            mysqli_close($conexao);
        }
    }

    // Envia o json para o JS tratar
    echo json_encode($response);
?>