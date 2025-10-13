<?php 

 class UsuarioDao{

    public function criar(Usuario $usuario){

       try{
        $sql = "INSERT INTO usuario(nome,sobrenome,email,data_nascimento,senha)
                VALUES (:nome, :sobrenome, :email, :data_nascimento, :senha)";
        $pdo = ConnectionFactory::getConnection();        
        $conn = $pdo->prepare($sql);
        $conn->bindValue(":nome", $usuario->getNome());
        $conn->bindValue(":sobrenome", $usuario->getSobrenome());
        $conn->bindValue(":email", $usuario->getEmail());
        $conn->bindValue(":data_nascimento", $usuario->getDatanascimento());
        $senhaHash = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);//Aplica o hash antes de salvar no banco para a senha não ficar visivel
        $conn->bindValue(":senha", $senhaHash);
       
        $conn->execute();
        return 1;
        

       }catch(PDOException $e){
            echo"<h1>Erro: $e </hi>";
            return null;
       }

    }

    public function logar(Usuario $usuario){

        try{
            //busca somente pelo email no banco de dados, lembrando que o email no banco está como UNICO
            $sql = "SELECT * FROM usuario WHERE email = :email";
            $conn = ConnectionFactory::getConnection()->prepare($sql);           
            $conn ->bindValue(":email" , $usuario->getEmail());           
            $conn->execute();
            $result = $conn->fetch(PDO::FETCH_ASSOC); //busca o usuario com este email cadastrado   

            //se encontrar decodifica a senha e retorna o nome do usuario
            if($result){                
                    
                        return $result;
                        #return "cheguei aqui na dao";
                    
            }       
            return 0;
    

        }catch(PDOException $e){
            echo"<h1>Erro: $e </h1>";
            return 1;
        }

    }

    public function buscaId($id){
         
        try{
            $sql = "SELECT * FROM usuario WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn -> bindValue(":id", $id);
            $conn->execute();
            $usuarioEncontrado = $conn->fetch(PDO::FETCH_ASSOC);

            $valor = array();

            foreach($usuarioEncontrado as $chave => $value){

                $valor[] = $value;
            }

            $usuarioRetorno = new Usuario();

            $usuarioRetorno->setId($valor[0]);
            $usuarioRetorno->setNome($valor[1]);
            $usuarioRetorno->setSobrenome($valor[2]);
            $usuarioRetorno->setEmail($valor[3]);
            
            return $usuarioRetorno;
             
            

         }catch(PDOException $e){

            echo"<h1>Erro: $e </h1> ";
            return 1;
         }
    }
 }
?>