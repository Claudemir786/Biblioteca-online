<?php

require_once __DIR__ . '/../Model/Livro.php';

require_once __DIR__ . '/../Model/Usuario.php';
require_once __DIR__ . '/../Dao/ConnectionFactory.php';
require_once __DIR__ . '/../Dao/UsuarioDao.php';
require_once __DIR__ . '/../Dao/LivroDao.php';

#----------------FUNÇÕES--------------------------------------------------------------------------------------------------------------
#imagem de erro ao encontrar livro
function livroNaoencontrado()
{
    echo "<div style='
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            '>
                <img 
                    src='../View/img/LivroNãoEncontrado.png'
                    alt='Livro não encontrado'
                    style='max-width: 500px; width: 100%;'
                >
            </div>
           ";
}

#função que lista todos os livros na página inicial 
function listarLivros($select)
{

    if ($select) { #executa o campo de select
        $livroE = new Livro();
        $livroListaDao = new LivroDao();

        $livroLista = $livroListaDao->listar(); #chama o método listar na DAO

        foreach ($livroLista as $livroE) {
            echo "
                    <option value'{$livroE->getId()}'>{$livroE->getTitulo()}</option>
                ";
        }
    } else {
        $livroE = new Livro();
        $livroListaDao = new LivroDao();

        $livroLista = $livroListaDao->listar(); #chama o método listar na DAO

        foreach ($livroLista as $livroE) {

            echo "
                        <div class='card text-center mb-4 ms-4 border-shadow-lg' style='width: 18rem;'>
                            
                            <div class='card-body'>
                                <h5 class='card-title'>{$livroE->getTitulo()}</h5>
                                
                            </div>
                            <ul class='list-group list-group-flush'>
                                <li class='list-group-item'>Autor: {$livroE->getAutor()}</li>
                                <li class='list-group-item'>Gênero: {$livroE->getGenero()}</li>
                                <li class='list-group-item'>{$livroE->getEditora()}</li>
                            </ul>
                           
                            <form action='../Controller/LivroController.php' method='get'> 
                                <input type='hidden' value='{$livroE->getId()}' name='idLivro' />                           
                                
                                <button type='submit' class='btn btn-info' name='emprestar' > Emprestar</button>
                            </form> 
                            
                            
                            
                            </div>
                    ";
        }
    }
}

