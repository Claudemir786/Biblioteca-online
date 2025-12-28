<?php

class LivroDao
{



  public function listar()
  {

    try {

      $sql = "SELECT * FROM livro";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->execute();
      $retorno = $conn->fetchAll(PDO::FETCH_ASSOC);
      $listaLivros = [];

      foreach ($retorno as $linha) {
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
    } catch (PDOException $e) {
      return "<p> erro ao conectar com o banco de dados $e</p>";
    }
  }

  public function livrosUsuario($id, $historico, $statusEmprestimo)
  {
    try {

      if ($historico && !$statusEmprestimo) {
        #historico de devolvidos
        $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id AND devolvido = 1";
      } else {
        if ($statusEmprestimo) {
          #livros emprestimo confimados que não foram devolvidos
          $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id AND devolvido = 0 AND ativo = 1";
        } else {
          #livros pendentes 
          $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id AND devolvido = 0 AND ativo = 0";
        }
      }

      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":id", $id);
      $conn->execute();
      $emprestimoEncontrado = $conn->fetchall(PDO::FETCH_ASSOC);

      if ($emprestimoEncontrado) { #encontra o emprestimo       
        $buscarIds = new LivroDao();
        $livros = $buscarIds->lerIdsLivros($emprestimoEncontrado);

        return $livros;
      }
      return false;
    } catch (PDOException $e) {

      return "<p> erro ao conectar com o banco de dados $e</p>";
    }
  }

  public function lerIdsLivros($emprestimos)
  {

    $idsLivros = [];
    //guarda todos os ids dos livros em um array
    foreach ($emprestimos as $line) {
      $idsLivros[] = $line['id_livro'];
    }

    $livrosEncontrados = [];
    //pega cada numero de id e busca no banco
    for ($i = 0; $i < count($idsLivros); $i++) {

      try {

        $sql = "SELECT * FROM livro WHERE id = :id";
        $conn = ConnectionFactory::getConnection()->prepare($sql);
        $conn->bindValue(":id", $idsLivros[$i]);
        $conn->execute();
        $livroRe = $conn->fetch(PDO::FETCH_ASSOC);

        if ($livroRe) {
          $encontroLivro = new Livro();
          $encontroLivro->setId($livroRe['id']);
          $encontroLivro->setTitulo($livroRe['titulo']);
          $encontroLivro->setAutor($livroRe['autor']);
          $encontroLivro->setPagina($livroRe['pagina']);
          $encontroLivro->setGenero($livroRe['genero']);
          $encontroLivro->setEditora($livroRe['editora']);
          $encontroLivro->setIsbn($livroRe['isbn']);
          $encontroLivro->setQuantidade($livroRe['quantidade']);
          $encontroLivro->setAnoPublicacao($livroRe['ano_publicacao']);
          $livrosEncontrados[] = $encontroLivro;
        }
      } catch (PDOException $e) {

        return "<p> erro ao conectar com o banco de dados $e</p>";
      }
    }

    return $livrosEncontrados;
  }


