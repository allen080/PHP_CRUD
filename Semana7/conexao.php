<?php

	$host = "localhost";
	$usu = "root";
	$senha_usu = "";
	$bd = "pessoas";

	$conexao = mysqli_connect($host,$usu,$senha_usu,$bd);
	//Tentamos abrir uma conexão com o banco de dados conforme os parâmetros informados
	//Retorno possível: um objeto que represente uma conexão com o banco ou o valor false

	if (mysqli_connect_errno()) { //Se não houver erro, o código retornado será zero
		echo "Falha em se conectar com o banco de dados<br />" . mysqli_connect_error();
		exit(); //die()
	} 
	
	mysqli_set_charset($conexao, "utf8");
?>