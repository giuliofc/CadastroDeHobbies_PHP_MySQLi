<?php
    //inicia a sessao 
    session_start();

    //verificar se o formulario foi enviado
    if((@$_POST["login"])!="" && (@$_POST["senha"])!="" ){
        //carrega informações de banco 
        include("config.php");
        include("connection.php");
        include("database.php");

        $usuario=array();
        $usuario=DBRead('usuario', "WHERE login='".$_POST["login"]."' AND senha='".md5($_POST['senha'])."'", 'login, senha'); 

        if(@$usuario){
            //registrar a sessao 
            $_SESSION["login"]=$_POST["login"];
            header('Location:controle.php');
        } else{
            $msg="Login ou Senha não conferem!!";
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <title>Login</title>

        <?php 
            echo '<link rel="stylesheet" type="text/css" href="css/styleTelaLogin.css">'; 
        ?>

    </head>

<body id="bodyLogin">

    <div id="divMenuLogin">
                <div id="divImg">
                    <img src="imagens/logotipo.png">
                </div>
      
                <div id="divNomeDoPrograma">
                    <p>Login no Sistema Controle de Hobbies</p>
                </div>
    </div>
    
    <br>
    <br>
    <br>
    <div id="divLogin">
        <div id="divPrincipalLogin">
            <?php
                if(@$msg!=""){
                    echo "<h1 style='color:#F00'>$msg</h1>\n";
                    echo "<hr>";
                }
            ?>

            <table>    
                <form name="form1" method="post" action="">
                    <tr>
                        <td class="textRight" >Login: </td>
                        <td>
                            <label>
                                <input type="text" name="login" id="login" />
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="textRight" >Senha: </td>
                        <td>
                            <label>
                                <input type="password" name="senha" id="senha" />
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <br>
                            <br>
                            <label>
                                <div id="divBotoes">
                                    <input id="inpCadastrar" type="submit" name="enviar" id="enviar" value="Enviar" />&nbsp;&nbsp;
                                    <input id="inpLimpar" type="reset" name="limpar" id="limpar" value="Limpar" />
                                </div>
                            </label>
                        </td>
                    </tr>
                </form>
            </table>

            <!--mensagem de logout, vem da pagina logout -->
            <h3>
                <?php
                    echo addslashes(mb_convert_encoding(@$_GET["msg"], "iso-8859-1", "utf-8"));
                ?>
            </h3>

        </div> <!--fim do divPrincipalLogin-->
    </div> <!--fim do div login-->

</body>
</html>