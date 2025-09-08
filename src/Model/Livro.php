<?php 

class Livro{

    private $id;
    private $titulo;
    private $autor;
    private $pagina;
    private $genero;
    private $editora;
    private $quantidade;
    private $isbn;
    private $anoPublicação;
    private $idUsuario;


    public function __construct(){}

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }
    public function getTitulo(){
        return $this->titulo;
    }

    public function setAutor($autor){
        $this->autor = $autor;        
    }
    public function getAutor(){
        return $this->autor;
    }

    public function setPagina($pagina){
        $this->pagina = $pagina;
    }
    public function getPagina(){
        return $this->pagina;
    }

    public function setGenero($genero){
        $this->genero = $genero;
    }
    public function getGenero(){
        return $this->genero;
    }

    public function setEditora($editora){
        $this->editora = $editora;
    }
    public function getEditora(){
        return $this->editora;
    }

   public function setQuantidade($quantidade){
        $this->quantidade = $quantidade;
   }
   public function getQuantidade(){
        return $this-> quantidade;
   }

    public function setIsbn($isbn){
        $this->isbn = $isbn;
    }
    public function getIsbn(){
        return $this->isbn;
    }

    public function setAnoPublicação($anoPublicação){
        $this->anoPublicação = $anoPublicação;
    }
    public function getAnoPublicação(){
        return $this->anoPublicação;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }


}


?>