function qualDivAcender(div){
    if(div==""){
        
    }

    if(div=="divCadastrar"){
        visualizarCadastro();
    }
        
    if(div=="divListar"){
        telaListar();
    }
    
}


//----- Tela Menu ------
function visualizarCadastro(){
    var telaProduto=document.getElementById("divProduto");
    telaProduto.style.display="block";
    var telaListar=document.getElementById("divListar");
    telaListar.style.display="none";  //apaga os div de outras telas
    var divPesquisar=document.getElementById("divPesquisar");
    divPesquisar.style.display="none";
    var divExcluir=document.getElementById("divExcluir");
    divExcluir.style.display="none";
    
    var spanCadastro=document.getElementById("spanCadastro");
    spanCadastro.style.fontWeight="bold";
    var spanListar=document.getElementById("spanListar");
    spanListar.style.fontWeight="normal";
    var spanPesquisar=document.getElementById("spanPesquisar");
    spanPesquisar.style.fontWeight="normal";
    var spanExcluir=document.getElementById("spanExcluir");
    spanExcluir.style.fontWeight="normal";
}

function telaListar(){
    var telaProduto=document.getElementById("divProduto");
    telaProduto.style.display="none";
    var telaListar=document.getElementById("divListar");
    telaListar.style.display="block";  
    var divPesquisar=document.getElementById("divPesquisar");
    divPesquisar.style.display="none";
    var divExcluir=document.getElementById("divExcluir");
    divExcluir.style.display="none";
    
    var spanCadastro=document.getElementById("spanCadastro");
    spanCadastro.style.fontWeight="normal";
    var spanListar=document.getElementById("spanListar");
    spanListar.style.fontWeight="bold";
    var spanPesquisar=document.getElementById("spanPesquisar");
    spanPesquisar.style.fontWeight="normal";
    var spanExcluir=document.getElementById("spanExcluir");
    spanExcluir.style.fontWeight="normal";
}

function visualizarDivPesquisar(){
    var telaProduto=document.getElementById("divProduto");
    telaProduto.style.display="block";
    var telaListar=document.getElementById("divListar");
    telaListar.style.display="none";  //apaga os div de outras telas
    var divPesquisar=document.getElementById("divPesquisar");
    divPesquisar.style.display="block";
    var divExcluir=document.getElementById("divExcluir");
    divExcluir.style.display="none";
    
    var spanCadastro=document.getElementById("spanCadastro");
    spanCadastro.style.fontWeight="normal";
    var spanListar=document.getElementById("spanListar");
    spanListar.style.fontWeight="normal";
    var spanPesquisar=document.getElementById("spanPesquisar");
    spanPesquisar.style.fontWeight="bold";
    var spanExcluir=document.getElementById("spanExcluir");
    spanExcluir.style.fontWeight="normal";
}

function visualizarDivExcluir(){
    var telaProduto=document.getElementById("divProduto");
    telaProduto.style.display="block";
    var telaListar=document.getElementById("divListar");
    telaListar.style.display="none";  //apaga os div de outras telas
    var divPesquisar=document.getElementById("divPesquisar");
    divPesquisar.style.display="none";
    var divExcluir=document.getElementById("divExcluir");
    divExcluir.style.display="block";

    var spanCadastro=document.getElementById("spanCadastro");
    spanCadastro.style.fontWeight="normal";
    var spanListar=document.getElementById("spanListar");
    spanListar.style.fontWeight="normal";
    var spanPesquisar=document.getElementById("spanPesquisar");
    spanPesquisar.style.fontWeight="normal";
    var spanExcluir=document.getElementById("spanExcluir");
    spanExcluir.style.fontWeight="bold";
}


//---------- Tela Cadastrar ---------
function validarNome(field){ //ao tirar o foco do campo nome
    nome=field.value;
    if(nome == "" || !nome.trim()){  //!nome.trim() Se após remover espaços em 
                                     //branco a string está vazia
        alert("O nome não pode ser vazio ou em branco!");
    }
    else{
        contarpalavra(nome);
    }
}


function contarpalavra(valor){         
    var nome=valor.replace(/(\r\n|\n|\r)/g," ").trim(); //replace troca strings //trim retorna o texto sem os espaços em branco no inicio e fim 
    var array=nome.split(/\s+/g);  //divide um objeto String em um array de strings ao separar a string 
    var cont=array.length;
    
    if(cont<=1){
        alert("O nome deve ter no minimo duas palavras! ");
        return false;
    }else{
        return true;
    }
}


function validarSelect(comboHobbies){
    var selectedArray = new Array();
    var count=0;
    
    for (i = 0; i < comboHobbies.length; i++) {
        
        if (comboHobbies.options[i].selected) {
            selectedArray[count] = comboHobbies.options[i].value;
            count++;
        }
    }
    if(count==0){
        alert("É necessário selecionar pelo menos um hobbie!");
        return selectedArray;
    }
    else{
        return selectedArray;
    }
        
}  


function apagaCampos(){
    campoNome=document.getElementById("inpNome");
    campoNome.value="";
    
    document.getElementById("slHobbies").selectedIndex = -1;
    //OU 
    //var elements = document.getElementById("slHobbies").options;
    //for(var i = 0; i < elements.length; i++){
    //  elements[i].selected = false;
    //}
    
    document.getElementById("simEstava").checked = true;
    
    document.getElementById("inpNovoHobbie").value="";
    document.getElementById("inpNovoHobbie").style.display="none";
    
    document.getElementById("spNovoHobbie").style.display="none";

    document.getElementById("mensagemResultadoFormCadastro").innerHTML="";
}


