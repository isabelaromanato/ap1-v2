<?php

#qualquer requisição http vai cair aqui

//configurações de headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

//importando os arquivos
include("../Connection.php");
include("../model/modelPessoa.php");
include("../controler/ControlerPessoa.php");

//abrir a conexão
$conn = new Connection();
$model = new ModelPessoa($conn->returnConnection());
$controler = new ControllerPessoa($model);

$dados = $controler->router();

//saída
echo json_encode(array("status"=>"Sucess", "data"=>$dados))


?>