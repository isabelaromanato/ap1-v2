<?php

class Connection {

    //declarando atributos com visibilidade privada
    # _ não é obrigatório
    private $_dbHostname = "127.0.0.1";
    private $_dbName = "cadastro";
    private $_userName = "root";
    private $_dbPassword = "bcd127";
    private $_conn;

    //criar a conexão com bc através do MÉTODO CONSTRUTOR
    public function __construct(){

        try {
            
            //PDO disponível em qualquer lugar
            //faz a conexão, novo objeto PDO, quem é o bc e o nome
            $this->_conn = new PDO("mysql:host=$this->_dbHostname;dbname=$this->_dbName;", 
                                    $this->_userName, 
                                    $this->_dbPassword);

            //setando atributos de configuração
            //se alguma coisa da errado vai p catch 
                                       //o que eu vou fazer , como será feito
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //pegou a exception joga no erro
        } catch (PDOException $erro ) {

                                 //método do PDO exception   
        echo "Connection error: " . $erro->getMessage();
    }
        
    }

    //criar método para devolver a conexão

    public function returnConnection(){

    return $this->_conn;
    
}
}

?>