<?php 

class Usuario{
    private $nome;
    private $sobrenome;
    private $email;
    private $dataNascimento;
    private $senha;

    public function __construct()
    {
        
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
    public function geEmail(){
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
}


?>