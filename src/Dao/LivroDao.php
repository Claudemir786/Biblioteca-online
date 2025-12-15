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
        #primeiro verifica se o usuario possui algum emprestimo
        $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id";
        $conn= ConnectionFactory::getConnection()->prepare($sql);
        $conn->bindValue(":id", $id);
        $conn->execute();
        $emprestimoEncontrado=$conn->fetchall(PDO::FETCH_ASSOC);

        if($emprestimoEncontrado){#encontra o emprestimo       
          $buscarIds = new LivroDao();
         $livros= $buscarIds->lerIdsLivros($emprestimoEncontrado);
         
         return $livros;
          
        } 
          return false;
                   
     
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
        $quantidade = $stmtCheck->fetchColumn();#verifica se foi encontrado colunas no banco

        if ($quantidade <= 0) {
            return false;
        }
        //verifica se este livro ja está emprestado
        

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

  #verifica a quantidade de emprestimos que o usuário possui 
  public function quantidadeEmprestimo($id){

     $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id";
        $conn= ConnectionFactory::getConnection()->prepare($sql);
        $conn->bindValue(":id", $id);
        $conn->execute();
        $emprestimoEncontrado=$conn->fetchAll(PDO::FETCH_ASSOC);
        
        return $emprestimoEncontrado;
  }
  

  public function lerIdsLivros($emprestimos){

    $idsLivros = [];        
        //guarda todos os ids dos livros em um array
        foreach($emprestimos as $line){
            $idsLivros [] = $line['id_livro'];
        }      

        $livrosEncontrados = [];
        //pega cada numero de id e busca no banco
        for($i=0; $i<count($idsLivros); $i++){

          try{

          $sql = "SELECT * FROM livro WHERE id = :id";
          $conn = ConnectionFactory::getConnection()->prepare($sql);
          $conn->bindValue(":id", $idsLivros[$i]);
          $conn->execute();
          $livroRe = $conn->fetch(PDO::FETCH_ASSOC);
          
          if($livroRe){
            $encontroLivro = new Livro();
            $encontroLivro->setId($livroRe['id']);
            $encontroLivro->setTitulo($livroRe['titulo']);
            $encontroLivro->setAutor($livroRe['autor']);
            $encontroLivro->setPagina($livroRe['pagina']);
            $encontroLivro->setGenero($livroRe['genero']);
            $encontroLivro->setEditora($livroRe['editora']);
            $encontroLivro->setIsbn($livroRe['isbn']);
            $encontroLivro->setQuantidade($livroRe['quantidade']);
            $encontroLivro->setAnoPublicação($livroRe['ano_publicacao']);
            $livrosEncontrados[] = $encontroLivro;
          }
        }catch(PDOException $e){

          return "<p> erro ao conectar com o banco de dados $e</p>";
        }

        }

      return $livrosEncontrados;

  }

  }

  

  

?>