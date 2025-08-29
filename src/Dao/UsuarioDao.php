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

            $nome= "Claudemir";
            return $nome;

        }catch(PDOException $e){
            echo"<h1>Erro: $e </hi>";
            return 1;
        }

    }
 }
?>