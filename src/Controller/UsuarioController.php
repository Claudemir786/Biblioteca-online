<?php 
 require '../Model/Usuario.php';
 require '../Model/Livro.php';
 require '../Dao/ConnectionFactory.php';
 require '../Dao/UsuarioDao.php';
 
  

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


}


    
    
 


?>