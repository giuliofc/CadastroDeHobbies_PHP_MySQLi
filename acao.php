<?php 
    if(@$_POST["acao"]!="" || @$_GET["acao"]!=""){
        $acao=@$_POST["acao"];

        if(@$_GET["acao"]!=""){  //caso a variavel acao venha pela url 
            $acao=$_GET["acao"];
        }

        if(@$_POST["inpCod"]!=""){
            $acao="atualizar"; 
        }
 
        $divAceso="";

        switch ($acao) {
            case 'cadastrar':

                $hobbie=array(
                    'nomePessoa'  => $_POST["inpNome"],                                
                    'nomeHobbie'  => @$_POST["slHobbies"]
                );

                //se um novo hobbie foi digitado, adicione ele ao array 'nomeHobbie'
                if(@$_POST["inpNovoHobbie"]!="" && trim(@$_POST["inpNovoHobbie"], $charlist = " \t\n\r\0\x0B")){
                    
                    $hobbie["nomeHobbie"][]=$_POST["inpNovoHobbie"]; //adicionar no proximo indicide do array multidimencional o valor do inpNovoHobbie se houver
                }

                $stringDosHobbies='';
                foreach ($hobbie["nomeHobbie"] as $value) {
                    $stringDosHobbies.=$value.', ';
                }
                $stringDosHobbies = substr($stringDosHobbies, 0, -2); //para tirar o espaço em branco e a virgula do fim da string
                $hobbie["nomeHobbie"]=$stringDosHobbies; //para escrever uma string no lugar do array com os hobbies selecionados e digitados, antes da mandar pro banco de dados  
                                
                $novoId=DBCreate('hobbie',$hobbie, true);//true é opcional e seve p pedir para retornar o id deste novo cliente
                if($novoId)
                    $mensagemResultadoFormCadastro="Hobbie cadastrado com sucesso!"; 
                else
                    $mensagemResultadoFormCadastro="Não foi possivel cadastrar o hobbie!";
        
            break;
            
            
            case 'listar':

                //$arrayDePessoasHobbies=array(); //inicializa um array vazio
                $arrayDePessoasHobbies=DBRead('hobbie', null, 'codPessoaHobbie, nomePessoa, nomeHobbie');

                $divAceso="divListar";

                if(!$arrayDePessoasHobbies)
                    $mensagemTelaListar="Não foi possivel listar os hobbies!";
            break;


            case 'deletar':
               
                /*echo "<script language='javascript'>
                        var escolha=confirm('Deseja mesmo deletar?');
                      </script>";
                $escolha="<script>document.write(escolha)</script>";
                if($escolha==true){
                */

                if($_GET['id']!=""){
                    $dropHobbie=DBDelete('hobbie', 'WHERE codPessoaHobbie='.$_GET["id"].''); //lembrando que se não for passado a condição where o comando delete irá deletar toda a tabela. O retorno será uma mensagem de erro ou o id.
                    if($dropHobbie==0){
                        $mensagemResultadoFormCadastro="Hobbie foi excluido com sucesso!";
                    }
                    else 
                        $mensagemTelaListar=$dropHobbie; //em caso de erro, imprimi o erro
                }
            break;


            case 'editar':

                $pessoaHobbie=array();
                    
                $pessoaHobbie=DBRead('hobbie', 'WHERE codPessoaHobbie='.$_GET["id"].'', 'codPessoaHobbie, nomePessoa, nomeHobbie');  //o indice $pessoaHobbie[0] será um array q contem o array retorna da funcao DBReda

                $arrayDeHobbiesDestaPessoa=explode(", ", $pessoaHobbie[0]['nomeHobbie'] ); //explode salva em um array cada hobbie extraido da string usando como separação ", " 

                $divAceso="divCadastrar";

                if(!$pessoaHobbie)
                    $mensagemTelaListar="Não foi possivel listar os hobbies!";
            break;


            case 'atualizar':

                $hobbieEditado=array(
                    'codPessoaHobbie'=> $_POST['inpCod'],
                    'nomePessoa'     => $_POST["inpNome"],                                
                    'nomeHobbie'     => @$_POST["slHobbies"]
                );

                //se um novo hobbie foi digitado, adicione ele ao array 'nomeHobbie'
                if(@$_POST["inpNovoHobbie"]!="" && trim(@$_POST["inpNovoHobbie"], $charlist = " \t\n\r\0\x0B")){
                    
                    $hobbieEditado["nomeHobbie"][]=$_POST["inpNovoHobbie"]; //adicionar no proximo indicide do array multidimencional o valor do inpNovoHobbie se houver
                }

                $stringDosHobbies='';
                foreach ($hobbieEditado["nomeHobbie"] as $value) {
                    $stringDosHobbies.=$value.', ';
                }
                $stringDosHobbies = substr($stringDosHobbies, 0, -2); //para tirar o espaço em branco e a virgula do fim da string
                $hobbieEditado["nomeHobbie"]=$stringDosHobbies; //para escrever uma string no lugar do array com os hobbies selecionados e digitados, antes da mandar pro banco de dados  

                $idAtualizado=DBUpdate('hobbie', $hobbieEditado, "WHERE codPessoaHobbie=".$hobbieEditado['codPessoaHobbie'], true);
                //Lembrando que se não passar a condição where ele irá auterar para todos os clientes
                 
                if(!$idAtualizado)
                    $mensagemResultadoFormCadastro="Hobbie foi atualizado com sucesso!";
                else
                    $mensagemResultadoFormCadastro="Não foi possivel atualizar este hobbie!";

            break;


            case 'pesquisar':
                $codigoPesquisar=@$_POST['inpCodPesquisar'];
                $nomePesquisar=@$_POST['inpNomePesquisar'];

                if(!empty($codigoPesquisar)){
                   
                    $pessoaHobbie=array();
                    
                    $pessoaHobbie=DBRead('hobbie', 'WHERE codPessoaHobbie='.$codigoPesquisar.'', 'codPessoaHobbie, nomePessoa, nomeHobbie');  //o indice $pessoaHobbie[0] será um array q contem o array retorna da funcao DBReda

                    if($pessoaHobbie){ //se a pesquisa no banco não retornou false
                        $arrayDeHobbiesDestaPessoa=explode(", ", $pessoaHobbie[0]['nomeHobbie'] ); //explode salva em um array cada hobbie extraido da string usando como separação ", " 

                        $divAceso="divCadastrar";
                    }

                    if(!$pessoaHobbie)
                        $mensagemResultadoFormCadastro="Não foi possível escontrar este cadastro!";
                }
                else if(!empty($nomePesquisar)){
                    
                    $pessoaHobbie=array();
                    
                    $pessoaHobbie=DBRead('hobbie', 'WHERE nomePessoa=\''.$nomePesquisar.'\'', 'codPessoaHobbie, nomePessoa, nomeHobbie');  //o indice $pessoaHobbie[0] será um array q contem o array retorna da funcao DBReda

                    if($pessoaHobbie){ //se a pesquisa no banco não retornou false
                        $arrayDeHobbiesDestaPessoa=explode(", ", $pessoaHobbie[0]['nomeHobbie'] ); //explode salva em um array cada hobbie extraido da string usando como separação ", " 

                        $divAceso="divCadastrar";
                    }

                    if(!$pessoaHobbie)
                        $mensagemResultadoFormCadastro="Não foi possível escontrar este cadastro!";
                }
            break;


            case 'excluir':

                $codigoExcluir=@$_POST['inpCodExcluir'];
                $nomeExcluir=@$_POST['inpNomeExcluir'];

                if(!empty($codigoExcluir)){
                   
                    $pessoaHobbieVerificar=array();
                    
                    $pessoaHobbieVerificar=DBRead('hobbie', 'WHERE codPessoaHobbie='.$codigoExcluir.'', 'codPessoaHobbie, nomePessoa, nomeHobbie');  //o indice $pessoaHobbie[0] será um array q contem o array retorna da funcao DBReda

                    if($pessoaHobbieVerificar){ //se a pesquisa no banco não retornou false 

                        $divAceso="divCadastrar";

                        echo "<script language='javascript'> 

                            if( confirm('Deseja deletar este hobbie?  "
                                        .$pessoaHobbieVerificar[0]['nomePessoa'].
                                        " : "
                                        .$pessoaHobbieVerificar[0]['nomeHobbie']." ') ){
                                    
                                window.location.href ='controle.php?acao=deletar&id=".$codigoExcluir."';
                            }
                                       
                        </script>";
                        
                    }

                    if(!$pessoaHobbieVerificar)
                        $mensagemResultadoFormCadastro="Não foi possível escontrar este cadastro!";
                }
                else if(!empty($nomeExcluir)){
                    $pessoaHobbieVerificar=array();
                    
                    $pessoaHobbieVerificar=DBRead('hobbie', 'WHERE nomePessoa=\''.$nomeExcluir.'\'', 'codPessoaHobbie, nomePessoa, nomeHobbie');  //o indice $pessoaHobbie[0] será um array q contem o array retorna da funcao DBReda

                    if($pessoaHobbieVerificar){ //se a pesquisa no banco não retornou false 

                        $divAceso="divCadastrar";

                        echo "<script language='javascript'> 

                            if( confirm('Deseja deletar este hobbie?  "
                                        .$pessoaHobbieVerificar[0]['nomePessoa'].
                                        " : "
                                        .$pessoaHobbieVerificar[0]['nomeHobbie']." ') ){
                                    
                                window.location.href ='controle.php?acao=deletar&id=".$pessoaHobbieVerificar[0]['codPessoaHobbie']."';
                            }
                                       
                        </script>";
                        
                    }

                    if(!$pessoaHobbieVerificar)
                        $mensagemResultadoFormCadastro="Não foi possível escontrar este cadastro!";

                }

            /*  //Deletar dados  
            $dropCliente=DBDelete('cliente', 'WHERE id=3'); //lembrando que se não for passado a condição where o comando delete irá deletar toda a tabela, talvez devo fazer um alert para o usuario confirmar atenção.
            if($dropCliente)
                echo 'ok';
            else
                echo 'no';
            */

            break;


            default:
                # code...
                break;
        }
    }


?>