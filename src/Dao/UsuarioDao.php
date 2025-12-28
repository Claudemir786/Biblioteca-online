<?php

class UsuarioDao
{

    public function criar(Usuario $usuario)
    {

        try {
            $sql = "INSERT INTO usuario(nome,sobrenome,email,data_nascimento,senha)
                VALUES (:nome, :sobrenome, :email, :data_nascimento, :senha)";
            $pdo = ConnectionFactory::getConnection();
            $conn = $pdo->prepare($sql);
            $conn->bindValue(":nome", $usuario->getNome());
            $conn->bindValue(":sobrenome", $usuario->getSobrenome());
            $conn->bindValue(":email", $usuario->getEmail());
            $conn->bindValue(":data_nascimento", $usuario->getDatanascimento());
            $senhaHash = password_hash($usuario->getSenha(), PASSWORD_DEFAULT); //Aplica o hash antes de salvar no banco para a senha não ficar visivel
            $conn->bindValue(":senha", $senhaHash);

            $conn->execute();
            return 1;
        } catch (PDOException $e) {
            echo "<h1>Erro: $e </hi>";
            return null;
        }
    }

    public function logar(Usuario $usuario)
    {

        try {
            //busca somente pelo email no banco de dados, lembrando que o email no banco está como UNICO
            $sql = "SELECT * FROM usuario WHERE email = :email AND ativo = 1";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":email", $usuario->getEmail());
            $conn->execute();
            $result = $conn->fetch(PDO::FETCH_ASSOC); //busca o usuario com este email cadastrado   

            //se encontrar decodifica a senha e retorna o nome do usuario
            if ($result) {

                return $result;
            }
            return 0;
        } catch (PDOException $e) {
            echo "Erro ao conectar no banco de dados: $e";
            return 1;
        }
    }

    public function loginAdm($adm)
    {
        try {
            #como eu ja sei a senha de adm eu verifico se é a mesma
            if ($adm->getSenha() === 'admin@') {

                $sql = "SELECT * FROM usuario WHERE email = :email";
                $conn = ConnectionFactory::getConnection()->prepare($sql);
                $conn->bindValue(":email", $adm->getEmail());
                $conn->execute();
                $result = $conn->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    return true;
                }
            }

            return false;
        } catch (PDOException $e) {
            return "<h4 class= 'text-center'>Erro ao conectar no banco de dados $e</h4>";
        }
    }

    public function buscaId($id)
    {

        try {
            $sql = "SELECT * FROM usuario WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", $id);
            $conn->execute();
            $usuarioEncontrado = $conn->fetch(PDO::FETCH_ASSOC);

            $valor = array();

            foreach ($usuarioEncontrado as $chave => $value) {

                $valor[] = $value;
            }

            $usuarioRetorno = new Usuario();

            $usuarioRetorno->setId($valor[0]);
            $usuarioRetorno->setNome($valor[1]);
            $usuarioRetorno->setSobrenome($valor[2]);
            $usuarioRetorno->setEmail($valor[3]);

            return $usuarioRetorno;
        } catch (PDOException $e) {

            echo "Erro ao conectar no banco de dados: $e";
            return 1;
        }
    }
    public function delete($id)
    {

        try {
            $sql = "UPDATE usuario SET ativo = 0 WHERE id = :idUsuario";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":idUsuario", $id);
            $conn->execute();

            if ($conn->rowCount() > 0) {
                return 1;
            } else {
                return 2;
            }
        } catch (PDOException $e) {

            echo "Erro ao conectar no banco de dados: $e";
            return 3;
        }
    }

    public function alteraNome($id, $nome, $sobrenome)
    {

        try {

            $sql = "UPDATE usuario SET nome = :nomeUser, sobrenome = :sobrenomeUser WHERE id = :idUser";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":idUser", $id);
            $conn->bindValue(":nomeUser", $nome);
            $conn->bindValue(":sobrenomeUser", $sobrenome);
            $conn->execute();
            if ($conn->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro ao conectar no banco de dados: $e";
            return false;
        }
    }
    public function alteraEmail($id, $email)
    {

        try {
            $sql = "UPDATE usuario SET email = :email WHERE id = :id";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":id", $id);
            $conn->bindValue(":email", $email);
            $conn->execute();

            if ($conn->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro ao conectar no banco de dados: $e";
            return false;
        }
    }

    public function buscarUsuario($nome)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE nome =:nome";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":nome", $nome);
            $conn->execute();
            $res = $conn->fetchAll(PDO::FETCH_ASSOC);

            if ($res) {
                $usuarios = [];
                foreach ($res as $linha) {
                    $usuario = new Usuario();
                    $usuario->setId($linha['id']);
                    $usuario->setNome($linha['nome']);
                    $usuario->setSobrenome($linha['sobrenome']);

                    $usuarios[] = $usuario;
                }
                return $usuarios;
            }
            return false;
        } catch (PDOException $e) {
            echo "Erro ao conectar no banco de dados: $e";
            return false;
        }
    }
}
