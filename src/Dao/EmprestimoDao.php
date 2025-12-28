<?php
class EmprestimoDao
{

    public function emprestimoConfirm()
    {
        try {
            $sql = "SELECT * FROM emprestimo WHERE ativo = 1 AND devolvido = 0";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->execute();
            $ativo = $conn->fetchAll(PDO::FETCH_ASSOC);
            if ($ativo) {
                $emprestimo = [];
                foreach ($ativo as $linha) {
                    $emprestimoP = $this->emprestimoObj($linha);
                    $emprestimo[] = $emprestimoP;
                }
                return $emprestimo;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao conectar no banco de dados $e</p>";
            return false;
        }
    }

    public function emprestimosPendentes()
    {
        try {
            $sql = "SELECT * FROM emprestimo WHERE devolvido = 0 AND ativo = 0";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->execute();
            $pendente = $conn->fetchAll(PDO::FETCH_ASSOC);
            if ($pendente) {
                $emprestimo = [];
                foreach ($pendente as $linha) {
                    $emprestimoP = $this->emprestimoObj($linha);
                    $emprestimo[] = $emprestimoP;
                }
                return $emprestimo;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao conectar no banco de dados $e</p>";
            return false;
        }
    }

    public function devolver($id, $idLivro)
    {
        try {

            $sql = "UPDATE emprestimo SET ativo = 1, devolvido = 1  WHERE id = :idEmprestimo";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":idEmprestimo", $id);
            $conn->execute();
            if ($conn->rowCount() > 0) {
                #traz de volta o estoque    
                $sqlUpdate = "UPDATE livro SET quantidade = quantidade + 1 WHERE id = :id";
                $connUpdate = ConnectionFactory::getConnection()->prepare($sqlUpdate);
                $connUpdate->bindValue(":id", $idLivro);
                $connUpdate->execute();
                if ($conn->rowCount() > 0) {
                    return  true;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao conectar no banco de dados $e</p>";
            return false;
        }
    }

    #cria o obj para exibir na tabela 
    public function emprestimoObj($linha)
    {
        $idEmprestimo = $linha['id'];
        $data = $linha['data_emprestimo'];
        #transforma em data local
        $dataEmprestimo = date('d/m/Y', strtotime($data));
        #busca o nome do livro
        $idLivro = $linha['id_livro'];
        $livroDao = new LivroDao();
        $livro = $livroDao->buscaLivroId($idLivro);
        $tituloLivro = $livro->getTitulo();
        #busca o nome do usuario
        $idUsuario = $linha['id_usuario'];
        $usuarioDao = new UsuarioDao();
        $usuario = $usuarioDao->buscaId($idUsuario);
        $nomeUsuario = $usuario->getNome();
        $sobrenome = $usuario->getSobrenome();

        #criando o obj emprestimo
        $emprestimoObj = new EmprestimoCNome($idEmprestimo, $idLivro, $idUsuario, $tituloLivro, $nomeUsuario, $sobrenome, $dataEmprestimo, $eP = null, $eA = null);
        return $emprestimoObj;
    }

    #função que confirma o emprestimo de pendente para ativo e diminui a quantidade em estoque
    public function confirmEmprestimo($id, $idLivro)
    {
        try {
            $sql = "UPDATE emprestimo SET ativo = 1 WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", $id);
            $conn->execute();

            if ($conn->rowCount() > 0) {
                $sqlQuant = "UPDATE livro SET quantidade = quantidade-1 WHERE id = :idLivro";
                $connQ = ConnectionFactory::getConnection()->prepare($sqlQuant);
                $connQ->bindValue(":idLivro", $idLivro);
                $connQ->execute();

                if ($connQ->rowCount() > 0) {
                    return true;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "<p class='text-center'>Erro ao conectar no banco de dados $e</p>";
        }
    }

    #função que cancela o imprestimo pendente
    public function cancelEmprestimo($id)
    {
        try {
            $sql = "DELETE emprestimos WHERE id = :idEmprestimo";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":idLivro", $id);
            $conn->execute();
            if ($conn->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return "<p class='text-center'>Erro ao conectar no banco de dados $e</p>";
        }
    }

    public function dadosUser($usuarios)
    {
        $resultadoBusca = [];
        try {
            foreach ($usuarios as $usuario) {
                $nome = $usuario->getNome();
                $sobrenome = $usuario->getSobrenome();
                $id = $usuario->getId();
                #buscar emprestimos desse usuario
                try {
                    #emprestimo pendentes
                    $sql = 'SELECT * FROM emprestimo WHERE id_usuario =:idUsuario AND devolvido = 0 AND ativo = 0';
                    $conn = ConnectionFactory::getConnection()->prepare($sql);
                    $conn->bindValue(":idUsuario", $id);
                    $conn->execute();
                    $res = $conn->fetchAll(PDO::FETCH_ASSOC);

                    if ($res) {
                        $quantPendente = count($res);
                    } else {
                        $quantPendente = 0;
                    }
                } catch (PDOException $e) {
                    return "<p class='text-center'>Erro ao conectar no banco de dados $e</p>";
                }


                try {
                    #emprestimos ativos
                    $sql1 = 'SELECT * FROM emprestimo WHERE id_usuario =:idUsuario AND devolvido = 0 AND ativo = 1';
                    $conn1 = ConnectionFactory::getConnection()->prepare($sql1);
                    $conn1->bindValue(":idUsuario", $id);
                    $conn1->execute();
                    $res1 = $conn1->fetchAll(PDO::FETCH_ASSOC);
                    if ($res1) {
                        $quantAtivos = count($res1);
                    } else {
                        $quantAtivos = 0;
                    }
                } catch (PDOException $e) {
                    return "<p class='text-center'>Erro ao conectar no banco de dados $e</p>";
                }
                $idU = $id;
                $emprestimoObj = new EmprestimoCNome(
                    $id = null,
                    $idLivro = null,
                    $idU,
                    $tituloLivro = null,
                    $nome,
                    $sobrenome,
                    $dataEmprestimo = null,
                    $quantAtivos,
                    $quantPendente
                );
                $resultadoBusca[] = $emprestimoObj;
            }
            if (count($resultadoBusca) > 0) {
                return $resultadoBusca;
            }

            return false;
        } catch (PDOException $e) {
            return "<h4 class='text-center'>Erro ao conectar no banco de dados $e</h4>";
        }
    }


    #função que retorna um array de objeto para ser usado nos detalhes do usuário
    public function detalhesEmprestimo($idUser)
    {

        try {
            $sql = "SELECT * FROM emprestimo WHERE Id_usuario = :idUser";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":idUser", $idUser);
            $conn->execute();
            $result = $conn->fetchAll(PDO::FETCH_ASSOC);
            $detralhesObj = [];
            if ($result > 0) {
                foreach ($result as $linhaEmprestimo) {
                    $emprestimo = new EmprestimoCNome();
                    $emprestimo->setId($linhaEmprestimo['id']);
                    $emprestimo->setPendente($linhaEmprestimo['devolvido']);
                    $emprestimo->setAtivo($linhaEmprestimo['ativo']);
                    $emprestimo->setIdLivro($linhaEmprestimo['id_livro']);

                    #buscar o nome do livro
                    $idLivro = $linhaEmprestimo['id_livro'];
                    $livroD = new LivroDao();
                    $livroObj = $livroD->buscaLivroId($idLivro);
                    $emprestimo->setNomeLivro($livroObj->getTitulo()); #seta o nome do livro
                    $detralhesObj[] = $emprestimo;
                }
                return $detralhesObj;
            }
            return false;
        } catch (PDOException $e) {
            return "<h4 class='text-center'>Erro ao conectar no banco de dados $e</h4>";
        }
    }

    public function quantEmprestimo($id)
    {
        try {
            $sql = "SELECT * FROM emprestimo WHERE id_livro = :id AND ativo=1 AND devolvido=0";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", $id);
            $conn->execute();
            $result = $conn->fetchAll(PDO::FETCH_ASSOC);
            $quantidade = count($result);
            return $quantidade;
        } catch (PDOException $e) {
            return "<h4 class='text-center'>Erro ao conectar no banco de dados $e</h4>";
        }
    }
}
