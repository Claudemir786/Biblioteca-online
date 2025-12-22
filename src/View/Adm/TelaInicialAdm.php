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
            <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>      

            <div class="d-flex gap-2 mt-2 mt-lg-0">
                <a href="./Index.php?id=$_SESSION['cod']" class="btn "  value = "sair" name="sair" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i>
                </a>
            </div>        
        
        </div>
    </nav>
    <div class="container mt-4 mb-5">
        <Header  class="py-3 py-md-5">
            <h2 class="text-center fw-bold my-4" style="font-family:Arial, Helvetica, sans-serif; color:#06355e;">Menu</h2>
        </Header>
       <div class="row g-3">

    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h5 class="card-title">Gerenciar empréstimos</h5>
                <p class="card-text">
                    Verificação de empréstimos pendentes e empréstimos confirmados
                </p>
                <a href="./EmprestimosConfirmados.php" class="btn btn-info">Confirmados</a>
                <a href="./EmprestimosPendentes.php" class="btn btn-info">Pendentes</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h5 class="card-title">Buscar usuário ou livro</h5>
                <p class="card-text">
                    Busca informações e status de determinado livro ou usuário
                </p>
                <a href="./BuscarUsuario.php" class="btn btn-info">Usuário</a>
                <a href="./BuscarLivro.php" class="btn btn-info">Livro</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h5 class="card-title">Adicionar Livro</h5>
                <p class="card-text">
                    Adiciona novo livro a base de dados
                </p>
                <a href="./AdicionarLivro.php" class="btn btn-info">Adicionar</a>
            </div>
        </div>
    </div>

</div>


    </div>

            

</div>

</body>    