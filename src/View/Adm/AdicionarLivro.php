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
               <a href="./TelaInicialAdm.php"  class="text-decoration-none"> <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>  </a>      

                <div class="d-flex gap-2 mt-2 mt-lg-0">
                    <a href="./Index.php?id=$_SESSION['cod']" class="btn "  value = "sair" name="sair" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i>
                    </a>
                </div>        
            
            </div>
        </nav>
        <div class="container mt-4 mb-5">
             <div class="row g-3 "> 
                <div class="col-md-4"></div>       
                <div class="col-md-4">
                    <div class="text-center text-light rounded-3 p-3" style="background-color:#6b757eb2">
                        <h2 class="mb-3 p-2" style="font-family:Arial, Helvetica, sans-serif; font-size: 40px;">Cadastrar <i class="bi bi-book-half"></i></h2>
                        <form action="../../Controller/LivroController.php" method="post" class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label" for="titulo">Titulo</label>
                                <input type="text" name="titulo"class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="autor">Autor</label>
                                <input type="text" class="form-control "name="autor" required>
                            </div>   
                            <div class="col-md-6">
                                <label class="form-label" for="pagina">Paginas</label>
                                <input type="number" name="pagina" class="form-control" required >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Genero">Genêro</label>
                                <input type="text" class="form-control" name="genero" required>
                            </div>       
                            <div class="col-md-6">
                                <label class="form-label" for="editora">Editora</label>
                                <input type="text" class="form-control" name="editora" required>
                            </div>                                   
                            <div class="col-md-6">
                                <label class="form-label" for="isbn">Isbn</label>
                                <input type="text" class="form-control" name="isbn" required>
                            </div>                                   
                            <div class="col-md-6">
                                <label class="form-label" for="quantidade">Quantidade</label>
                                <input type="number" class="form-control" name="quantidade" required>
                            </div>                                   
                            <div class="col-md-12">
                                <label class="form-label" for="publicaao">Ano Publicação</label>
                                <input type="number" class="form-control" name="publicacao" required>
                            </div>
                            <div>
                                <button type="submit" class="btn mb-3" name="adicionarLivro" style=" background-color:#20d3d8" >Adicionar</button><br>
                            </div>
                                               
                        </form>
                    </div>

                </div>            

        </div>
    </div>
    </div>
</body>        