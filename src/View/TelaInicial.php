<?php      

 require '../Controller/LivroController.php'; 
    if(isset($_GET['id'])){
        session_start();
        $idUsuario = $_GET['id'];
        $_SESSION['cod'] = $idUsuario;

    }

     
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Tela inicial</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg border shadow-lg" style="background-color:#fff;">
    <div class="container-fluid d-flex flex-wrap">        
             <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>            
    
        <div class="col">
            <form action="../Controller/LivroController.php" method="get">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control " name="buscar" id="busca" placeholder="Buscar Livro">
                </div>
                <div class="col" >
                    <input type="submit" class="btn "style="background-color: #06355e; color: #fff;" name="procurar" value="Buscar">    
                </div>
            </div>       
         
        </form>   
        </div> 
        <div >
            <a href="./Perfil.php" class="btn ms-5" style="background-color:#2082d8;">Perfil<i class="bi bi-person"></i></a>
        </div>
        <div class="me-5">
            <a href="./Index.php?id=$_SESSION['cod']" class="btn ms-5"  value = "sair" name="sair" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i>
</a>
        </div>
    
    </div>
</nav>
   
       <div class="row align-items-center justify-content-center d-flex">
        <?php 
        #retorno com id de usuario e de livro pesquisado
            if(isset($_GET['id']) && isset($_GET['r'])){        
              
                
                
                 livroId($_GET['r']);           
                
               echo" '<script>esconder()</srcipt>'";#esconde o resto da tela
        
            }
        ?>
         <div class="container" id=corpo>
           <header class="p-5">
                <h1 class="text-center" style="font-family:Arial, Helvetica, sans-serif; color:#06355e;">Lista de livros Diponiveis</h1>
               
           </header> 
           <div>
           <table class="table table-hover">
            <thead>
                <tr>
                   <th scope="col">Titulo</th> 
                   <th scope="col">Autor</th>
                   <th scope="col">Gênero</th>  
                   <th scope="col">Páginas</th>                  
                   <th scope="col">Editora</th> 
                   <th scope="col">Quantidade</th>
                   <th scope="col">Opção</th>                
                </tr>
            </thead>
            <tbody>
                <?php  
                    listarLivros();
                ?>
            </tbody>

           </table>
           </div>
       </div>

    </div>

    
</body>

</html>

        <!---Usado para esconder a tela principal-->
<script>
    function mostrar() {
  document.getElementById("corpo").style.display = "block";
}

function esconder() {
  document.getElementById("corpo").style.display = "none";
}
</script>