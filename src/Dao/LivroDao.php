<?php 
  
  class LivroDao{

    public function listar(){

      try{

        $sql = "SELECT * FROM livro";
        $conn = ConnectionFactory::getConnection()->prepare($sql);
        $conn ->execute();
        $retorno = $conn->fetchAll(PDO::FETCH_ASSOC);
        $listaLivros = [];

        foreach($retorno as $linha){
          $livro = new Livro();
          $livro->setTitulo($linha['titulo']);
          $livro->setAutor($linha['autor']);
          $livro->setGenero($linha['genero']);
          $livro->setPagina($linha['pagina']);
          $livro->setEditora($linha['editora']);
          $livro->setQuantidade($linha['quantidade']);
          $listaLivros[] = $livro;
        }

        return $listaLivros;


      }catch(PDOException $e){
      return "<p> erro ao conectar com o banco de dados $e</p>";
      }
    }
  

    public function livrosUsuairo($id){

      try{
        $sql = "SELECT * FROM livro WHERE id_usuario = :id_usuario";
        $conn = ConnectionFactory::getConnection()->prepare($sql);
        $conn ->bindValue(":id_usuario", $id);
        $conn-> execute();
        $retornoId = $conn->fetchAll(PDO::FETCH_ASSOC);

        $livros = [];

        foreach($retornoId as $linha){
          $livroU = new Livro();
          $livroU->setTitulo($linha['titulo']);
          $livroU->setAutor($linha['autor']);
          $livroU->setGenero($linha['genero']);
          $livroU->setPagina($linha['pagina']);
          $livroU->setEditora($linha['editora']);
          $livros[] =$livroU; 
        }

      return $livros;


      

      }catch(PDOException $e){
        return "<p> erro ao conectar com o banco de dados $e</p>";
      }
    }
  }

  

?>