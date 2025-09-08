<?php 


if(isset($_GET['id'])){

  //se a pagona for carregado passando o id da sessão a sesão é encerrada
   echo" <script>alert('Saindo.....');</script>";
  session_start();
  session_unset();
  session_destroy(); //sessão encerrada
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <title>Tela inicial</title>
</head>
<style>
  
  
  .color1 {color: #140e29;}.color2{color: #5f325d;}.color3 {color: #2082d8;}.color4 {color: #20d3d8;}.color5 {color: #c7efed;}
  

</style>

<body style="background-color:#fff">

  <nav class="navbar navbar-expand-lg border shadow-lg " style="background-color:#fff;">
    <div class="container-fluid  d-flex">
      <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;"><i class="bi bi-book-half"></i> Raízes do saber
      </h1>
      <div class="ms-auto d-flex gap-4">
        <a href="./Login.php" class="btn ms-5" style="background-color:#2082d8;">Login <i class="bi bi-person"></i>
</a>
        <a href="./Cadastro.php" class="btn me-4 " style="background-color:#06355e; color: #2082d8;" >Criar conta <i class="bi bi-person-add"></i>
</a>
      </div>
    </div>
  </nav>
  <div class="container-fluid d-flex justify-content-center align-items-center"  style="background-color: #c7efed;">
    <div class="row p-0" >
      <div class="col mt-5 p-5 mb-5" >
        <div class="mt-5 p-4">
          <h2 style="font-family: Arial, Helvetica, sans-serif; font-size: 3rem; color: #06355e;" class="fw-bold">Biblioteca Raízes do saber</h2>
          <p class="fs-4">Aproveite o grande acervo de livros que temos disponiveis para você pegar emprestado e aproveitar!
            Não gostou do livro? não tem problema, você pode devolve-lo e pegar outro do seu agrado, o que não falta
            aqui são opções
            pra todos os estilos. Desde romances até hqs e mangás
          </p>
        </div>
      </div>     
      <div class="col bg-imagem col-md-4 col-lg-4 mb-5 d-none  d-md-block">  
        <img src="./img/mulher.png" class="img-fluid" alt="Mulher segurando um livro">      
      </div>
      <div class="row justify-content-evenly mt-5 mb-5">
          <div class="card border border-light" style="width: 18rem; background-color: #c7efed;">
            <img src="./img/hqs.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Hqs e Mangás</h5>
              <p class="card-text">Mergulhe em histórias cheias de ação, heróis e vilões inesquecíveis. Descubra aventuras épicas em cada página</p>
             
          </div>
        </div>
        <div class="card border border-light" style="width: 18rem; background-color: #c7efed;">
          <img src="./img/Romances.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Romances e literaturas</h5>
            <p class="card-text">Emoção, paixão e encontros inesperados. Relatos que tocam o coração e nos fazem acreditar no amor.</p>
            
          </div>
        </div>
        <div class="card border border-light" style="width: 18rem; background-color: #c7efed;">
          <img src="./img/biografia.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Biografias</h5>
            <p class="card-text">Conheça grandes obras da literatura e as trajetórias inspiradoras de personalidades que marcaram a história.</p>          
          </div>
        </div>      
    </div>    
    </div>    
  </div>
    <div class=" mt-3 d-flex justify-content-center align-items-center p-3" style="background-color: #fff;">
      <footer >
        <p>Desenvolvido por : Claudemir Junior</p>
      </footer>
      </div>
</body>

</html>