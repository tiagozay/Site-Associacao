var divsTitulosNoticias = document.getElementsByClassName("nomeNoticia");
var divsNomesUsuario = document.getElementsByClassName("divNomeUsuario")

var textosIniciaisTitulosNoticias = []
pegaOsTextosIniciaisEJogaNoArray(textosIniciaisTitulosNoticias, divsTitulosNoticias)

var textosIniciaisNomesUsuarios = []
pegaOsTextosIniciaisEJogaNoArray(textosIniciaisNomesUsuarios, divsNomesUsuario)


var listaEmQueOUsuarioEsta = 'noticias';

mudarDeTamanho();

function mudarDeTamanho(){
    //===================VOLTAR TAMANHO DO MENU DE AÇÕES PARA O NORMAL AO AUMENTAR TELA===================//
    var btns = document.querySelectorAll(".btnAcoes")
    if(window.innerWidth > 600){
        for(let i = 0; i < btns.length; i++){
            btns[i].classList.remove("abrirMenu")
        }
        btns[3].classList.remove("gerarBordaNoUltimoBotao")
    }
        
    //===================OCULTAR CONTAINER E MODAL DA TELA===================//
    if(window.innerWidth > 730){
        if(indicador == true){
            fecharMenu()
        }

    }
    


    //===================CONDIÇÕES PARA LISTA DE NOTÍCIAS===================//
    if(window.innerWidth < 1171 && window.innerWidth > 1061){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 50)
    }else if(window.innerWidth < 1061 && window.innerWidth > 1031){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 45)
    }else if(window.innerWidth < 1031 && window.innerWidth > 751){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 35)
    }else if(window.innerWidth < 751 && window.innerWidth > 401){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 30)
    }else if(window.innerWidth < 401){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 20)
    }

    if(window.innerWidth > 1170){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 55)
    }else if(window.innerWidth > 1060 && window.innerWidth < 1170){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 50)
    }else if(window.innerWidth > 1030 && window.innerWidth < 1060){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 45)
    }else if(window.innerWidth > 750 && window.innerWidth < 1030){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 35)
    }else if(window.innerWidth > 400 && window.innerWidth < 750){
        alterarTamanhoDosTextos(divsTitulosNoticias, textosIniciaisTitulosNoticias, 30)
    }
    
}


window.onresize = () =>{
    mudarDeTamanho()
}

function pegaOsTextosIniciaisEJogaNoArray(array, divs){
    var quantidadeDeRegistros = divs.length;
    for(let i = 0; i < quantidadeDeRegistros; i++){
        array.push(divs[i].innerHTML)
    }
}


function alterarTamanhoDosTextos(divs, textosIniciais, tamahoDoTexto){
    var quantidadeDeRegistros = divs.length;
    for(let i = 0; i < quantidadeDeRegistros; i++){
        if(textosIniciais[i].length > tamahoDoTexto){
            divs[i].innerHTML = textosIniciais[i].substr(0, tamahoDoTexto)+"...";
        }else{
            divs[i].innerHTML = textosIniciais[i];
        }

    }
}