#encontra o livro via id do usuário
function livroUsuario($id)
{

    $livroUsuario = new Livro();
    $livroUsuarioDao = new LivroDao();
     #------------------econtra depois os emprestimos pendentes----------------------
        $livroUsuario1 = $livroUsuarioDao->livrosUsuario($id,false,false);
        
        if ($livroUsuario1 != false) {

            foreach ($livroUsuario1 as $livro) {
                echo "
                <div class='card text-center mb-4 ms-5 border-shadow' style='width: 18rem;'>
                    
                    <div class='card-body'>
                        <h5 class='card-title'>{$livro->getTitulo()}</h5>
                        
                    </div>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'>Autor: {$livro->getAutor()}</li>
                        <li class='list-group-item'>Gênero: {$livro->getGenero()}</li>
                        <li class='list-group-item'>{$livro->getEditora()}</li>
                        <li class='list-group-item'  style='background-color: #4e0202ff; color: #fff;'>Empréstimo pendente</li>
                        
                    </ul>
                    <form action='../Controller/LivroController.php' method='get'> 
                        <input type='hidden' value='{$livro->getId()}' name='idLivro' />
                        
                    </form>                            
                        
     
                    </div>
                ";
            }
        } 
    #------------------econtra os emprestimo validos----------------------
    $livroUsuario = $livroUsuarioDao->livrosUsuario($id,false,true);
    
    if ($livroUsuario != false) {

        foreach ($livroUsuario as $livro) {
            echo "
                <div class='card text-center mb-4 ms-5 border-shadow-lg' style='width: 18rem;'>
                    
                    <div class='card-body'>
                        <h5 class='card-title'>{$livro->getTitulo()}</h5>
                        
                    </div>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'>Autor: {$livro->getAutor()}</li>
                        <li class='list-group-item'>Gênero: {$livro->getGenero()}</li>
                        <li class='list-group-item'>{$livro->getEditora()}</li>
                        <li class='list-group-item' style='background-color: #06355e; color: #fff;'>Empréstimo válido</li>
                    </ul>
                    <form action='../Controller/LivroController.php' method='get'> 
                        <input type='hidden' value='{$livro->getId()}' name='idLivro' />
                        
                    </form>                               
                        
                    
                    
                    
                    </div>
                ";
        }

       
    }
}
#função que está vinculada ao campo livre de "buscar" na tela inicial, serve prar mostrar o livro com o nome procurado
function livroId($id)
{

    $livro1Dao = new LivroDao();

    $livroRetorno = $livro1Dao->buscaLivroId($id);

    if ($livroRetorno == false) {

        livroNaoencontrado();
    } else {
        #card que mostra o livro encontrado por meio do Id
        echo "
                <div class='card text-center mb-4 mt-5 ms-5 border-shadow' style='width: 18rem;'>
                    
                    <div class='card-body'>
                        <h5 class='card-title'>{$livroRetorno->getTitulo()}</h5>
                        
                    </div>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'>Autor: {$livroRetorno->getAutor()}</li>
                        <li class='list-group-item'>Gênero: {$livroRetorno->getGenero()}</li>
                        <li class='list-group-item'>{$livroRetorno->getEditora()}</li>
                    </ul>
                     <form action='../Controller/LivroController.php' method='get'> 
                            <input type='hidden' value='{$livroRetorno->getId()}' name='idLivro' />                           
                             
                            <button type='submit' class='btn btn-info' name='emprestar' >Emprestar</button>
                        </form>              
                  
                    
                    </div>
                ";
    }
}


function lerHistorico()
{
    $historicoLivro = new LivroDao();

    $id = $_SESSION['cod'];
    $historico = $historicoLivro->livrosUsuario($id, true, false);
    if ($historico != false) {

        foreach ($historico as $livro) {
            $dataEmprestimo = $historicoLivro->dataEmprestimo($livro->getId(), $id);


            echo "<tr>
                <td>{$livro->getTitulo()}</td>
                <td>{$livro->getAutor()}</td>
                <td>{$livro->getGenero()}</td>                                          
                <td>{$dataEmprestimo}</td>
            </tr>
           ";
        }
    } else {
       echo"não foram encontrados livros";
    }
}

function livroCategoria($categoria)
{
    $categoriaDao = new LivroDao();
    $lista = $categoriaDao->lerCategoria($categoria);

    if ($lista == false) {
        livroNaoencontrado();
    } else {
        foreach ($lista as $linha) {
            echo "<div class='card text-center mb-4 ms-4 border-shadow' style='width: 18rem;'>                            
                            <div class='card-body'>
                                <h5 class='card-title'>{$linha->getTitulo()}</h5>                                
                            </div>
                            <ul class='list-group list-group-flush'>
                                <li class='list-group-item'>Autor: {$linha->getAutor()}</li>
                                <li class='list-group-item'>Gênero: {$linha->getGenero()}</li>
                                <li class='list-group-item'>{$linha->getEditora()}</li>
                            </ul>                           
                            <form action='../Controller/LivroController.php' method='get'> 
                                <input type='hidden' value='{$linha->getId()}' name='idLivro' />                         
                                
                                <button type='submit' class='btn btn-info' name='emprestar' > Emprestar</button>
                            </form>                           
                            </div>";
        }
    }
}

function excluir($id)
{
    $livroDao = new LivroDao();
    $result = $livroDao->excluir($id);
    if ($result) {
        echo "<script>
                    alert('Livro excluido com sucesso');
                    window.location.href = '../View/Adm/TelaInicialAdm.php';
                </script>";
    } else {
        echo "<script>
                    alert('Erro ao excluir livro');
                    window.location.href = '../View/Adm/TelaInicialAdm.php';
                </script>;";
    }
}

