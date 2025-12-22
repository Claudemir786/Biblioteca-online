<?php 
    require_once '../../Controller/LivroController.php';
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
               <a href="./TelaInicialAdm.php"  class="text-decoration-none"> <h1 style="font-family:Arial, Helvetica, sans-serif; color:#06355e;" class="me-5"><i class="bi bi-book-half"></i> Raízes do saber</h1>  </a>      

                <div class="d-flex gap-2 mt-2 mt-lg-0">
                    <a href="./Index.php?id=$_SESSION['cod']" class="btn "  value = "sair" name="sair" style="background-color:#20d3d8">Sair<i class="bi bi-box-arrow-in-right"></i>
                    </a>
                </div>        
            
            </div>
        </nav>
        <div class="container mt-4 mb-5">
            <div class=" d-flex align-itens-center justify-content-center mt-5">
                <form action="../../Controller/LivroController.php" method="get">
                <div class="row">
                    <div class="col-12 col-md-10 col-lg-8 ">                    
                        <select name="buscar" class="form-select mx-5 ">
                            <option>Buscar Livro</option>
                            <?php listarLivros(true)?>                            
                            
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 text-center" >
                        <input type="submit" class="btn ms-5"style="background-color: #06355e; color: #fff;" name="procurar" value="Buscar">    
                    </div>
                </div>       
            
            </form>   
            </div> 
            <!--Na hora que a requisição voltar mostrar tablea-->
            <table class="table" id="tabela">
                <thead class="text-center">
                   <th scope='col'>Titulo</th> 
                   <th scope='col'>Estoque</th> 
                   <th scope='col'>Emprestimos Confirmados</th> 
                   <th scope='col'>Opção</th> 
                </thead>
                <tbody>
                    <!--parte que vai ser usada no php-->
                    <tr class="text-center">
                        <td>Naruto</td>
                        <td>55</td>
                        <td>2</td>
                        <td>
                            <form action='../../Controller/LivroController.php' method="post">
                                <input type="submit" class="btn" name="excluir"  value="Excluir" style="background-color: #4e0202ff; color:#fff;">
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
</body>      

<script>

</script>