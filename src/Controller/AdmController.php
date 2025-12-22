<?php 

    require_once __DIR__ . '/../Model/Livro.php';   
   
    require_once __DIR__.'/../Model/Usuario.php';
    require_once __DIR__ .'/../Dao/ConnectionFactory.php';
    require_once __DIR__.'/../Dao/UsuarioDao.php';
    require_once __DIR__.'/../Dao/LivroDao.php';
   

    function detalhes(){
        echo" <tr>
                  <td>
                     <div>
                        <h5>Livros Emprestados</h5>
                        <ul class='list-unstyled'>
                              <li class='d-flex justify-content-between align-items-center mb-2'>
                                 <span>Amor e o Tempo</span>
                                 <form action='../../Controller/LivroController.php' method='get' class='d-flex gap-2'>
                                    <input type='submit' class='btn btn-sm p-2' name='devolver' style='background-color: #06355e;color:#fff;' value='Devolver'>
                                 </form>
                              </li>
                        <h5>Livros Pendentes</h5>
                              <li class='d-flex justify-content-between align-items-center mb-2'>
                                 <span>Amor e Eu</span>
                                 <form action='../../Controller/LivroController.php' method='get' class='d-flex gap-2'>
                                    <input type='submit' class='btn btn-sm p-2' name='confirmar' style='background-color: #06355e;color:#fff;' value='Confirmar'>
                                 </form>
                              </li>
                        </ul>
                     </div>
                  </td>
                           
            </tr>";
    }
  
    
    
    if($_SERVER["REQUEST_METHOD"] == 'GET'){
        
         if(isset($_GET['devolver'])){
            echo"livro devolvido";
         }

         if(isset($_GET['confirmar'])){
            echo"confirmado";
         }

         if(isset($_GET['cancelar'])){
            echo"cancelado";
         }
    }
   
?>