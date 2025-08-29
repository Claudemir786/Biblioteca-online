<?php 

class Usuario{

    private $id;
    private $nome;
    private $sobrenome;
    private $email;
    private $dataNascimento;
    private $senha;
    private $idLivro;

    public function __construct(){}
  
    
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getNome(){
        return $this->nome;
    }

    public function setSobrenome($sobrenome){
        $this->sobrenome = $sobrenome;
    }
    public function getSobrenome(){
        return $this->sobrenome;
    }

    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }

    public function setDataNascimento($dataNascimento){
        $this->dataNascimento = $dataNascimento;
    }
    public function getDatanascimento(){
        return $this->dataNascimento;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getSenha(){
        return $this->senha;
    }

    public function setIdLivro($idLivro){
        $this->idLivro = $idLivro;
    }
    public function getIdLivro(){
        return $this->idLivro;
    }

    public function __toString() {
    return "ID: {$this->id}, " .
           "Nome: {$this->nome}, " .
           "Sobrenome: {$this->sobrenome}, " .
           "Email: {$this->email}, " .
           "Data de Nascimento: {$this->dataNascimento}, " .
           "Senha: {$this->senha}, " .
           "ID do Livro: {$this->idLivro}";
}

}


?>