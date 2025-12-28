<?php

require '../Controller/LivroController.php';
if (isset($_GET['id'])) {
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
    <div class="container-fluid">
        <nav class="row navbar navbar-expand-lg border shadow-lg " style="background-color:#fff;">
            <div class="container-fluid d-flex flex-wrap">
                <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>

                <div class="col-12 col-md-6 col-lg-4 ">
                    <form action="../Controller/LivroController.php" method="get">
                        <div class="row">
                            <div class="col-12 col-md-10 col-lg-8 ">

                                <select name="buscar" class="form-select">
                                    <option>Buscar Livro</option>
                                    <?php listarLivros(true) ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <input type="submit" class="btn " style="background-color: #06355e; color: #fff;" name="procurar" value="Buscar">
                            </div>
                        </div>

                    </form>
                </div>
                <div class='d-flex gap-2 mt-2 mt-lg-0'>
                    <a href="./Perfil.php" class="btn " style="background-color:#2082d8;">Perfil<i class="bi bi-person"></i></a>
                </div>
                <div class="d-flex gap-2 mt-2 mt-lg-0">
                    <a href="./Index.php?id=$_SESSION['cod']" class="btn " value="sair" name="sair" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i>
                    </a>
                </div>

            </div>
        </nav>

        <div class="row align-items-center justify-content-center ">
            <?php
            #retorno com id de usuario e de livro pesquisado depois de clicar em "buscar"
            if (isset($_GET['id']) && isset($_GET['r'])) {

                livroId($_GET['r']);

                echo " '<script>esconder()</srcipt>'"; #esconde o resto da tela

            }
            ?>
            <div class="container mt-4 mb-5" id=corpo>
                <header class="py-3 py-md-5">
                    <h2 class="text-center fw-bold my-4" style="font-family:Arial, Helvetica, sans-serif; color:#06355e;">Lista de livros Diponiveis</h2>
                </header>
                <div class="mb-5  display-flex justify-content-center text-center">
                    <form action="#" method="get">
                        <div class="row g-3 justify-content-center">

                            <div class="col-12 col-md-2">
                                <input type="submit" class="form-control btn btn-secondary" name="romance" value="Romance">
                            </div>
                            <div class="col-12 col-md-2">
                                <input type="submit" class="form-control btn btn-secondary" name="hq" value="HQ">
                            </div>
                            <div class="col-12 col-md-2">
                                <input type="submit" class="form-control btn btn-secondary" name="biografia" value="Biografia">
                            </div>

                        </div>

                    </form>

                </div>
                <div class="row g-4 d-flex justify-content-center" id=livros>

                    <?php
                    if (isset($_GET['romance'])) {
                        livroCategoria('romance');
                    } else if (isset($_GET['hq'])) {
                        livroCategoria('hq');
                    } else if (isset($_GET['biografia'])) {
                        livroCategoria('biografia');
                    } else {

                        listarLivros(false);
                    }
                    ?>


                </div>


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