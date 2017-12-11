<?php

date_default_timezone_set('America/Fortaleza');

$conn = new mysqli("localhost","root","","system");

$op = intval($_POST['op']);

if($op == 1){
	$select = "Select * from item_descricao";	
	echo $select;
}

if($op == 2){
	$insert1 = "Insert into item_descricao values";
}

if($op == 3){
	$insert2 = "Insert into item_descricao values";
}

if($op == 4){
	$insert3 = "Insert into item_descricao values";
}
