<?php
require_once '../../Controller/AdmController.php';
$mostrarTabela = true; #controla se a tabela é mostrada
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
            <div class="row justify-content-center p-4">
                <form action="#" method="get" class="d-flex gap-2 col-6">
                    <input type="text" class="form-control" name="nome" placeholder="digite o primeiro nome" required>
                    <input type="submit" class="btn" style="background-color: #06355e;color:#fff" name="nomeUser" value="Buscar">
                </form>
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['detalhes'])) {
                $mostrarTabela = false;
                $idU = $_GET['idUsuario'];
                detalhes($idU);
            }
            ?>

            <!--se o botão de detalhes não for clicado mostra a tabela-->
            <?php if ($mostrarTabela) : ?>
                <div>
                    <table class='table table-hover text-center'>
                        <thead>
                            <tr>
                                <th scope='col'>Usuário</th>
                                <th scope='col'>Livros pendentes</th>
                                <th scope='col'>livros emprestado</th>
                                <th scope='col'>Opção</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "GET") {

                                if (isset($_GET['nomeUser'])) {
                                    $nome = ($_GET['nome']);
                                    usuarios($nome);
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
</body>