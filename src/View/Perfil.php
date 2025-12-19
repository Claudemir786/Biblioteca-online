<?php 
    require '../Controller/LivroController.php';

  session_start();
  if(isset($_SESSION['cod'])){
        $usuarioId = $_SESSION['cod'];
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
<body class="min-vh-100 d-flex flex-column">
     <nav class="navbar navbar-expand-lg border shadow-lg" style="background-color:#fff;">
        <div class="container-fluid d-flex flex-wrap">        
            <a href="./TelaInicial.php"  class="text-decoration-none"> <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>  </a>        

        <div class="d-flex flex-column flex-md-row gap-2 mt-2 mt-md-0">
            <a href="./InfoConta.php" class="btn ms-5" style="background-color:#2082d8;">Informações da conta<i class="bi bi-lock"></i></a>
            <a href="./Index.php?id=$_SESSION['cod']" value="sair" name="sair" class="btn ms-5" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i></a>
             
            </div>
</nav>
    <div class="container">
       <div class="row">
        <div class="col-12 text-center py-4 py-md-5">
             <Header><h1 class="fs-4 fs-md-2" style="color: #06355e;">Lista de livros emprestados</h1></Header>
              
        </div>
        <div class="text-center p-2">
            <p class="fw-bold fs-6 fs-md-4 text-center px-2"> Favor comparecer a este endereço para retirada: Rua fictícia N৹:55 Bairro: Fictício </p>
        </div>
       <div class="table-responsive">
        <table class="table table-hover">
            <thead >
                    <tr class="text-center">
                    <th scope="col"class="d-none d-md-table-cell" >Titulo</th> 
                    <th scope="col"class="d-none d-md-table-cell">Autor</th>
                    <th scope="col"class="d-none d-md-table-cell">Gênero</th>  
                    <th scope="col"class="d-none d-md-table-cell">Páginas</th>                  
                    <th scope="col"class="d-none d-md-table-cell">Editora</th>                               
                    <th scope="col"class="d-none d-md-table-cell">Opção</th>                               
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        livroUsuario($usuarioId);
                    ?>
                </tbody>
        </table>
       </div>
       
       </div>
    </div>
</body>
</html>