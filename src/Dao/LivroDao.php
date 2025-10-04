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
          $livro->setId($linha['id']);
          $livro->setTitulo($linha['titulo']);
          $livro->setAutor($linha['autor']);
          $livro->setGenero($linha['genero']);
          $livro->setPagina($linha['pagina']);
          $livro->setEditora($linha['editora']);
          $livro->setQuantidade($linha['quantidade']);
          $livro->setIdUsuario($linha['id_usuario']);
          $listaLivros[] = $livro;
        }

        return $listaLivros;


      }catch(PDOException $e){
      return "<p> erro ao conectar com o banco de dados $e</p>";
      }
    }
  

    public function livrosUsuario($id){

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

    public function buscarLivro($nome){

      try{
        $sql = "SELECT * FROM livro WHERE titulo = :titulo";
        $conn = ConnectionFactory::getConnection()->prepare($sql);
        $conn ->bindValue(":titulo", $nome);
        $conn ->execute();
        $livroEncontrado = $conn->fetch(PDO::FETCH_ASSOC);

        //se voltar alguma resposta
        if($livroEncontrado){

          $livroRetorno = new Livro();
          $livroRetorno->setTitulo($livroEncontrado['titulo']);
          $livroRetorno->setAutor($livroEncontrado['autor']);
          $livroRetorno->setPagina($livroEncontrado['pagina']);
          $livroRetorno->setGenero($livroEncontrado['genero']);
          $livroRetorno->setEditora($livroEncontrado['editora']);
          $livroRetorno->setQuantidade($livroEncontrado['quantidade']);
          $livroRetorno->setId($livroEncontrado['id']);

          return $livroRetorno;

        }else{
          return 1;
        }


      }catch(PDOException $e){

        return"<p> erro ao conectar com o banco de dados $e</p>";
      }
    
  }

  public function buscaLivroId($id){

     try{
        $sql = "SELECT * FROM livro WHERE id = :id";
        $conn = ConnectionFactory::getConnection()->prepare($sql);
        $conn ->bindValue(":id", $id);
        $conn-> execute();
        $retornoId = $conn->fetch(PDO::FETCH_ASSOC);

        if($retornoId){

          $livroId = new Livro();
          $livroId->setTitulo($retornoId['titulo']);
          $livroId->setAutor($retornoId['autor']);
          $livroId->setPagina($retornoId['pagina']);
          $livroId->setGenero($retornoId['genero']);
          $livroId->setEditora($retornoId['editora']);
          $livroId->setQuantidade($retornoId['quantidade']);
          $livroId->setId($retornoId['id']);

          return $livroId;

        }else{

          return false;
        }

      

      }catch(PDOException $e){
        return "<p> erro ao conectar com o banco de dados $e</p>";
      }
    

  }
  public function emprestar($idLivro,$idUsuario){
    try{
    
       $conn = ConnectionFactory::getConnection();
        $conn->beginTransaction();

        // Verifica se há quantidade disponível
        $sqlCheck = "SELECT quantidade FROM livro WHERE id = :id";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindValue(":id", $idLivro);
        $stmtCheck->execute();
        $quantidade = $stmtCheck->fetchColumn();

        if ($quantidade <= 0) {
            throw new Exception("Este livro não está disponível no momento.");
        }

        // Insere na tabela emprestimo
        $sqlEmprestimo = "INSERT INTO emprestimo (id_usuario, id_livro) VALUES (:usuario, :livro)";
        $stmtEmprestimo = $conn->prepare($sqlEmprestimo);
        $stmtEmprestimo->bindValue(":usuario", $idUsuario);
        $stmtEmprestimo->bindValue(":livro", $idLivro);
        $stmtEmprestimo->execute();

        // Diminui a quantidade do livro
        $sqlUpdate = "UPDATE livro SET quantidade = quantidade - 1 WHERE id = :id";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindValue(":id", $idLivro);
        $stmtUpdate->execute();

        $conn->commit();
        return true;
  

    }catch(PDOException $e){

      return "<p> erro ao conectar com o banco de dados $e</p>";
    }
  }

  }

  

  

?>