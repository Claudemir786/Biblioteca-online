<?php 

    require_once __DIR__ . '/../Model/Livro.php';   
   
    require_once __DIR__.'/../Model/Usuario.php';
    require_once __DIR__ .'/../Dao/ConnectionFactory.php';
    require_once __DIR__.'/../Dao/UsuarioDao.php';
    require_once __DIR__.'/../Dao/LivroDao.php';
    require_once __DIR__.'/../Dao/EmprestimoDao.php';
    require_once __DIR__.'/../Model/EmprestimoCNome.php';
   

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
  
    function emprestimosConfirmados(){
     
      $eConfirmados = new EmprestimoDao();
      $ativos = $eConfirmados->emprestimoConfirm();

      if($ativos != false){         
         foreach($ativos as $linha){

          echo"<tr>                                                       
                     <td>{$linha->getNomeUsuario()} {$linha->getSobrenome()}</td>
                     <td>{$linha->getNomeLivro()}</td>
                     <td>{$linha->getData()}</td>
                     <td>                               
                        <form action='../../Controller/AdmController.php' method='post' >
                        <input type='hidden' value='{$linha->getId()}' name='idEmprestimo'>
                        <input type='hidden' value='{$linha->getIdLivro()}' name='idLivro'>
                        <input type='submit' class='btn btn-info'  name='devolver' value='Devolver'>
                        </form>                       
                     </td>                                                        
               </tr>
                  ";
                 
         }
         
      }else{
         echo"<div>
               <h2>Lista de emprestimos não encontrada</h2
              </div>";
      }


    }

    function emprestimosPendentes(){
      $pendentes = new EmprestimoDao();
      $Ependentes = $pendentes->emprestimosPendentes();
      
      if($Ependentes){
         foreach($Ependentes as $linha){
            echo"<tr>                            
                     <td>{$linha->getNomeUsuario()} {$linha->getSobrenome()}</td>
                     <td>{$linha->getNomeLivro()}</td>
                     <td>{$linha->getData()}</td>
                     <td>
                        <form action='../../Controller/AdmController.php' method='post'>
                        <input type='hidden' name='idEmprestimo' value={$linha->getId()}>
                        <input type='hidden' name='idUsuario' value={$linha->getIdUsuario()}>
                        <input type='hidden' name='idLivro' value={$linha->getIdLivro()}>
                        <input type='submit' class='btn btn-info'  name='confirmar' value='Confirmar'>
                        <input type='submit' class='btn' style='background-color: #06355e; color:#fff;'  name='cancelar' value='Cancelar'>
                        </form> 
                     
                     </td>
                                                
                  </tr>";
         }
      }else{
         echo"Deu errado";
      }
    }
    
    
    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        
         if(isset($_POST['devolver'])){
            $idEmprestimo = $_POST['idEmprestimo'];
            $idLivro = $_POST['idLivro'];
            $emprestimo = new EmprestimoDao();            
            $result = $emprestimo->devolver($idEmprestimo,$idLivro);

            var_dump($result);
            if($result){
               echo"<script>
                    alert('livro devolvido com sucesso');
                    window.location.href= '../View/Adm/Emprestimosconfirmados.php';                   
                    </script>";
            }else{
                echo"<script>
                    alert('Erro ao fazer devolução de livro');
                    window.location.href= '../View/Adm/Emprestimosconfirmados.php';                   
                    </script>";
            }
         }

         if(isset($_POST['confirmar'])){
            $idEmprestimo = $_POST['idEmprestimo'];
            $idLivro = $_POST['idLivro'];
            $emprestimo = new EmprestimoDao(); 
            $result = $emprestimo->confirmEmprestimo($idEmprestimo,$idLivro);

            if($result){
               echo"
                  <script>
                    alert('Confirmação concluida');
                    window.location.href= '../View/Adm/Emprestimosconfirmados.php';                   
                  </script>";
               ;
            }else{
               echo"<script>
                    alert('Erro ao Confirmar emprestimo');
                    window.location.href= '../View/Adm/EmprestimosPendentes.php';                   
                    </script>";
            }
         }

         if(isset($_POST['cancelar'])){
            $idEmprestimo = $_POST['idEmprestimo'];
            $emprestimo = new EmprestimoDao();
            $result = $emprestimo->cancelEmprestimo($idEmprestimo);
            
            if($result){
               echo"
                  <script>
                    alert('Cancelamento concluido');
                    window.location.href= '../View/Adm/Emprestimosconfirmados.php';                   
                  </script>";
               ;
            }else{
               echo"<script>
                    alert('Erro ao cancelar emprestimo');
                    window.location.href= '../View/Adm/EmprestimosPendentes.php';                   
                    </script>";
            }

         }
    }
   
?>