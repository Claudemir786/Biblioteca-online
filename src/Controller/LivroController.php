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

    function livrosUsuario($id){

        $livroUsuario = new Livro();
        $livroUsuarioDao = new LivroDao();

        $listaLivroUsuario = $livroUsuarioDao->livrosUsuairo($id);

       

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

?>