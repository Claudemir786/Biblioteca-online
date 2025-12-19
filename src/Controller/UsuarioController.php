<?php 
 require_once '../Model/Usuario.php';
 require_once '../Model/Livro.php';
 require_once '../Dao/ConnectionFactory.php';
 require_once '../Dao/UsuarioDao.php';
 
  

function menssagemErroLogin(){
     //volta para página de login levando uma variavel
    $UsuarioNEncontrado=1;
    header("location:../View/Login.php?usern=$UsuarioNEncontrado");
}

function menssagemErroCadastro(){
   echo" <script>alert('Erro ao criar conta');</script>";
            
}


 if($_SERVER["REQUEST_METHOD"] == "POST"){

    //CADASTRO DE USUÁRIO
    if(isset($_POST['criar'])){

        $usuario = new Usuario();
        $usuarioDao = new UsuarioDao();

        //verificando a senha 
          $senhaCadastro = $_POST['password'];
        
        if(strlen($senhaCadastro)<6){
            menssagemErroCadastro();

        }elseif(strlen($senhaCadastro)>15){
            menssagemErroCadastro();
            
        }else{

        $usuario ->setNome($_POST['nameUser']);
        $usuario ->setSobrenome($_POST['lastName']);
        $usuario ->setEmail($_POST['email']);
        $usuario ->setDataNascimento($_POST['age']);
        $usuario ->setSenha($_POST['password']);
        $result = $usuarioDao ->criar($usuario);
        
        if($result == 1){

            echo" <script>alert('Conta criada com sucesso {$usuario->getNome()}'); 
            window.location.href = '../View/Login.php';</script>";

        }else{
           menssagemErroCadastro();
        }    
    }
    }

     //LOGIN DE USUÁRIO 
     if(isset($_POST['logar'])){
        

        $usuariol = new Usuario;
        $usuarioDaol = new UsuarioDao();
        //verificando a senha
        $senha = $_POST['password'];
        
        if(strlen($senha)<6){
            menssagemErroLogin();

        }elseif(strlen($senha)>15){
            menssagemErroLogin();

        }else{

        $usuariol ->setEmail($_POST['email']);
        $usuariol ->setSenha($_POST['password']);        
        $usuarioEncontrado = $usuarioDaol->logar($usuariol);       

        #echo "resposta $usuarioEncontrado";
        
        if($usuarioEncontrado != 0 ){
            //exibe um alerta com o nome do usuario e logo depois é direcionado a pagina principal do projeto
            echo" <script>alert('Olá {$usuarioEncontrado['nome']}'); 
            window.location.href = '../View/TelaInicial.php?id={$usuarioEncontrado['id']}';</script>";

        }else{
           menssagemErroLogin();
        }
    }

}
    if(isset($_POST['delete'])){
        session_start();
        $idUsuario = $_SESSION['cod'];
        $usuarioDao = new UsuarioDao();
        $delete = $usuarioDao->delete($idUsuario);

        if($delete === 1){
            echo"<script>alert('Conta excluida com sucesso');
                        window.location.href = '../View/Index.php?id={$idUsuario}';
                </script>";

        }else{
            echo"<script>alert('Erro ao excluir conta');
                        window.location.href = '../View/TelaInicial.php?id={$idUsuario}';
                </script>";
        }      
    }

    if(isset($_POST['mudarNome'])){ 

        $usuarioD = new UsuarioDao();
        session_start();
        $id = $_SESSION['cod'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];

        $resultado = $usuarioD->alteraNome($id,$nome,$sobrenome);
        if($resultado == true){
            echo"<script>alert('Nome alterado com sucesso');
                        window.location.href = '../View/InfoConta.php';
                </script>";
        }else{
               echo"<script>alert('Falha ao alterar nome de usuario');
                        window.location.href = '../View/InfoConta.php';
                </script>";
        } 
           
    }
    if(isset($_POST['mudarEmail'])){

        $usuarioDao = new UsuarioDao();
        session_start();
        $id = $_SESSION['cod'];
        $email = $_POST['email'];

        $resultado = $usuarioDao->alteraEmail($id,$email);

        if($resultado == true){
             echo"<script>alert('Email alterado com sucesso');
                        window.location.href = '../View/InfoConta.php';
                </script>";
        }else{
             echo"<script>alert('Falha ao alterar email');
                        window.location.href = '../View/InfoConta.php';
                </script>";
        }
    }
 }
?>