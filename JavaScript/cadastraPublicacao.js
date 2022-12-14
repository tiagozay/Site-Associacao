const formulario = document.querySelector("#formulario");

async function cadastra()
{
    let formData = new FormData(formulario);

    const validacao = validaPublicacao(
        formulario.titulo,
        formulario.data, 
        formulario.texto,
        document.querySelectorAll(".inputVideo"),
        formulario.capa,
        formulario.imagens,
        formulario.permitirComentarios,
        formulario.permitirCurtidas,
    );

    if(!validacao){
        return;
    }

    let loader = document.querySelector("#loaderCadastrarPublicacao");

    loader.classList.remove("display-none");

    const capaDiminuida = await ImagemService.diminuiTamanhoDeImagem(800, formulario.capa.files[0]);

    const imagensDiminuidas = await ImagemService.diminuiTamanhoDeImagens(800, formulario.imagens.files);

    formData.set('capa', capaDiminuida);

    if(formulario.imagens.files.length > 0){
        formData.delete('imagens[]');

        imagensDiminuidas.forEach( imagem => {
            formData.append('imagens[]', imagem);
        } );
    }
   

    const httpService = new HttpService();

    try{
        let res = await httpService.postFormulario(formData, 'back-end/cadastraPublicacao.php');

        let idPublicacaoInserida = await res.text();
    
        formulario.reset();

        loader.classList.add("display-none");

        location.href = `publicacao.php?id=${idPublicacaoInserida}`;

    }catch(e){
        loader.classList.add("display-none");

        new MensagemLateralService("Não foi possível adicionar publicação.");
    }

}

formulario.onsubmit = (event) => {

    event.preventDefault();

    cadastra();

}

function validaPublicacao(campoTitulo, campoData, campoTexto, camposVideos, campoCapa, campoImagens, campoPermitirComentarios, campoPermitirCurtidas)
{
    let titulo = campoTitulo.value;
    let data = campoData.value;
    let texto = campoTexto.value;
    let capa = campoCapa.files[0];
    let imagens = campoImagens.files;
    let permitirComentarios = campoPermitirComentarios.checked;
    let permitirCurtidas = campoPermitirCurtidas.checked;


    if(titulo.trim().length == 0){
        abrirMensagemDeErroDoInput(campoTitulo, "Informe o titulo.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoTitulo);

    if(!data){
        abrirMensagemDeErroDoInput(campoData, "Informe a data.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoData);


    const regExp = new RegExp(/<iframe.+src=".+".+>/, 'i');

    for(let i = 0; i < camposVideos.length; i++){

        if(!regExp.test(camposVideos[i].value)){
            abrirMensagemDeErroDoInput(camposVideos[i], "Vídeo inválido.");
            return false;
        }else{
            fecharMensagemDeErroDoInput(camposVideos[i]);
        }

    }

    
    //Chama a função valida imagem da ImagemService. A mesma lança um erro caso algo esteja incorreto passando o tipo do erro, aí no catch pego ele e chamo a função correspondente de cada mensagem de erro que deve aparecer no input. Caso não tenha erros, as mensagens de erro (caso existam), serão removidas
    try{
        ImagemService.validaImagem(capa);
        fecharMensagemDeErroDoInput(campoCapa);
    }catch(e){

        let errors = {
            'imagem_nao_informada' : () => {
                abrirMensagemDeErroDoInput(campoCapa, "Informe uma capa.");  
            },
            'imagem_muito_grande' : () => {
                abrirMensagemDeErroDoInput(campoCapa, "Imagem muito grande.");
            },
            'extensao_de_imagem_invalida' : () =>  {
                abrirMensagemDeErroDoInput(campoCapa, "Imagem inválida.");
            }
        };

        errors[e.message]();

        return false;

    }


    for(let i = 0; i < imagens.length; i++){

        try{
            ImagemService.validaImagem(imagens[0]);
            fecharMensagemDeErroDoInput(campoImagens);
        }catch(e){

            if(e.message == 'imagem_muito_grande'){
                abrirMensagemDeErroDoInput(campoImagens, "Uma das imagens informadas é muito grande.");
                return false;
            }

            if(e.message == 'extensao_de_imagem_invalida'){
                abrirMensagemDeErroDoInput(campoImagens, "Uma das imagens informadas é inválida.");
                return false;
            }
    
        }

    }

    return true;
}

function abrirMensagemDeErroDoInput(input, mensagem){
    input.focus();

    let msgErro = document.getElementById(`msgErro-${input.name}`);
    msgErro.classList.remove('display-none');
    msgErro.innerHTML = mensagem;
}

function fecharMensagemDeErroDoInput(input){
    let msgErro = document.getElementById(`msgErro-${input.name}`);
    msgErro.classList.add('display-none');
    msgErro.innerHTML = "";
}