function adicionar($quantidade, $nomeLivro)
{
    if ($quantidade <= 0) {
        echo "<script>
                    alert('Erro, numero não pode ser negativo');
                    window.location.href = '../Adm/TelaInicialAdm.php';
                </script>;";
    }
    $livroDao = new LivroDao();
    $result = $livroDao->adicionar($nomeLivro, $quantidade);
    if ($result) {
        echo "<script>
                    alert('Livro adicionado com sucesso');
                    window.location.href = '../Adm/TelaInicialAdm.php';
                </script>";
    } else {
        echo "<script>
                    alert('Erro ao adicionar livro');
                    window.location.href = '../Adm/TelaInicialAdm.php';
                </script>;";
    }
}

#----------------REQUISIÇÕES GET --------------------------------------------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    #esse IF refere-se ao buscar livro por nome na pagina inicial 
    if (isset($_GET['procurar'])) {

        $livroBusca = ($_GET['buscar']);
        $livroB = new Livro();
        $livroBDao = new LivroDao();

        $result = $livroBDao->buscarLivro($livroBusca);

        if ($result !== 1) {

            $idLivro = $result->getId();

            session_start();
            $idU = $_SESSION['cod'];

            #retornar o id do livro e depois usar esse id e buscar no banco, para isso eu crio uma função nesta pagina e depois chamo essa função na tela inicial

            echo "<script>window.location.href ='../View/TelaInicial.php?id={$idU}&r={$idLivro}';</script>";
        } else {
            livroNaoencontrado();
        }
    } else if (isset($_GET['emprestar'])) { #entra em ação quando é clicado no botão de emprestar na tela inicial 

        $idRecibido = ($_GET['idLivro']);
        session_start();
        $idU = $_SESSION['cod'];

        $alterarQuant = new livroDao();
        $retorno = $alterarQuant->emprestar($idRecibido, $idU);

        //echo"retorno foi esse : $retorno";
        if ($retorno == 1) {

            echo "<script>window.location.href ='../View/Perfil.php?id={$idU}';</script>";
        } else if ($retorno == 2) {
            echo "<script>alert('Você ja está com este livro emprestado') 
                 window.location.href = '../View/TelaInicial.php?id={$idU}';
                </script> ";
        } else if ($retorno == 3) {
            echo "<script>alert('Não há estoque desse produto')
                    window.location.href = '../View/TelaInicial.php?id={$idU}';
                </script>";
        }
    } else if (isset($_GET['devolver'])) { #usado para pegar o id do livro quando clicado no botão de "devolver"

        $idLivroD = ($_GET['idLivro']);
        session_start();
        $idUsuario = $_SESSION['cod'];
        #echo"id do livro: $idLivroD id do usuario:$idUsuario";
        $devolverl = new LivroDao();
        $devolucao = $devolverl->devolver($idLivroD, $idUsuario);

        echo " resultado da ação: $devolucao";

        if ($devolucao == true) {
            echo "<script>alert('Seu livro foi devolvido com sucesso');
                    window.location.href = '../View/Perfil.php';
                </script>";
        } else {
            echo "<script>alert('Erro ao devolver o livro')
                      window.location.href = '../View/Perfil.php';
                      </script>";
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['adicionarLivro'])) {
        $livro = new Livro();
        $livro->setTitulo($_POST['titulo']);
        $livro->setAutor($_POST['autor']);
        $livro->setPagina($_POST['pagina']);
        $livro->setGenero($_POST['genero']);
        $livro->setEditora($_POST['editora']);
        $livro->setIsbn($_POST['isbn']);
        $livro->setQuantidade($_POST['quantidade']);
        $livro->setAnoPublicacao($_POST['publicacao']);
        $livroDao = new LivroDao();
        $result = $livroDao->cadastrar($livro);

        if ($result) {
            echo "<script>alert('Livro adicionado com sucesso');
                    window.location.href = '../View/Adm/TelaInicialAdm.php';
                </script>";
        } else {
            echo "<script>alert('Erro ao adicionar novo livro');
                    window.location.href = '../View/Adm/TelaInicialAdm.php';
                </script>";
        }
    }
}
