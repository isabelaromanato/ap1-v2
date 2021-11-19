<?php

class ModelPessoa{

    //precisa de uma conexão
    //atributo de escopo da classe
    private $_conn;

    private $_codPessoa;
    private $_nome;
    private $_sobrenome;
    private $_email;
    private $_celular;
    private $_fotografia;

    //método construtor
    function __construct($conn){

        //permite receber dados json através da requisição
        $json = file_get_contents("php://input");
        $dadosPessoa = json_decode($json);
        
        //recebimento dos dados do postman:
        $this->_codPessoa = $dadosPessoa->cod_pessoa ?? null;
        $this->_nome = $dadosPessoa->nome ?? null;
        $this->_sobrenome = $dadosPessoa->sobrenome ?? null;
        $this->_email = $dadosPessoa->email ?? null;
        $this->_celular = $dadosPessoa->celular ?? null;
        $this->_fotografia = $dadosPessoa->fotografia ?? null;

        $this->_conn = $conn;
    }

    public function findAll(){

        //monta a intrução SQL
        $sql = "SELECT * FROM tbl_pessoa";

        //prepara o processo de execusão de instrução SQL
        $stm = $this->_conn->prepare($sql);
        //executa a instrução SQL
        $stm->execute();

        //devolve os valores da select para serem utilizados
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById(){
                                        //esse dado vai ser preparado
                                            //para um outro momento
        $sql = "SELECT * FROM tbl_pessoa WHERE cod_pessoa = ?";

        $stm = $this->_conn->prepare($sql);
        //criar um atributo para receber cod_pessoa 
         $stm->bindValue(1, $this->_codPessoa);

         $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function create(){

        $sql = "INSERT INTO tbl_pessoa (nome, sobrenome, email, celular, fotografia)
        VALUES (?,?,?,?,?)";

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1,$this->_nome);
        $stm->bindValue(2,$this->_sobrenome);
        $stm->bindValue(3,$this->_email);
        $stm->bindValue(4,$this->_celular);
        $stm->bindValue(5,$this->_fotografia);

        if ($stm->execute()) {
            return "Success";
        } else{
            return "Error";
        }
    }

}

?>

