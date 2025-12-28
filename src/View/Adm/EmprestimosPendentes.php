<?php

require_once '../../Controller/AdmController.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Tela inicial Adm</title>
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
            <Header class="py-3 py-md-5">
                <h2 class=" text-center fw-bold my-4" style="font-family:Arial, Helvetica, sans-serif; color:#06355e;">Emprestimos Pendentes</h2>
            </Header>

            <div>
                <table class='table table-hover text-center'>
                    <thead>
                        <th scope='col'>Usuário</th>
                        <th scope='col'>Livro</th>
                        <th scope='col'>Data do Empréstimo</th>
                        <th scope='col'>Opção Empréstimo</th>
                    </thead>
                    <tbody>
                        <?php
                        emprestimosPendentes();
                        ?>

                    </tbody>
                </table>
            </div>
</body>