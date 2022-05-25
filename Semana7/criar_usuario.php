<?php
/* 
Criação de usuários e das tabelas do DB pessoas para testes de remoção no banco de dados.

Primeira execução:
    -> cria a tabela pessoa (nome,cpf,id)
    -> cria a tabela email (email_val,id)
    -> cria 5 usuarios com nome,cpf e 3 emails
Demais execuções:
    -> cria 5 usuarios com nome,cpf e 3 emails
*/

function generateRandomName($length=5) { // gerar um nome aleatorio para uso
    $characters = 'aaaaabcdeeeeeefghiiiijklmnoooooopqrstuuuuuuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength-1)];
    }
    return $randomString;
}

function generateRandomCPF($length=5) { // gera valores para cpf aleatorios
    $cpf = '';
    for($i=1;$i<12;$i++){
        $cpf .= strval(rand(0,9));

        if($i==9)
            $cpf .= "-";
        else if($i%3==0)
            $cpf .= ".";
    }
    return $cpf;
}

require "conexao.php";

if(!(mysqli_query($conexao,"SELECT nome,cpf,id FROM pessoa"))){
    // tabela pessoa nao existente no DB pessoas

    $query = "CREATE TABLE pessoa (
        id INT(4) UNSIGNED NOT NULL,
        nome VARCHAR(40) NOT NULL,
        cpf VARCHAR(14) NOT NULL
    )";

    $resp = mysqli_query($conexao,$query);
    if(!$resp){
        echo "[!] erro na criacao da tabela pessoa";
        exit();
    }
}

if(!(mysqli_query($conexao,"SELECT email_val,id FROM email"))){
    // tabela email nao existente no DB pessoas

    // criar tabela
    $query = "CREATE TABLE email (
        id INT(4) UNSIGNED NOT NULL,
        email_val VARCHAR(60) NOT NULL
    )";

    $resp = mysqli_query($conexao,$query);
    if(!$resp){
        echo "[!] erro na criacao da tabela email";
        exit();
    }
}

// preencher a tabela com valores para ser utilizados na remoção

$respIds = mysqli_query($conexao,"SELECT id from pessoa");
$ids = array();
$novoId = 1;

if($respIds && mysqli_num_rows($respIds)>0){ // algum usuario ja cadastrado
    while($id=$respIds->fetch_row()){ // pegar todos os ids
        array_push($ids,$id[0]);
    }

    $novoId = max($ids)+1; // proximo id para ser inserido
}

$quantUsuarios = 5; // criar 5 novos usuarios

for($i=$novoId; $i <= $novoId+$quantUsuarios; $i++){ // criar 5 usuarios, cada um com 1 nome, 1 cpf e 3 emails
    $nome = generateRandomName();
    $cpf = generateRandomCPF();

    mysqli_query($conexao,"INSERT INTO pessoa SET nome='$nome', cpf='$cpf', id=$i");
    mysqli_query($conexao,"INSERT INTO email SET email_val='$nome@gmail.com', id=$i");
    mysqli_query($conexao,"INSERT INTO email SET email_val='$nome@outlook.com', id=$i");
    mysqli_query($conexao,"INSERT INTO email SET email_val='$nome@yahoo.com.br', id=$i");
}