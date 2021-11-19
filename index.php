<?php

include('./Connection.php');
include('./model/ModelPessoa.php');

//criar a variável de conexão 
$conn = new Connection();

//PEDE A CONEXÃO PRA CONN 
$modelPessoa = new ModelPessoa($conn->returnConnection());

$dados = $modelPessoa->findAll();

// echo '<pre>';
// var_dump($dados);
// echo '</pre>';

// echo '<pre>';
// var_dump($conn->returnConnection());
// echo '</pre>';

?>