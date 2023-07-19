

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Controle</title>

        <?php 
            echo '<link rel="stylesheet" type="text/css" href="css/estilo.css">'; 
            echo '<script src="javascript/JavaScript.js"> </script>';
        ?>
        
        <?php
            include("logado.php");

            require 'config.php';
            require 'connection.php';
            require 'database.php';
            require 'acao.php';
        ?>
    
        <script>    
            if(typeof window.history.pushState == 'function') {
                window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
            }
        </script>
    
    </head>
    
    <body id="bodyIndex" onload="qualDivAcender('<?=@$divAceso;?>')"> 
       
        <!-- Inicio da tela Menu -->
        <div id="divMenu">
                <div id="divImg">
                    <img src="imagens/logotipo.png">
                </div>
      
                <div id="divNomeDoPrograma">
                    <p>Controle de Hobbies</p>
                </div>
                
                <div id="divLinksMenu">
                    <span id="spanCadastro"><a href="" onclick="visualizarCadastro();">Cadastro</a></span> | 
                    <span id="spanListar"><a href="#listar" onclick="telaListar();"> Listar </a></span> | 
                    <span id="spanPesquisar"><a href="#pesquisar" onclick="visualizarDivPesquisar();"> Pesquisar </a></span> | 
                    <span id="spanExcluir"><a href="#Excluir" onclick="visualizarDivExcluir();"> Excluir </a></span> | 
                    <span id="spanLogout"><a href="logout.php"> Logout </a></span>
                </div>
        </div>  <!-- Fim da tela Menu -->
        
        
        <!--    Inicio da tela Produto   --> 
        <div id="divProduto" style="display:block">
            <div id="divPrincipalProduto">
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dados do Hobbie</span>
                <div id="divForm1">
                    <form id="formCadastro" name="formCadastro" action="" method="post" enctype="multipart/form-data" target="_self"> 
                        <input type="hidden" name="acao" value="cadastrar"/> <!--//para identificar o formulario no servlet -->
                        <input type="hidden" name="inpCod" value="<?=@$pessoaHobbie[0]['codPessoaHobbie'];?>"/> <!--em caso de edição este campo receberá valor-->                   
                        
                        <table id="tblCadastro">
                            <tr>
                                <td>
                                    <table id="tblCamposCadastro">
                                        <tr>
                                            <td id="tdNome" class="textRight"><span>Nome:</span></td>
                                            <td><input id="inpNome" type="text" name="inpNome" 
                                            value="<?=@$pessoaHobbie[0]['nomePessoa'];?>" size="30" maxlength="50" onblur="validarNome(formCadastro.inpNome);" onfocus="apagaCampos();"></td>
                                        </tr>
                                        <tr>
                                            <td id="tdHobbies" class="textRight"><span>Hobbies</span></td>
                                            <td>
                                                <select name="slHobbies[]" id="slHobbies" size="4" multiple onblur="validarSelect(formCadastro.slHobbies);"> 
                                                <?php
                                                    $arrayCombo= array(
                                                        'Leitura'=>'Leitura',
                                                        'Vídeo_Game'=>'Vídeo_Game',
                                                        'Corrida'=>'Corrida',
                                                        'Bicicleta'=>'Bicicleta',
                                                        'Dominó'=>'Dominó'
                                                    );

                                                    foreach ($arrayCombo as $key => $value): 
                                                        $selected = (in_array($key,  $arrayDeHobbiesDestaPessoa)) ?
                                                            "selected=\"selected\"" : null;  //para cada item do arrayCombo será verificado se o Key==valor do arrayDeHobbiesDestaPessoa. in_array é um laço de repetição que procura a $key por todas os valores do arrayDeHobbies
                                                        
                                                        echo "<option value=\"$key\"  $selected>$value</option>";    
                                                    endforeach;
                                                ?>

                                                <!--
                                                    <option value="Leitura">Leitura</option>
                                                    <option value="Video_Game">Video Game</option>
                                                    <option value="Malhação">Malhação</option>
                                                    <option value="Corrida">Corrida</option>
                                                    <option value="Bicicleta">Bicicleta</option>
                                                    <option value="Dominó">Dominó</option>
                                                -->
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <?php
                                                if(!empty($arrayDeHobbiesDestaPessoa)){  //se o array nao for vazio
                                                    
                                                    $hobbieQueNaoEstaNaLista="";
                                                    foreach ($arrayDeHobbiesDestaPessoa as $key => $value){
                                                        $hobbieQueNaoEstaNaLista.=(in_array($value,$arrayCombo))? "" : $value." ";
                                                        //se um valor do arrayDeHobbies não estiver no arrayCombo, então salve este valor no $hobbieQueNaoEstaNaLista
                                                    }
                                                }
                                            ?>
                                            <td class="textRight"></td>
                                            <td>
                                                <label for="huey">Seu hobbie estava na lista?</label><br>
                                                
                                                <input type="radio" name="rdHobbie" id="simEstava" value="simEstavaNaLista" checked onclick="radioCheck(this.value)"/>Sim 
                                                
                                                <input type="radio" name="rdHobbie" id="naoEstava" value="naoEstavaNaLista" onclick="radioCheck(this.value)" 
                                                <?=(!empty($hobbieQueNaoEstaNaLista)) ? "checked" : null;?>
                                                />Não   <!--se hobbieQueNao não for vazio entao imprime "checked"-->    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="tdNovoHobbie" class="textRight"><span id="spNovoHobbie" style="display:none;">Novo Hobbie:</span></td>
                                
                                            <td><input id="inpNovoHobbie" type="text" style="display:none;" name="inpNovoHobbie" value="<?=$hobbieQueNaoEstaNaLista?>" size="30" maxlength="25" onblur="verificarNovoHobbie(formCadastro.inpNovoHobbie.value);"></td>

                                            <?php
                                                if( !empty($hobbieQueNaoEstaNaLista) ){
                                                    echo "<script language='javascript' type='text/javascript'> 
                                                            radioCheck('naoEstavaNaLista');
                                                          </script>";  //para executar a função que acende display="block" os campos spNovoHobbie e inpNovoHobbie
                                                }
                                            ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>  
                
                <div style="margin:0px 0px 0px 110px;" class="">
                    <h4 id="mensagemResultadoFormCadastro"><?=@$mensagemResultadoFormCadastro;?></h4>
                </div>
            </div> <!-- fim do divPrincipalProduto -->
            
            <div id="divBotoes">
                <table>
                    <tr>
                        <td><input id="inpLimpar" type="button" value="Limpar" onclick="apagaCampos();"></td>
                    <!--    <td><input id="inpLimpar" type="reset" form="formCadastro" value="Limpar" onclick="apagaMensagem();"></td> -->
                        <td>&nbsp; &nbsp;</td>
                        <td><input type="button" id="inpCadastrar" value="Cadastrar" onclick="validarCampos(formCadastro);" ></td>
                    </tr>
                </table>
            </div>          
        

            <!--   Pesquisar Link  -->
            <div id="divPesquisar" style="display:none">
                <span>Pesquisar:</span> 
                <div id="divFormPesquisar">
                    <form id="formPesquisar" name="formPesquisar" action="" method="post" enctype="multipart/form-data" target="_self">
                        <input type="hidden" name="acao" value="pesquisar"/> 
                        <table>
                            <tr>
                                <td>Código:</td>
                                <td><input id="inpCodPesquisar" type="text" name="inpCodPesquisar" value="" size="30" maxlength="50" onblur="validarCodigoPesquisar(this.value);" />
                                </td>
                            </tr>
                            <tr>
                                <td>Nome:</td>
                                <td><input id="inpNomePesquisar" type="text" name="inpNomePesquisar" 
                                    value="" size="30" maxlength="50" onblur="contarpalavra(this.value);" />
                                </td>
                            </tr>   
                        </table>                           
                    </form>
                </div> <!--fim do divFormPesquisar-->  
                
                <div id="divBotoesPesquisar">
                    <table>
                        <tr>
                            <td><input id="inpLimparPesquisar" type="button" value="Limpar" onclick="apagaCamposPesquisar();"></td>
                        <!--    <td><input id="inpLimpar" type="reset" form="formCadastro" value="Limpar" onclick="apagaMensagem();"></td> -->
                            <td>&nbsp; &nbsp;</td>
                            <td><input type="button" id="inpPesquisar" value="Pesquisar" onclick="validarCamposPesquisar(formPesquisar);" ></td>
                        </tr>
                    </table>
                </div>

            </div> <!--fim do divPesquisar-->

    
            <!--   Excluir Link  -->
            <div id="divExcluir" style="display:none">
                <span>Excluir:</span> 
                <div id="divFormExcluir">
                    <form id="formExcluir" name="formExcluir" action="" method="post" enctype="multipart/form-data" target="_self">
                        <input type="hidden" name="acao" value="excluir"/> 
                        <table>
                            <tr>
                                <td>Código:</td>
                                <td><input id="inpCodExcluir" type="text" name="inpCodExcluir" value="" size="30" maxlength="50" onblur="validarCodigoPesquisar(this.value);" />
                                </td>
                            </tr>
                            <tr>
                                <td>Nome:</td>
                                <td><input id="inpNomeExcluir" type="text" name="inpNomeExcluir" 
                                    value="" size="30" maxlength="50" onblur="contarpalavra(this.value);" />
                                </td>
                            </tr>
                        </table>                            
                    </form>                                
                </div>  <!--fim do divFormExcluir-->                                  
            
                <div id="divBotoesExcluir">
                    <table>
                        <tr>
                            <td><input id="inpLimparExcluir" type="button" value="Limpar" onclick="apagaCamposExcluir();"></td> 
                            <td>&nbsp; &nbsp;</td>
                            <td><input type="button" id="inpExcluir" value="Excluir" onclick="validarCamposExcluir(formExcluir);" ></td>
                        </tr>                       
                    </table> 
                </div>                              

            </div> <!--fim do divExcluir-->                                        

        </div> <!--   fim da tela produto   -->


        <!--    Inicio da Tela Listar    -->
        <div id="divListar" style="display:none;">
            <div id="divTituloListar"><h3>Listar Hobbies</h3></div>
            
            <form id="formListar" name="formListar" action="" method="post" enctype="multipart/form-data" target="_self">
                <input type="hidden" name="acao" value="listar">
                <input id="btListar" type="submit" value="Listar Hobbies"/>
            </form>
            
            <div id="divMensagemTelaListar"><h4 id="mensagemResultadoListar"><?=@$mensagemTelaListar;?></h4></div>
            
            <table class="comBordas">
                <th>Id</th><th>Nome</th><th>Hobbies</th><th>Editar</th><th>Excluir</th>
                <?php 
                    if(@$arrayDePessoasHobbies){ //verifica se o array nao esta vazio
                        $fundo="#FFFFF0";        //variavel para cor do background
                        foreach($arrayDePessoasHobbies as $arr){  
                            
                            $fundo=($fundo=="#FFFFF0") ? "#f0cd9f" : "#FFFFF0"; //if para trocar a cor
                ?>
                            <tr style="background:<?=$fundo;?>"> 
                                <td><?=@$arr['codPessoaHobbie']?></td> <td><?=@$arr['nomePessoa']?></td> 
                                <td><?=@$arr['nomeHobbie']?></td> 
                                <td><a href='controle.php?acao=editar&id=<?=@$arr['codPessoaHobbie']?>'>Editar</a></td> 
                                <td><a href='controle.php?acao=deletar&id=<?=@$arr['codPessoaHobbie']?>' onclick="return  confirm('Deseja deletar este hobbie?')">Excluir</a></td>
                            </tr>
                <?php
                        } 
                    }  
                ?>
            </table>
        
        </div> <!--   fim da tela listar   --> 
           
    </body>
</html>
