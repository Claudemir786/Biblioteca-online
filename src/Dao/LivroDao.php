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
         
          $listaLivros[] = $livro;
        }

        return $listaLivros;


      }catch(PDOException $e){
      return "<p> erro ao conectar com o banco de dados $e</p>";
      }
    }
  
    public function livrosUsuario($id){

      try{
        $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id";
        $conn= ConnectionFactory::getConnection()->prepare($sql);
        $conn->bindValue(":id", $id);
        $conn->execute();
        $emprestimoEncontrado=$conn->fetchall(PDO::FETCH_ASSOC);

        if($emprestimoEncontrado){   

          return $emprestimoEncontrado;
          //fazer o retorno correto de todos os livros, primeiro pegue o id de todos e depois
          //pesquisar um por um em cada id de livro
          foreach($emprestimoEncontrado as $line){
              
          }
          
        } 


















                   
         /* $idLivro1 =($emprestimoEncontrado['id_livro']);
          $sql2 = "SELECT * FROM livro WHERE id = :id";
          $conn2= ConnectionFactory::getConnection()->prepare($sql2);
          $conn2->bindValue(":id", $idLivro1);
          $conn2->execute();
          $livroE=$conn2->fetch(PDO::FETCH_ASSOC);

          if($livroE){

            $livro1 = new Livro();
            $livro1->setTitulo($livroE['titulo']);
            $livro1->setAutor($livroE['autor']);
            $livro1->setPagina($livroE['pagina']);
            $livro1->setGenero($livroE['genero']);
            $livro1->setEditora($livroE['editora']);
            $livro1->setIsbn($livroE['isbn']);       
      
            return$livro1;
          
          }else{
            return false;
          }

        }else{
          return false;
        }*/

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
        $sql = "SELECT quantidade FROM livro WHERE id = :id";
        $stmtCheck = $conn->prepare($sql);
        $stmtCheck->bindValue(":id", $idLivro);
        $stmtCheck->execute();
        $quantidade = $stmtCheck->fetchColumn();

        if ($quantidade <= 0) {
            return false;
        }

        // Insere na tabela emprestimo
        $sqlEmprestimo = "INSERT INTO emprestimo (id_usuario, id_livro, data_emprestimo, devolvido) 
        VALUES (:usuario, :livro, NOW(), 0)";
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

  public function quantidadeEmprestimo($id){

     $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id";
        $conn= ConnectionFactory::getConnection()->prepare($sql);
        $conn->bindValue(":id", $id);
        $conn->execute();
        $emprestimoEncontrado=$conn->fetchAll(PDO::FETCH_ASSOC);
        
        return $emprestimoEncontrado;
  }

  }

  

  

?>