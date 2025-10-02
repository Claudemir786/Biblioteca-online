<?php 

   
    require '../Model/Livro.php';
    require '../Model/Usuario.php';
    require '../Dao/ConnectionFactory.php';
    require '../Dao/UsuarioDao.php';
    require '../Dao/LivroDao.php';


    function listarLivros(){         
       
        $livroE = new Livro();
        $livroListaDao = new LivroDao();

        $livroLista = $livroListaDao->listar();

        foreach($livroLista as $livroE){
            echo "
                <tr> 
                    <td>{$livroE->getTitulo()}</td>
                    <td>{$livroE->getAutor()}</td>
                    <td>{$livroE->getGenero()}</td>
                    <td>{$livroE->getPagina()}</td>
                    <td>{$livroE->getEditora()}</td>
                    <td>{$livroE->getQuantidade()}</td>
                    <td> <a href='' class = 'btn btn-info'>Emprestar</a> </td>
                </tr>
            ";
        }

    }

    function livroUsuario($id){

        $livroUsuario = new Livro();
        $livroUsuarioDao = new LivroDao();

        $listaLivroUsuario = $livroUsuarioDao->livrosUsuario($id);

       

       foreach($listaLivroUsuario as $livroUsuario){
             echo "
                <tr> 
                    <td>{$livroUsuario->getTitulo()}</td>
                    <td>{$livroUsuario->getAutor()}</td>
                    <td>{$livroUsuario->getGenero()}</td>
                    <td>{$livroUsuario->getPagina()}</td>
                    <td>{$livroUsuario->getEditora()}</td>
                    <td> <a haref = '' class='btn btn-primary' >Devolver</a></td>
                 
                </tr>
            ";
        }

    }

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
                   <th scope='col'>Quantidade</th>
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
                    <td> <a haref = '' class='btn btn-info' >Emprestar</a></td>                 
                </tr>
            
            </tbody>

             </table>
           </div>"
               ;
           
        }



    }

  if($_SERVER["REQUEST_METHOD"] == "GET"){

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
            
        }
    }
   
?>