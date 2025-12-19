<?php 
    
    require_once '../Controller/UsuarioController.php';
    require_once '../Dao/LivroDao.php';
    
    
    session_start();

     //se a pagina vier carregando o id de sessão 
    if(isset($_SESSION['cod'])){
       //usado o id para buscar informação de usuário, lembrando que esse 'COD' da sessão é o id do usuario 
        $usuarioId = $_SESSION['cod'];
        $usuarioDaoInfo = new UsuarioDao();
        $usuarioInfo = $usuarioDaoInfo->buscaId($usuarioId);

         
     

    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Perfil</title>
</head>
<body>
     <nav class="navbar navbar-expand-lg border shadow-lg" style="background-color:#fff;">
        <div class="container-fluid d-flex flex-wrap">        
            <a href="./TelaInicial.php"  class="text-decoration-none"> <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>  </a>        

        <div class="me-5">           
            <a href="./Index.php?id=$_SESSION['cod']" value="sair" name="sair" class="btn ms-5" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i></a>             
        </div>
</nav>
    <div class="container">
            <div class="row mt-5 pt-4" >
                
             <ul class="list-group list-group-flush">
                <li class="list-group-item">Nome: <p class="fw-bold"> 
                    <?= isset($usuarioInfo) && $usuarioInfo->getNome() ? $usuarioInfo->getNome() : 'Usuario não encontrado' ?> <!--if ternario para preencher os campos de acordo com a busca pelo id-->
                    <?= isset($usuarioInfo) && $usuarioInfo->getSobrenome() ? $usuarioInfo->getSobrenome() : '' ?></p>
                    <!--Alteração de nome-->
                    <a href="#" onclick="campoNome()" id="linkNome" class="text-decoration-none ">Mudar nome</a>
                    <form action="../Controller/UsuarioController.php" method="post" style="display:none;" id="nomeUser">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="nome" class="form-control" placeholder="Novo nome de cadastro" required>
                            </div>
                            <div class="col">
                                 <input type="text" name="sobrenome" class="form-control mb-3" placeholder="Sobrenome" required>
                            </div>
                        </div>                
                       <input type="submit" name="mudarNome" class="btn btn-info">
                    </form>
                </li>  
                     
                <li class="list-group-item">Email Cadastrado: <p class="fw-bold">
                    <?= isset($usuarioInfo) && $usuarioInfo->getEmail() ? $usuarioInfo->getEmail() : 'Email não encontrado' ?></p>
                    <!--Alteração de email-->
                    <a href="#" onclick="campoEmail()" id="linkEmail" class="text-decoration-none ">Alterar email cadastrado</a> 
                     <form action="../Controller/UsuarioController.php" method="post" style="display:none;" id="mail">
                        <input type="mail" name="email" class="form-control mb-3" placeholder="Digite o novo email" required>
                        <input type="submit" name="mudarEmail" class="btn btn-info">
                    </form>
                   
                </li>  

                <li class="list-group-item">Histórico de livros emprestados 
                    <form action="" method="get">
                        <input type="hidden" name="historico"/>
                        <input type="submit" name="ver" value="Ver" class="btn" style="background-color: #20d3d8;"/>
                    </form>
                    <?php 

                    if($_SERVER['REQUEST_METHOD'] ==='GET'){
                        if(isset($_GET['ver'])){#vem do botão de verificar histórico de livros
                            echo" <table class='table table-hover'>
                                    <thead >
                                            <tr>
                                            <th scope='col'>Titulo</th> 
                                            <th scope='col'>Autor</th>
                                            <th scope='col'>Gênero</th>
                                            <th scope='col'>Data Emprestimo</th>                                                                                                                     
                                            </tr>
                                        </thead>
                                        <tbody>";                           
                           include_once '../Controller/LivroController.php';
                           lerHistorico();
                            echo"</tbody></table>";
                         }
                        }
                    ?>
                </li>
                <li class="list-group-item">
                    <form action="../Controller/UsuarioController.php" method="post">
                        <input type="hidden" name="deletar"/>
                        <input type="submit" value="Excluir Conta" name="delete" class="btn" style="background-color: #4e0202ff; color:#fff;"  />
                    </form>
                </li>
            </ul>

           
          
        </div>
       
    </div>
</body>
</html>
<script>
    function campoNome(){
       document.getElementById('linkNome').style.display ='none';
       document.getElementById('nomeUser').style.display='block';
    }
    function campoEmail(){
        document.getElementById('linkEmail').style.display='none';
        document.getElementById('mail').style.display='block';

    }
</script>