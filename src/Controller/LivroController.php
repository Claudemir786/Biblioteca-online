<?php 

   
    require_once '../Model/Livro.php';
    require_once '../Model/Usuario.php';
    require_once '../Dao/ConnectionFactory.php';
    require_once '../Dao/UsuarioDao.php';
    require_once '../Dao/LivroDao.php';

    #função que lista todos os livros na página inicial 
    function listarLivros($select){         
       
        if($select){
             $livroE = new Livro();
            $livroListaDao = new LivroDao();

            $livroLista = $livroListaDao->listar();#chama o método listar na DAO

            foreach($livroLista as $livroE){
                echo "
                    <option value'{$livroE->getTitulo()}'>{$livroE->getTitulo()}</option>
                ";
            }
        }else{
            $livroE = new Livro();
            $livroListaDao = new LivroDao();

            $livroLista = $livroListaDao->listar();#chama o método listar na DAO

            foreach($livroLista as $livroE){
                echo"<div class='col-12 col-md-6 col-lg-4'>
                        <div class='card h-100 shadow-sm border border-opacity-50 '>
                        <div class='card-body'>

                            <h5 class='card-title fw-bold'>{$livroE->getTitulo()}</h5>
                            <p class='text-muted mb-1'>{$livroE->getAutor()}</p>

                            <span class='badge bg-secondary'>{$livroE->getGenero()}</span>

                            <ul class='list-unstyled mt-3 mb-3'>
                            <li><strong>Páginas:</strong> {$livroE->getPagina()}</li>
                            <li><strong>Editora:</strong>{$livroE->getEditora()}</li>
                            </ul>

                            <form action='../Controller/LivroController.php' method='get'> 
                                <input type='hidden' value='{$livroE->getId()}' name='idLivro' />                           
                                
                                <button type='submit' class='btn btn-info' name='emprestar' > 📖Emprestar</button>
                            </form> 

                           

                        </div>
                        </div>
                    </div>";

                /*echo "
                    <tr> 
                        <td>{$livroE->getTitulo()}</td>
                        <td>{$livroE->getAutor()}</td>
                        <td>{$livroE->getGenero()}</td>
                        <td class='text-center'>{$livroE->getPagina()}</td>
                        <td>{$livroE->getEditora()}</td>
                        
                    
                        <td>  
                            <form action='../Controller/LivroController.php' method='get'> 
                                <input type='hidden' value='{$livroE->getId()}' name='idLivro' />                           
                                
                                <button type='submit' class='btn btn-info' name='emprestar' >Emprestar</button>
                            </form> 
                        </td>
                    </tr>
                ";*/
                #neste caso é mostrado informações do livro e o botão de emprestimo, neste form é enviado o id do livro através de um input invisivel 
        }
    }
    }


    #encontra o livro via id do usuário
    function livroUsuario($id){

        $livroUsuario = new Livro();
        $livroUsuarioDao = new LivroDao();

        $livroUsuario = $livroUsuarioDao->livrosUsuario($id, $historico=false);       
         
      if($livroUsuario != false){
          
       foreach($livroUsuario as $livro){

        echo"<tr class='text-center'>
                <td class='d-none d-md-table-cell'>{$livro->getTitulo()}</td>
                <td class='d-none d-md-table-cell'>{$livro->getAutor()}</td>
                <td class='d-none d-md-table-cell'>{$livro->getGenero()}</td>
                <td class='d-none d-md-table-cell'>{$livro->getPagina()}</td>
                <td class='d-none d-md-table-cell'>{$livro->getEditora()}</td>
                <td class='d-none d-md-table-cell'>
                    <form action='../Controller/LivroController.php' method='get'> 
                        <input type='hidden' value='{$livro->getId()}' name='idLivro' />
                        <button type='submit' class='btn btn-sm btn-primary w-100 w-md-auto' name='devolver' >Devolver</button>
                    </form>                               
                              
                </td>
        
            </tr>";

       }


      }else{

        livroNaoencontrado();
      }
         
        
            

    }

    #função que está vinculada ao campo livre de "buscar" na tela inicial, serve prar mostrar o livro com o nome procurado
    function livroId($id){        
        
        $livro1Dao = new LivroDao();

        $livroRetorno = $livro1Dao->buscaLivroId($id);

        if($livroRetorno == false){

             livroNaoencontrado();

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


    function lerHistorico(){
        $historicoLivro = new LivroDao();      
       
        $id = $_SESSION['cod'];
        $historico = $historicoLivro->livrosUsuario($id,true);
        if($historico != false){
          
       foreach($historico as $livro){
            $dataEmprestimo = $historicoLivro->dataEmprestimo($livro->getId(), $id);
                    
            
        echo"<tr>
                <td>{$livro->getTitulo()}</td>
                <td>{$livro->getAutor()}</td>
                <td>{$livro->getGenero()}</td>                                          
                <td>{$dataEmprestimo}</td>
            </tr>
           ";
       }

      }else{
        livroNaoencontrado();
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
                livroNaoencontrado();
            }
            
        }else if(isset($_GET['emprestar'])){#entra em ação quando é clicado no botão de emprestar na tela inicial 
          
            $idRecibido = ($_GET['idLivro']);
            session_start();
                $idU = $_SESSION['cod'];      
          
            $alterarQuant = new livroDao();           
            $retorno = $alterarQuant->emprestar($idRecibido,$idU);            
           
           //echo"retorno foi esse : $retorno";
            if($retorno == 1){
                
                echo "<script>window.location.href ='../View/Perfil.php?id={$idU}';</script>";

            }else if($retorno == 2){
                echo"<script>alert('Você ja está com este livro emprestado') 
                 window.location.href = '../View/TelaInicial.php?id={$idU}';
                </script> ";
            }else if($retorno == 3){
                echo"<script>alert('Não há estoque desse produto')
                    window.location.href = '../View/TelaInicial.php?id={$idU}';
                </script>";
            }
        }else if(isset($_GET['devolver'])){#usado para pegar o id do livro quando clicado no botão de "devolver"

            $idLivroD = ($_GET['idLivro']);
            session_start();
            $idUsuario = $_SESSION['cod'];
            #echo"id do livro: $idLivroD id do usuario:$idUsuario";
            $devolverl = new LivroDao();
            $devolucao = $devolverl->devolver($idLivroD, $idUsuario);

            echo" resultado da ação: $devolucao";

            if($devolucao == true){
                echo"<script>alert('Seu livro foi devolvido com sucesso');
                    window.location.href = '../View/Perfil.php';
                </script>";    
            }else{
                 echo"<script>alert('Erro ao devolver o livro')
                      window.location.href = '../View/Perfil.php';
                      </script>";  
            }

        }
    }
    function livroNaoencontrado(){
        echo"<div style='
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
   
   
?>