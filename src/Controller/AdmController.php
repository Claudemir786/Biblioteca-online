<?php 

    require_once __DIR__ . '/../Model/Livro.php';   
   
    require_once __DIR__.'/../Model/Usuario.php';
    require_once __DIR__ .'/../Dao/ConnectionFactory.php';
    require_once __DIR__.'/../Dao/UsuarioDao.php';
    require_once __DIR__.'/../Dao/LivroDao.php';
    require_once __DIR__.'/../Dao/EmprestimoDao.php';
    require_once __DIR__.'/../Model/EmprestimoCNome.php';
   

    function usuarios($nome){      
      $nomeDao = new UsuarioDao();
      $usuarios = $nomeDao->buscarUsuario($nome);#busca usuario     
      if($usuarios){
          $emprestimo = new EmprestimoDao();
         $usuarioObj = $emprestimo->dadosUser($usuarios);
        
         if($usuarioObj){
            foreach($usuarioObj as $linha){
                  echo"<tr>                            
                        <td>{$linha->getNomeUsuario()} {$linha->getSobrenome()}</td>
                        <td id=pend>{$linha->getPendente()}</td>
                        <td id=at>{$linha->getAtivo()}</td>                      
                        <td>
                           <form action='#' method='get'>
                           <input type='hidden' name='idUsuario' value='{$linha->getIdUsuario()}'>                                                                                                            
                           <input type='submit' class='btn btn-info'  name='detalhes' value='Detalhes'>
                           </form>
                                                   
                        </td>                                                                           
                     </tr>
                       
                     ";

            }
            
         }else{
            echo"<h4 class='text-center'>Usuário não encontrado</h4>";
         }
         }else{      
            echo"<h4 class='text-center'>Usuário não encontrado</h4>";
         }
   }
    
    function detalhes($id){
      $idU = $id;
      $emprestimoDao = new EmprestimoDao();
      $result = $emprestimoDao->detalhesEmprestimo($idU); 
      
      if($result){
          echo" <tr><td><div><h5>Livros Emprestados</h5>";
        foreach($result as $emprestimoObj){#emprestimos ativos
            if($emprestimoObj->getAtivo() == 1 && $emprestimoObj->getPendente() == 0){# verifica se o emprestimo está ativo
                 echo"
                 <ul class='list-unstyled'>
                     <li class='d-flex justify-content-between align-items-center mb-2'>
                        <span>{$emprestimoObj->getNomeLivro()}</span>
                        <form action='../../Controller/AdmController.php' method='post' class='d-flex gap-2'>
                              <input type='hidden' value='{$emprestimoObj->getId()}' name='idEmprestimo'>
                              <input type='hidden' value='{$emprestimoObj->getIdLivro()}' name='idLivro'>
                           <input type='submit' class='btn' name='devolver' style='background-color: #06355e;color:#fff;' value='Devolver'>
                        </form>
                     </li>
            ";
            }          
        }                                    
        echo"
         <h5>Livros Pendentes</h5>
         <li class='d-flex justify-content-between align-items-center mb-2'>
        "; 
        foreach($result as $emprestimoObj){# emprestimos pendentes
          if($emprestimoObj->getAtivo() == 0 && $emprestimoObj->getPendente() == 0){#verifica se o emprestimo está pendente(aguardando a aprovação)
         echo"
          <span>{$emprestimoObj->getNomeLivro()}</span>
                                 <form action='../../Controller/AdmController.php' method='post' class='d-flex gap-2'>
                                   <input type='hidden' value='{$emprestimoObj->getId()}' name='idEmprestimo'>
                                   <input type='hidden' value='{$emprestimoObj->getIdLivro()}' name='idLivro'>
                                    <input type='submit' class='btn  btn-info' name='confirmar' value='Confirmar'>
                                 </form>
                              </li>
                        </ul>
                     </div>
                  </td>
                           
            </tr>
         ";
          }
        }    
      }else{
         echo"<h4 class='text-center'>Não há informações deste usuário</h4>";
      }               
                      
                                
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
         echo"<h4 class='text-center'>Sem livros pendentes no momento</h4>";
      }
    }
    
    
    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        
         if(isset($_POST['devolver'])){
            $idEmprestimo = $_POST['idEmprestimo'];
            $idLivro = $_POST['idLivro'];
            $emprestimo = new EmprestimoDao();            
            $result = $emprestimo->devolver($idEmprestimo,$idLivro);

            
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