  public function buscarLivro($nome)
  {

    try {
      $sql = "SELECT * FROM livro WHERE titulo = :titulo";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":titulo", $nome);
      $conn->execute();
      $livroEncontrado = $conn->fetch(PDO::FETCH_ASSOC);

      //se voltar alguma resposta
      if ($livroEncontrado) {

        $livroRetorno = new Livro();
        $livroRetorno->setTitulo($livroEncontrado['titulo']);
        $livroRetorno->setAutor($livroEncontrado['autor']);
        $livroRetorno->setPagina($livroEncontrado['pagina']);
        $livroRetorno->setGenero($livroEncontrado['genero']);
        $livroRetorno->setEditora($livroEncontrado['editora']);
        $livroRetorno->setQuantidade($livroEncontrado['quantidade']);
        $livroRetorno->setId($livroEncontrado['id']);

        return $livroRetorno;
      } else {
        return 1;
      }
    } catch (PDOException $e) {

      return "<p> erro ao conectar com o banco de dados $e</p>";
    }
  }

  public function buscaLivroId($id)
  {

    try {
      $sql = "SELECT * FROM livro WHERE id = :id";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":id", $id);
      $conn->execute();
      $retornoId = $conn->fetch(PDO::FETCH_ASSOC);

      if ($retornoId) {

        $livroId = new Livro();
        $livroId->setTitulo($retornoId['titulo']);
        $livroId->setAutor($retornoId['autor']);
        $livroId->setPagina($retornoId['pagina']);
        $livroId->setGenero($retornoId['genero']);
        $livroId->setEditora($retornoId['editora']);
        $livroId->setQuantidade($retornoId['quantidade']);
        $livroId->setId($retornoId['id']);

        return $livroId;
      } else {

        return false;
      }
    } catch (PDOException $e) {
      return "<p> erro ao conectar com o banco de dados $e</p>";
    }
  }
  public function emprestar($idLivro, $idUsuario)
  {
    try {

      $conn = ConnectionFactory::getConnection();

      $sql = "SELECT quantidade FROM livro WHERE id = :id";
      $stmtCheck = $conn->prepare($sql);
      $stmtCheck->bindValue(":id", $idLivro);
      $stmtCheck->execute();
      $quantidade = $stmtCheck->fetchColumn(); #verifica se foi encontrado colunas no banco

      if ($quantidade <= 0) {
        return 3;
      }
      //verifica se este livro ja está emprestado
      $sqlVerificacao = "SELECT id_usuario, id_livro FROM emprestimo WHERE id_usuario = :usuario AND id_livro = :livro 
        AND devolvido = 0";

      $smtpVerificacao = $conn->prepare($sqlVerificacao);
      $smtpVerificacao->bindValue(":usuario", $idUsuario);
      $smtpVerificacao->bindValue(":livro", $idLivro);
      $smtpVerificacao->execute();
      $emprestimoEncontrado = $smtpVerificacao->fetchColumn();
      if ($emprestimoEncontrado > 0) {
        return 2;
      }

      // Insere na tabela emprestimo
      $sqlEmprestimo = "INSERT INTO emprestimo (id_usuario, id_livro, data_emprestimo, devolvido) 
        VALUES (:usuario, :livro, NOW(), 0)";
      $stmtEmprestimo = $conn->prepare($sqlEmprestimo);
      $stmtEmprestimo->bindValue(":usuario", $idUsuario);
      $stmtEmprestimo->bindValue(":livro", $idLivro);
      $stmtEmprestimo->execute();

      return 1;
    } catch (PDOException $e) {

      return "<p> erro ao conectar com o banco de dados $e</p>";
    }
  }

  #verifica a quantidade de emprestimos que o usuário possui 
  public function quantidadeEmprestimo($id)
  {

    $sql = "SELECT * FROM emprestimo WHERE id_usuario = :id";
    $conn = ConnectionFactory::getConnection()->prepare($sql);
    $conn->bindValue(":id", $id);
    $conn->execute();
    $emprestimoEncontrado = $conn->fetchAll(PDO::FETCH_ASSOC);

    return $emprestimoEncontrado;
  }




  #Atualaiza o estado de emprestimo e estoque quando devolve 
  public function devolver($livro, $usuario)
  {

    try {
      $sql = "UPDATE emprestimo SET devolvido = 1 WHERE id_usuario = :usuario AND id_livro = :livro AND devolvido = 0";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":usuario", $usuario);
      $conn->bindValue(":livro", $livro);
      $conn->execute();

      if ($conn->rowCount() > 0) {

        $sql = "UPDATE livro set quantidade = quantidade+1 WHERE id=:livro";
        $conn = ConnectionFactory::getConnection()->prepare($sql);
        $conn->bindValue(":livro", $livro);
        $conn->execute();
        if ($conn->rowCount() > 0) {
          return  true;
        }
      } else {
        return false;
      }
    } catch (PDOException $e) {
      return "<p> erro ao conectar com o banco de dados $e</p>";
    }
  }
  public function dataEmprestimo($idLivro, $idUsuario)
  {
    try {
      $sql = "SELECT data_emprestimo FROM emprestimo WHERE id_livro = :livro AND id_usuario = :usuario AND devolvido = 1 LIMIT 1";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":livro", $idLivro);
      $conn->bindValue(":usuario", $idUsuario);
      $conn->execute();
      $dataE = $conn->fetch(PDO::FETCH_ASSOC);
      //pega a data          
      $data = $dataE['data_emprestimo'];
      //tranforma em data local
      $dataFormat = date('d/m/Y', strtotime($data));
      return $dataFormat;
    } catch (PDOException $e) {
      echo "<p> erro ao conectar com o banco de dados $e</p>";
      return false;
    }
  }

  public function lerCategoria($categoria)
  {

    function livro($linha)
    {
      $livro = new Livro();
      $livro->setId($linha['id']);
      $livro->setTitulo($linha['titulo']);
      $livro->setAutor($linha['autor']);
      $livro->setGenero($linha['genero']);
      $livro->setPagina($linha['pagina']);
      $livro->setEditora($linha['editora']);
      $livro->setQuantidade($linha['quantidade']);
      return $livro;
    }
    try {
      if ($categoria === 'romance') {

        $sqlRomance = "SELECT * FROM livro WHERE genero = :genero";
        $connRomance = ConnectionFactory::getConnection()->prepare($sqlRomance);
        $connRomance->bindValue(":genero", "Romance");
        $connRomance->execute();
        $livrosRomance = $connRomance->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];

        if ($livrosRomance) {
          foreach ($livrosRomance as $linha) {
            $livroCompleto = livro($linha);
            $lista[] = $livroCompleto;
          }
          return $lista;
        } else {
          return false;
        }
      } else if ($categoria === 'hq') {
        $sqlHq = "SELECT * FROM livro WHERE genero = :genero";
        $connHq = ConnectionFactory::getConnection()->prepare($sqlHq);
        $connHq->bindValue(":genero", "HQ");
        $connHq->execute();
        $livrosHq = $connHq->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        if ($livrosHq) {
          foreach ($livrosHq as $linha) {
            $livroCompleto = livro($linha);
            $lista[] = $livroCompleto;
          }
          return $lista;
        } else {
          return false;
        }
      } else if ($categoria === 'biografia') {
        $sql = "SELECT * FROM livro WHERE genero = :genero";
        $conn = ConnectionFactory::getConnection()->prepare($sql);
        $conn->bindValue(":genero", "Biografia");
        $conn->execute();
        $livros = $conn->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        if ($livros) {
          foreach ($livros as $linha) {
            $livroCompleto = livro($linha);
            $lista[] = $livroCompleto;
          }
          return $lista;
        } else {
          return false;
        }
      }
    } catch (PDOException $e) {
      echo "<p> erro ao conectar com o banco de dados $e</p>";
      return false;
    }
  }

  public function excluir($id)
  {
    try {
      $sql = "DELETE FROM livro WHERE id =:id";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":id", $id);
      $conn->execute();
      if ($conn->rowCount() > 0) {
        return true;
      }
      return false;
    } catch (PDOException $e) {
      return "<h4 class= 'text-center'>Erro ao conectar no banco de dados</h4>";
    }
  }
  public function adicionar($nomeLivro, $quantidade)
  {
    try {
      $sql = "UPDATE livro SET quantidade = :quant + quantidade WHERE titulo = :titulo";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":quant", $quantidade);
      $conn->bindValue(":titulo", $nomeLivro);
      $conn->execute();
      if ($conn->rowCount() > 0) {
        return true;
      }
      return false;
    } catch (PDOException $e) {
      return "<h4 class= 'text-center'>Erro ao conectar no banco de dados $e</h4>";
    }
  }

  public function cadastrar($livroObj)
  {
    try {
      $sql = "INSERT INTO livro(titulo,autor,pagina,genero,editora,isbn,quantidade,ano_publicacao)
      VALUES(:titulo, :autor, :pagina, :genero, :editora, :isbn, :quantidade, :ano_publicacao)";
      $conn = ConnectionFactory::getConnection()->prepare($sql);
      $conn->bindValue(":titulo", $livroObj->getTitulo());
      $conn->bindValue(":autor", $livroObj->getAutor());
      $conn->bindValue(":pagina", $livroObj->getPagina());
      $conn->bindValue(":genero", $livroObj->getGenero());
      $conn->bindValue(":editora", $livroObj->getEditora());
      $conn->bindValue(":isbn", $livroObj->getIsbn());
      $conn->bindValue(":quantidade", $livroObj->getQuantidade());
      $conn->bindValue(":ano_publicacao", $livroObj->getAnoPublicacao());
      $conn->execute();
      if ($conn->rowCount() > 0) {
        return true;
      }
      return false;
    } catch (PDOException $e) {
      return "<h4 class= 'text-center'>Erro ao conectar no banco de dados $e</h4>";
    }
  }
}
