<?php

date_default_timezone_set('America/Fortaleza');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Conexão com o banco de dados
$conn = new mysqli("localhost","root","","system");

//Charset da conexão
$conn->set_charset('utf8mb4');

//No PHP, as informações de uma requisição vêm em variáveis globais, que são vetores no final das contas, $_GET para requisições do tipo GET e $_POST para requisições do tipo POST
//Lendo a variável global GET e obtendo um valor a partir de um índice op do vetor
//a função intval obtém um valor de um inteiro a partir de uma string
$op = intval($_GET['op']);

if($op == 1){

	$select = "Select * from item_descricao";	
	$result = $conn->query($select) or die($conn->error);
	
	//Retornando os items da consulta
	echo json_encode($result->fetch_all(MYSQLI_ASSOC),JSON_UNESCAPED_UNICODE);
}

if($op == 2){
	$now =  date('Y-m-d H:i:s');
	
	//Inserindo informações no banco de dados a partir de campos da requisição POST
	$insert1 = 'insert into item_descricao (nome_item, descricao, hora_criacao) values ("'.$_POST["nome_item"].'","'.utf8_decode($_POST["description"]).'","'.$now.'")';

	$conn->query($insert1) or die($conn->error);

	//Redirecionando para o arquivo de origem
	header("Location: cadastro.php");

}

if($op == 3){
	$insert2 = "Insert into item_descricao values";
}

if($op == 4){
	$insert3 = "Insert into item_descricao values";
}
