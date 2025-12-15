<?php 

   
    require '../Model/Livro.php';
    require '../Model/Usuario.php';
    require '../Dao/ConnectionFactory.php';
    require '../Dao/UsuarioDao.php';
    require '../Dao/LivroDao.php';

    #função que lista todos os livros na página inicial 
    function listarLivros(){         
       
        $livroE = new Livro();
        $livroListaDao = new LivroDao();

        $livroLista = $livroListaDao->listar();#chama o método listar na DAO

        foreach($livroLista as $livroE){
            echo "
                <tr> 
                    <td>{$livroE->getTitulo()}</td>
                    <td>{$livroE->getAutor()}</td>
                    <td>{$livroE->getGenero()}</td>
                    <td>{$livroE->getPagina()}</td>
                    <td>{$livroE->getEditora()}</td>
                   
                    <td>  
                        <form action='../Controller/LivroController.php' method='get'> 
                            <input type='hidden' value='{$livroE->getId()}' name='idLivro' />                           
                             
                            <button type='submit' class='btn btn-info' name='emprestar' >Emprestar</button>
                        </form> 
                    </td>
                </tr>
            ";
            #neste caso é mostrado informações do livro e o botão de emprestimo, neste form é enviado o id do livro através de um input invisivel 
        }

    }

    #encontra o livro via id do usuário
    function livroUsuario($id){

        $livroUsuario = new Livro();
        $livroUsuarioDao = new LivroDao();

        $livroUsuario = $livroUsuarioDao->livrosUsuario($id);       
         
      if($livroUsuario != false){
          
       foreach($livroUsuario as $livro){

        echo"<tr>
                <td>{$livro->getTitulo()}</td>
                <td>{$livro->getAutor()}</td>
                <td>{$livro->getGenero()}</td>
                <td>{$livro->getPagina()}</td>
                <td>{$livro->getEditora()}</td>
                <td>
                    <form action='../Controller/LivroController.php' method='get'> 
                        <input type='hidden' value='{$livro->getId()}' name='idLivro' />
                        <button type='submit' class='btn btn-primary' name='devolver' >Devolver</button>
                    </form>                               
                              
                </td>
        
            </tr>";

       }


      }else{

        echo "<h2 class= 'text-center'>Não foram encontrados livros</h2>";
      }
         
        
            

    }

    #função que está vinculada ao campo livre de "buscar" na tela inicial, serve prar mostrar o livro com o nome procurado
    function livroId($id){        
        
        $livro1Dao = new LivroDao();

        $livroRetorno = $livro1Dao->buscaLivroId($id);

        if($livroRetorno == false){

             echo"<h2>Livro não encontrado na base da dados <h2>";

        }else{

            #tabela que mostra o livro encontrado por meio do Id
            echo "
             <div >
           <table class='table table-hover mt-5'>
            <thead>
                <tr>
                   <th scope='col'>Titulo</th> 
                   <th scope='col'>Autor</th>
                   <th scope='col'>Gênero</th>  
                   <th scope='col'>Páginas</th>                  
                   <th scope='col>Editora</th> 
                   <th scope='col'>Editora</th>
                   <th scope='col'>Opção</th>                
                </tr>
            </thead>
             <tbody>
                <tr> 
                    <td>{$livroRetorno->getTitulo()}</td>
                    <td>{$livroRetorno->getAutor()}</td>
                    <td>{$livroRetorno->getGenero()}</td>
                    <td>{$livroRetorno->getPagina()}</td>
                    <td>{$livroRetorno->getEditora()}</td>
                    <td> 
                        <form action='../Controller/LivroController.php' method='get'> 
                            <input type='hidden' value='{$livroRetorno->getId()}' name='idLivro' />                           
                             
                            <button type='submit' class='btn btn-info' name='emprestar' >Emprestar</button>
                        </form> 
                    
                    </td>                 
                </tr>
            
            </tbody>

             </table>
           </div>"
               ;
           
        }



    }


  if($_SERVER["REQUEST_METHOD"] == "GET"){

    #esse IF refere-se ao buscar livro por nome na pagina inicial 
        if(isset($_GET['procurar'])){
            
            $livroBusca = ($_GET['buscar']);
            $livroB = new Livro();
            $livroBDao = new LivroDao();

            $result = $livroBDao->buscarLivro($livroBusca);
            
            if($result !== 1){
                
                $idLivro = $result->getId();

                session_start();
                $idU = $_SESSION['cod'];

                #retornar o id do livro e depois usar esse id e buscar no banco, para isso eu crio uma função nesta pagina e depois chamo essa função na tela inicial

                echo "<script>window.location.href ='../View/TelaInicial.php?id={$idU}&r={$idLivro}';</script>";
                
            }else{

                echo("livro não encontrado");
            }
            
        }else if(isset($_GET['emprestar'])){#entra em ação quando é clicado no botão de emprestar na tela inicial 
          
            $idRecibido = ($_GET['idLivro']);
            session_start();
                $idU = $_SESSION['cod'];      
          
            $alterarQuant = new livroDao();           
            $retorno = $alterarQuant->emprestar($idRecibido,$idU);
            
           
           
            if($retorno === true){
                
                echo "<script>window.location.href ='../View/Perfil.php?id={$idU}';</script>";

            }else if($retorno === 2){
                echo"<script>alert('Você ja está com este livro emprestado') 
                 window.location.href = '../View/TelaInicial.php?id={$idU}';
                </script> ";
            }else{
                echo"<script>alert('Não há estoque desse produto')
                    window.location.href = '../View/TelaInicial.php?id={$idU}';
                </script>";
            }
        }else if(isset($_GET['devolver'])){#usado para pegar o id do livro quando clicado no botão de "devolver"

            $idLivroD = ($_GET['idLivro']);
            session_start();
            $idUsuario = $_SESSION['cod'];
            #echo"id do livro: $idLivroD id do usuario:$idUsuario";
            $devolver = new LivroDao();
            $devolucao = $devolver->devolver($idLivro, $idUsuario);

            if($devolucao == true){
                echo"<script>alert('Seu livro foi devolvido com sucesso');
                    window.location.href = '../View/TelaInicial.php?id={$idUsuario}';
                </script>";    
            }else{
                 echo"<script>alert('Erro ao devolver o livro')
                      window.location.href = '../View/Perfil.php';
                      </script>";  
            }

        }
    }
   
   
?>