<?php

    class EmprestimoCNome{
        private $id;
        private $idLivro;
        private $idUsuario;
        private $nomeLivro;
        private $nomeUsuario;
        private $sobrenome;
        private $data;
        private $emprestimoAtivo;
        private $emprestimoPendente;

        public function __construct( $id = null,$idLivro = null,$idUsuario = null,$nomeLivro = null,$nomeUsuario = null,$sobrenome = null,$data = null,$emprestimoAtivo =null, $emprestimoPendente= null){
            $this->id = $id;
            $this->idLivro = $idLivro;
            $this->idUsuario = $idUsuario;
            $this->nomeLivro = $nomeLivro;
            $this->nomeUsuario = $nomeUsuario;
            $this->sobrenome = $sobrenome;
            $this->data = $data;
            $this->emprestimoAtivo=$emprestimoAtivo;
            $this->emprestimoPendente=$emprestimoPendente;
        }
        public function getId() {
        return $this->id;
        }

        public function getIdLivro() {
            return $this->idLivro;
        }

        public function getIdUsuario() {
            return $this->idUsuario;
        }

        public function getNomeLivro() {
            return $this->nomeLivro;
        }

        public function getNomeUsuario() {
            return $this->nomeUsuario;
        }

        public function getData() {
            return $this->data;
        }

        public function getSobrenome(){
            return $this->sobrenome;
        }
        public function getPendente(){
            return $this->emprestimoPendente;
        }
        public function getAtivo(){
            return $this->emprestimoAtivo;
        }
        

        public function setPendente($pendente){
            $this->emprestimoPendente = $pendente;
        }
        public function setAtivo($ativo){
            $this->emprestimoAtivo = $ativo;
        }
        public function setSobrenome($sobrenome){
            $this->sobrenome = $sobrenome;
        }
        
        public function setId($id) {
            $this->id = $id;
        }

        public function setIdLivro($idLivro) {
            $this->idLivro = $idLivro;
        }

        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }

        public function setNomeLivro($nomeLivro) {
            $this->nomeLivro = $nomeLivro;
        }

        public function setNomeUsuario($nomeUsuario) {
            $this->nomeUsuario = $nomeUsuario;
        }

        public function setData($data) {
            $this->data = $data;
        } 

    }

?>