function validarCampos(form){ //ao clicar no botao cadastrar
    var bConsistencia=false;
    var nome="", preco_venda=0.00, preco_custo=0.00, unidade="", categoria="";
    var arrayDeSelecoes = new Array();
    
    //Verifica campo Nome
    // <editor-fold defaultstate="collapsed" desc="Generated Code">
    if( !form.inpNome.value =="" && form.inpNome.value!=null && form.inpNome.value.length<=50){
       
        bConsistencia=contarpalavra(form.inpNome.value);
        
        if(bConsistencia){
            nome=form.inpNome.value;
        } 
    }
    else if(form.inpNome.value.length>50){
        alert("Campo Nome não pode ter mais de 50 caracteres!");
        bConsistencia=false;
        return;
    }
    else if(form.inpNome.value =="" || form.inpNome.value ==null){
        alert("Campo Nome não pode ser vazio!");
        bConsistencia=false;
        return;
    }
    // </editor-fold>
    
    if( document.getElementById("simEstava").checked ){
        
        //verificar campo select hobbies
        arrayDeSelecoes=validarSelect(form.slHobbies);
        if(arrayDeSelecoes.length!=0){
            bConsistencia=true;
        }   
        else{
            bConsistencia=false;
        } 
    }
    
    
    //verifica se botao radio "nao" esta selecionado
    if(document.getElementById("naoEstava").checked){
        bConsistencia=verificarNovoHobbie(form.inpNovoHobbie.value);
    }
    
    if(bConsistencia){
        document.formCadastro.submit();
    }
}


function radioCheck(value_rdHobbie){
    
    if(value_rdHobbie=="simEstavaNaLista"){
        document.getElementById("inpNovoHobbie").style.display="none";
        document.getElementById("spNovoHobbie").style.display="none";
    }
    if(value_rdHobbie=="naoEstavaNaLista"){
        document.getElementById("inpNovoHobbie").style.display="block";
        document.getElementById("spNovoHobbie").style.display="block";
    }
}


function verificarNovoHobbie(value_novoHobbie){
    
    if(value_novoHobbie=="" || !value_novoHobbie.trim()){  //!value_novoHobbie.trim() Se após remover espaços em 
                                                           //branco a string está vazia
        alert("O Novo Hobbie não pode ser vazio ou em branco!");
        return false;
    }
    
    cont=value_novoHobbie.length;
    if(cont<=1){
        alert("O Novo Hobbie deve ser no minimo 2 caracteres letras!");
        return false;
    }
    
    //var regExp=/abc/;  //site para fazer expressoes regulares https://regex101.com/r/vS7vZ3/224/tests
    //ou
    //var regExp=new RegExp("abc");
    //
    //var str="abc";
    //console.log(regExp.test(str)); //returna true ou false se a string for igual ao regExp 
    
    var regExp=/[^A-Za-z\x20áàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{1,}/; //[] fecha um grupo, 
                                    //^ negado, ou seja, não pode ter nada diferente do que os caractes 
                                    //que estao a frente do ^ 
                                    //A-Z todas as letras maiusculas 
                                    //a-z todas as letras minusculas
                                    //\x20 caracter espaço vazio
                                    //{min,max} quantitativo {1,} minimo 1 maximo infinito
                                    // /[^A-Za-z\x20]{1,}/ não pode ter caracteres que não sejam letra 
                                    // maiuscula ou minuscula e caracter espaço em branco
    if( regExp.test(value_novoHobbie) ){
        alert("O nome do novo hobbie só pode\nter letras e espaços!");
        return false;
    }
    
    return true;  
}

/*    PESQUISAR    */
function apagaCamposPesquisar(){
    document.getElementById("inpCodPesquisar").value="";
    document.getElementById("inpNomePesquisar").value="";
}

function validarCodigoPesquisar(valor){
    var regExp=/[^0-9]{1,}/; //^ negado, [0-9] conjunto de 0 a 9, {1,} intervalo de pelo menos 1 a infinito.
                             ///[^0-9]{1,} não pode ter nada diferente do que 0 a 9 . 

    if( regExp.test(valor) ){
        alert("O código só pode ter numeros inteiros!");
        return false;
    }
    else
        return true;
}

function validarCamposPesquisar(formPesquisar){
    var codigo=formPesquisar.inpCodPesquisar.value;
    var nome=formPesquisar.inpNomePesquisar.value;
    var consistencia=false;

    if( (codigo=="" || !codigo.trim()) && (nome=="" || !nome.trim()) )
        alert("É necessario preencher pelo menos um campo, código ou nome!")

    if(codigo!="" || codigo.trim())  //se codigo nao é vazio analizar
        consistencia=validarCodigoPesquisar(codigo);

    if(nome!="" || nome.trim()) //se nome nao é vazio analizar
        consistencia=contarpalavra(nome);
    
    if(consistencia){
        document.formPesquisar.submit();
    } 
}


function apagaCamposExcluir(){
    document.getElementById("inpCodExcluir").value="";
    document.getElementById("inpNomeExcluir").value="";
}

function validarCamposExcluir(formExcluir){
    var codigo=formExcluir.inpCodExcluir.value;
    var nome=formExcluir.inpNomeExcluir.value;
    var consistencia=false;

    if( (codigo=="" || !codigo.trim()) && (nome=="" || !nome.trim()) )
        alert("É necessario preencher pelo menos um campo, código ou nome!")

    if(codigo!="" || codigo.trim())  //se codigo nao é vazio analizar
        consistencia=validarCodigoPesquisar(codigo);

    if(nome!="" || nome.trim()) //se nome nao é vazio analizar
        consistencia=contarpalavra(nome);
    
    if(consistencia){
        document.formExcluir.submit();
    } 
}