<?php
    
    session_start();

    //se tiver sessao de usuario registrada
    if(@$_SESSION["login"]==""){
        //mensagem de erro 
        $mensagem='Voce n&atilde;o efetuou o login.';
        header('Location:erro.php?msg='.$mensagem);
        exit();
    }
?>