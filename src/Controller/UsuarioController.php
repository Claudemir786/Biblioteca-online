<?php 
 require '../Model/Usuario.php';
 require '../Model/Livro.php';
 require '../Dao/ConnectionFactory.php';
 require '../Dao/UsuarioDao.php';
 
  

 if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['criar'])){

        $usuario = new Usuario();
        $usuarioDao = new UsuarioDao();

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
            echo" <script>alert('Erro ao criar conta'); 
            </script>";
        }
    
      
    }

   
 }

 if($_SERVER["REQUEST_METHOD"] == "GET"){
    
    if(isset($_GET['logar'])){

        $usuario = new Usuario;
        $usuarioDao = new UsuarioDao();

        $usuario ->setEmail($_GET['email']);
        $usuario ->setSenha($_GET['password']);
        $usuarioEncontrado = $usuarioDao->logar($usuario);       
       
        if($usuarioEncontrado != 0 ){

            echo" <script>alert('Olá $usuarioEncontrado'); 
            window.location.href = '../View/TelaInicial.php';</script>";

        }else{
            echo" <script>alert('Erro ao criar conta'); 
            </script>";
        }


    }
 }
?>