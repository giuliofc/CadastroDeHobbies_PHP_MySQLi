<?php
    session_start();

    //exclui os dados de login
    unset($_SESSION["login"]);

    //elimina a sessao
    session_destroy();

    //enviando o usuario para pagina de login 
    header('Location:index.php?msg=Logout efetuado com sucesso!');

?>