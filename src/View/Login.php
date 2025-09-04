<?php
    require '../Controller/UsuarioController.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <title>Login</title>
</head>
<style>
.color1 {color: #140e29;}
.color2 {color: #5f325d;}
.color3 {color: #2082d8;}
.color4 {color: #20d3d8;}
.color5 {color: #c7efed;}
 .bg-imagem {
      background-image: url('./img/biblioteca.png'); /* coloque o caminho da sua imagem */
      background-size: cover;  /* faz a imagem cobrir todo o espaço */
      background-position: center;/* centraliza a imagem */
      height: 100vh;
      width: 100%;   /* ocupa a altura inteira da tela */
      
    }
</style>
<body class="bg-imagem"> 
    
    <div class="container d-flex justify-content-center align-items-center vh-100">        
        <div class="row ">                     
            <div class="col">
                <div class="text-center text-light rounded-3 " style="background-color:#6b757eb2">
                    <h2 class="mb-3 p-2" style="font-family:Arial, Helvetica, sans-serif; font-size: 40px;">Login <i class="bi bi-book-half"></i></h2>
                    
                    <form action="../Controller/UsuarioController.php" method="post">
                        <div class="mb-3 mx-5">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="emailUser" class="form-control" required >
                        </div>
                        <div class="mb-3 mx-5">
                            <label class="form-label" for="senha">Senha</label>
                            <input type="password" class="form-control" id="passwordUser" name="password" minlength="6" maxlength="15" require>
                        </div>                       
                        <button type="submit" class="btn mb-3" name="logar" style=" background-color:#20d3d8" >Entrar</button><br>
                        <?php
                           if(isset($_GET['usern'])){

                                 echo"<p style = 'color:red'>Usuário ou senha incorretos</p>";
                           }
                               
                            
                        ?>
                        <a href="./Cadastro.php" class="color4">Criar conta</a><br>
                        <a href="./EsqueciSenha.php" class="color4">Esqueci a senha</a><br><br>
                    </form>
                </div>
            </div>            

        </div>
      
<!--Biblioteca Raízes do Saber-->
    </div>

</body>
</html>