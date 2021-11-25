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

        #não da mais para enviar os arquivos via JSON para upload

        // $this->_nome = $_POST["nome"] ?? null;
        // $this->_sobrenome =  $_POST["sobrenome"] ?? null;
        // $this->_email =  $_POST["email"] ?? null;
        // $this->_celular = $_POST["celular"] ?? null;
        // $this->_fotografia =  $_FILES["fotografia"]["name"] ?? null;

        $this->_conn = $conn;

         //this -> diferenciar atributos do escopo da classe e atributos que servem somente 
         //na função local
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

        $extensao = pathinfo($this->_fotografia, PATHINFO_EXTENSION);
        $novoNomeArquivo = md5(microtime()) . ".$extensao";

        // echo $novoNomeArquivo;exit;

        move_uploaded_file($_FILES["fotografia"]["tmp_name"], "../upload/$novoNomeArquivo");

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1,$this->_nome);
        $stm->bindValue(2,$this->_sobrenome);
        $stm->bindValue(3,$this->_email);
        $stm->bindValue(4,$this->_celular);
        $stm->bindValue(5,$novoNomeArquivo);

        if ($stm->execute()) {
            return "Success";
        } else{
            return "Error";
        }
    }

    public function delete(){

        $sql = "DELETE FROM tbl_pessoa WHERE cod_pessoa = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_codPessoa);

        if ($stmt->execute()) {
            return "Dados excluídos com sucesso!";
        }

    }
    public function update(){

        $sql = "UPDATE tbl_pessoa SET 
        nome = ?,
        sobrenome = ?,
        email = ?,
        celular = ?,
        fotografia = ?
        WHERE cod_pessoa = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_nome);
        $stmt->bindValue(2, $this->_sobrenome);
        $stmt->bindValue(3, $this->_email);
        $stmt->bindValue(4, $this->_celular);
        $stmt->bindValue(5, $this->_fotografia);
        $stmt->bindValue(6, $this->_codPessoa);

        if ($stmt->execute()) {
            return "Dados alterados com sucesso!";
        }

    }

}

?>

