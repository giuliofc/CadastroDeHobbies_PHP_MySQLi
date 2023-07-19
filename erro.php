<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <title>Erro</title>
    </head>
<body>
    
    <h1>Atenção</h1>
    <hr/>
    <h1 style="color:#F00">
        <?php
            echo addslashes(mb_convert_encoding(@$_GET["msg"], "iso-8859-1", "utf-8"));
        ?>
    </h1>
    <hr/>
    <p><a href="login.php">Login</a></p>

</body>
</html>