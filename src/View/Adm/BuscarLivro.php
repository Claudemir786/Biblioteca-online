<?php
require_once '../../Controller/LivroController.php';
require_once '../../Controller/AdmController.php';


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Buscar usuário</title>
</head>

<body>
    <div class="container-fluid">
        <nav class="row navbar navbar-expand-lg border shadow-lg " style="background-color:#fff;">
            <div class="container-fluid d-flex flex-wrap">
                <a href="./TelaInicialAdm.php" class="text-decoration-none">
                    <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>
                </a>

                <div class="d-flex gap-2 mt-2 mt-lg-0">
                    <a href="../Index.php" class="btn " value="sair" name="sair" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i>
                    </a>
                </div>

            </div>
        </nav>
        <div class="container mt-4 mb-5">
            <div class=" d-flex align-itens-center justify-content-center mt-5">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-12 col-md-10 col-lg-8 ">
                            <select name="buscar" class="form-select mx-5 ">
                                <option>Buscar Livro</option>
                                <?php listarLivros(true) ?>

                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 text-center">
                            <input type="submit" class="btn ms-5" style="background-color: #06355e; color: #fff;" name="procurarAdm" value="Buscar">
                        </div>
                    </div>

                </form>
            </div>
            <!--Na hora que a requisição voltar mostrar tablea-->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['procurarAdm'])) {
                $tituloLivro = $_GET['buscar'];
                buscarLivroEmprestimo($tituloLivro);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (isset($_POST['excluir'])) {

                    $id = $_POST['idLivro'];
                    $idLivro = $id;
                    excluir($id);
                }
                if (isset($_POST['aumentar'])) {
                    $nomeLivro = $_GET['buscar']; #pega o nome do livro pela url
                    $quant = $_POST['quant'];
                    adicionar($quant, $nomeLivro);
                }
            }
            ?>
            <div id="quantidade" style="display:none" class="text-center">
                <form method="post" class="mx-auto" style="max-width: 250px;">
                    <div id="input">
                        <label class="form-label">Digite a quantidade</label>
                        <input type="number" name="quant" class="form-control mb-3" required>
                    </div>
                    <input type="submit" name="aumentar" value="Adicionar" class="btn btn-info ">
                </form>
            </div>

        </div>
    </div>
</body>


<script>
    function campoAdicionar(id) {
        document.getElementById('quantidade').style.display = 'block';

    }
</script>