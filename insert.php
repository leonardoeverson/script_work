<?php

date_default_timezone_set('America/Fortaleza');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Conexão com o banco de dados
$conn = new mysqli("cbsede.dyndns.org:20000","db","admindb#","system");
//$conn = new mysqli("localhost","db","admindb#","system");

//Charset da conexão
$conn->set_charset('utf8mb4');

//No PHP, as informações de uma requisição vêm em variáveis globais, que são vetores no final das contas, $_GET para requisições do tipo GET e $_POST para requisições do tipo POST
//Lendo a variável global GET e obtendo um valor a partir de um índice op do vetor
//a função intval obtém um valor de um inteiro a partir de uma string
$op = intval($_GET['op']);

if($op == 1){

	$select = "SELECT *,TIMEDIFF(NOW(), ADDTIME(hora_criacao, tempo_duracao)) AS timer FROM item_descricao WHERE NOW() BETWEEN hora_criacao AND ADDTIME(hora_criacao, tempo_duracao) limit 1 ";

	$result = $conn->query($select) or die($conn->error);
	
	//Retornando os items da consulta
	echo json_encode($result->fetch_all(MYSQLI_ASSOC),JSON_UNESCAPED_UNICODE);
}

if($op == 2){
	//O horário no momento do cadastro de item para um novo sorteio
	$now =  date('Y-m-d H:i:s');

	//Captura da quantidade de tempo que o cadastrante configurou
	$time = $_POST['time'];

	//Busca e substituição das letra h e m
	$time = str_replace(array('h','m'), '', $time);
	
	//Adição de 00 na string de tempo
	$time = $time.':00';

	//busca para saber quando o último sorteio cadastrado termina
	$tempo_result = $conn->query("SELECT addtime(hora_criacao,tempo_duracao) as tempo FROM item_descricao ORDER BY id DESC LIMIT 1");
	$tempo_criacao = $tempo_result->fetch_assoc();
	
	//Compara para saber o momento do cadastro está entre o periodo em que algum sorteio está ativo
	if(strtotime($now) < strtotime($tempo_criacao['tempo'])){
		$now = $tempo_criacao['tempo'];		
	}else{
		$now =  date('Y-m-d H:i:s');
	}

	//die();

	//Inserindo informações no banco de dados a partir de campos da requisição POST
	$insert1 = 'insert into item_descricao (nome_item, descricao, hora_criacao,tempo_duracao) values ("'.$_POST["nome_item"].'","'.$_POST["description"].'","'.$now.'","'.$time.'")';

	//
	$conn->query($insert1) or die($conn->error);

	//Redirecionando para o arquivo de origem
	header("Location: cadastro.php");

}

if($op == 3){
	//Inserindo informações dos lances no banco de dados
	$insert2 = 'Insert into lance_usuario (item_id, lance_valor, nome_usuario) values('.$_POST['id'].','.$_POST['valor_lance'].',"'.$_POST['nome'].'")';

	//Em caso de falha
	$conn->query($insert2) or die(json_encode(array('mensagem' => '2','msg_text'=> $conn->error),JSON_UNESCAPED_UNICODE));

	//Em caso de sucesso
	echo json_encode(array('mensagem' => '1','msg_text' =>'Inserção feita com sucesso!'),JSON_UNESCAPED_UNICODE);
}

if($op == 4){
	//Seleção de lances e checagem para saber se existem lances de mesmo valor
	$select2 = "SELECT min(lance_valor) as lance, nome_usuario, item_id, nome_item FROM lance_usuario as c, item_descricao WHERE NOT EXISTS(SELECT * FROM lance_usuario AS a WHERE a.lance_valor = c.lance_valor and a.item_id = c.item_id and a.nome_usuario != c.nome_usuario) AND c.item_id = item_descricao.id AND NOW() > ADDTIME(item_descricao.hora_criacao,item_descricao.tempo_duracao) group by(c.item_id)";

	//Executa o select e em caso de erro retorna para o usuário
	$result = $conn->query($select2) or die(json_encode(array('mensagem' => '2','msg_text'=> $conn->error),JSON_UNESCAPED_UNICODE));

	echo json_encode($result->fetch_all(MYSQLI_ASSOC),JSON_UNESCAPED_UNICODE);
}
