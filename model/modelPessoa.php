<?php

class ModelPessoa{

    //precisa de uma conexão
    //atributo de escopo da classe
    private $_conn;

    //método construtor
    function __construct($conn){

        $this->_conn = $conn;
    }

    public function findAll(){

        //monta a intrução SQL
        $sql = "SELECT * FROM tbl_pessoa";

        //prepara o processo de execusão de instrução SQL
        $stn = $this->_conn->prepare($sql);
        //executa a instrução SQL
        $stn->execute();

        //devolve os valores da select para serem utilizados
        return $stn->fetchAll(\PDO::FETCH_ASSOC);
    }

}

?>