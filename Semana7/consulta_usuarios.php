<?php
/*
    Considerando banco de dados pessoas, com as tabelas pessoa (nome,cpf,id)
    e email (email_val,id). 
*/

    $usuarios = array();

    require "conexao.php";
    
    $resp = mysqli_query($conexao,"SELECT nome,cpf,id FROM pessoa");
    if($resp){ // tabela pessoa encontrada com os dados nome,cpf,id
        while($row=$resp->fetch_row()){ // percorre todas as linhas encontradas da tabela pessoa
            array_push($usuarios, array( // adiciona no array de usuarios
                "nome"=>ucwords($row[0]),
                "cpf"=>$row[1],
                "id"=>$row[2]
            ));
        }
    }

    if(count($usuarios) == 0){ // nenhum usuario encontrado no BD
        $usuarios["erro"] = true;
    }

    echo json_encode($usuarios);
?>