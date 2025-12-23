<?php 
    class EmprestimoDao{

        public function emprestimoConfirm(){
            try{
                $sql = "SELECT * FROM emprestimo WHERE ativo = 1 AND devolvido = 0";
                $conn = ConnectionFactory::getConnection()->prepare($sql);
                $conn->execute();
                $ativo = $conn->fetchAll(PDO::FETCH_ASSOC);
                if($ativo){
                    $emprestimo = [];                    
                   foreach($ativo as $linha){
                        $emprestimoP = $this->emprestimoObj($linha);
                        $emprestimo []= $emprestimoP; 
                   }
                   return $emprestimo;

                }else{
                    return false;
                }

            }catch(PDOException $e){
                echo"<p>Erro ao conectar no banco de dados $e</p>";
                return false;
            }
        }

        public function emprestimosPendentes(){
            try{
                $sql="SELECT * FROM emprestimo WHERE devolvido = 0 AND ativo = 0";
                $conn = ConnectionFactory::getConnection()->prepare($sql);
                $conn->execute();
                $pendente = $conn->fetchAll(PDO::FETCH_ASSOC);
                if($pendente){
                    $emprestimo = [];
                    foreach($pendente as $linha){
                        $emprestimoP = $this->emprestimoObj($linha);
                        $emprestimo []= $emprestimoP; 
                    }
                    return $emprestimo;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                echo"<p>Erro ao conectar no banco de dados $e</p>";
                return false;
            }
        }
        
        public function devolver($id,$idLivro){
            try{

               $sql="UPDATE emprestimo SET ativo = 1, devolvido = 1  WHERE id = :idEmprestimo";
               $conn = ConnectionFactory::getConnection()->prepare($sql);
               $conn->bindValue(":idEmprestimo", $id);
               $conn->execute();               
                if($conn->rowCount() > 0){
                    #traz de volta o estoque    
                    $sqlUpdate = "UPDATE livro SET quantidade = quantidade + 1 WHERE id = :id";
                    $connUpdate = ConnectionFactory::getConnection()->prepare($sqlUpdate);
                    $connUpdate->bindValue(":id", $idLivro);
                    $connUpdate->execute();
                    if($conn->rowCount() > 0){
                        return  true;
                    }        
                   
                }else{
                    return false;
                }          

            }catch(PDOException $e){
                echo"<p>Erro ao conectar no banco de dados $e</p>";
                return false;
            }
        }

        #cria o obj para exibir na tabela 
        public function emprestimoObj($linha){
             $idEmprestimo = $linha['id'];                                       
            $data = $linha['data_emprestimo'];
            #transforma em data local
            $dataEmprestimo= date('d/m/Y', strtotime($data));
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
            $sobrenome =$usuario->getSobrenome();
            
            #criando o obj emprestimo
            $emprestimoObj = new EmprestimoCNome($idEmprestimo,$idLivro,$idUsuario,$tituloLivro,$nomeUsuario,$sobrenome,$dataEmprestimo);
            return $emprestimoObj;
        }

        #função que confirma o emprestimo de pendente para ativo e diminui a quantidade em estoque
        public function confirmEmprestimo($id, $idLivro){
            try{
                $sql = "UPDATE emprestimo SET ativo = 1 WHERE id = :id";
                $conn = ConnectionFactory::getConnection()->prepare($sql);
                $conn->bindValue(":id", $id);
                $conn->execute();

                if($conn->rowCount() >0){
                    $sqlQuant = "UPDATE livro SET quantidade = quantidade-1 WHERE id = :idLivro";
                    $connQ = ConnectionFactory::getConnection()->prepare($sqlQuant);
                    $connQ->bindValue(":idLivro", $idLivro);
                    $connQ->execute();
                    
                    if($connQ->rowCount() >0){
                        return true;
                    }                    
                }else{
                    return false;
                }

            }catch(PDOException $e){
                return "<p>Erro ao conectar no banco de dados $e</p>";
            }
        }

        #função que cancela o imprestimo pendente
        public function cancelEmprestimo($id){
             try{

            }catch(PDOException $e){
                return "<p>Erro ao conectar no banco de dados $e</p>";
            }
        }
    }



?>