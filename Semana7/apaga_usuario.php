<?php
    function formatarQuery($conexao,$query,$dados){
        // formatar a query para ser deletada no DB
        $query = sprintf($query, $conexao->real_escape_string($dados));
        return $query;
    }

    header('Content-Type: application/json; charset=utf-8');
    
    $response = array(
        "sucesso"=>false
    );

    if(!empty($_POST)){
        $id = addslashes($_POST["id"]);

        require "conexao.php";

        $query = formatarQuery($conexao,"DELETE FROM email WHERE id='%s'",$id);
        $resp = mysqli_query($conexao,$query);

        if($resp){
            $query = formatarQuery($conexao,"DELETE FROM pessoa WHERE id='%s'",$id);
            $resp2 = mysqli_query($conexao,$query);

            if($resp2){
                $response["sucesso"] = true; // pessoa deletada do DB
            }
        }
    }

    echo json_encode($response);
?>