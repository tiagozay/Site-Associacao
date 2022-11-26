const formulario = document.querySelector("#formulario");

const loader = document.querySelector("#loaderEditarPublicacao");

async function envia()
{

    let formData = new FormData(formulario);

    const validacao = validaPublicacao(
        formulario.titulo,
        formulario.data, 
        formulario.texto,
        document.querySelectorAll(".inputVideo"),
        formulario.capa,
        formulario.novasImagens,
        formulario.permitirComentarios,
        formulario.permitirLikes,
    );

    if(!validacao){
        return;
    }

    loader.classList.remove("display-none");

    if(formulario.capa.files[0]){
        let capaDiminuida = await ImagemService.diminuiTamanhoDeImagem(800, formulario.capa.files[0]);
        
        formData.set('capa', capaDiminuida);
    }

    if(formulario.novasImagens.files.length > 0){

        let imagensDiminuidas = await ImagemService.diminuiTamanhoDeImagens(800, formulario.novasImagens.files);

        formData.delete('novasImagens[]');

        imagensDiminuidas.forEach( imagem => {
            formData.append('novasImagens[]', imagem);
        } );
    }

    formData.set("imagensRestantes", JSON.stringify(publicacaoEditada['imagens']));

    formData.set("videosRestantes", JSON.stringify(publicacaoEditada['videos']));

    const httpService = new HttpService();

    try{
        let res = await httpService.postFormulario(formData, 'back-end/editaPublicacao.php');

        let txt = await res.text();

        console.log(txt);

        loader.classList.add("display-none");

    }catch(e){
        console.log(e);

        loader.classList.add("display-none");
        new MensagemLateralService("Não foi possível editar publicação.");
    }

    
}

formulario.onsubmit = (event) => {

    event.preventDefault();

    envia();

}

function excluirImagem(id)
{
    const confirmacao = confirm("Excluír esta imagem?");

    if(!confirmacao) return;

    const imagens = publicacaoEditada['imagens'];

    let imagem = imagens.find( (imagem) => imagem.id == id );

    let indice_imagem = imagens.indexOf(imagem);

    imagens.splice(indice_imagem, 1);

    let divImg = document.querySelector(`#divImg-${id}`);
    divImg.classList.add("fade-out");
    setTimeout( () => divImg.remove(), 250 );
}

function excluirVideo(id)
{
    const confirmacao = confirm("Excluír este video?");

    if(!confirmacao) return;

    const videos = publicacaoEditada['videos'];

    let video = videos.find( (video) => video.id == id );

    let indice_video = videos.indexOf(video);

    videos.splice(indice_video, 1);

    let divVideo = document.querySelector(`#divVideo-${id}`);
    divVideo.classList.add("fade-out");
    setTimeout( () => divVideo.remove(), 250 );
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

    
    //Chama a função valida imagem da ImagemService. A mesma lança um erro caso algo esteja incorreto passando o tipo do erro, aí no catch pego verifico e exibo a mensagem de erro que deve aparecer no input. Caso não tenha erros, as mensagens de erro (caso existam), serão removidas
    try{
        ImagemService.validaImagem(capa);
        fecharMensagemDeErroDoInput(campoCapa);
    }catch(e){

        if(e.message == 'imagem_muito_grande'){
            abrirMensagemDeErroDoInput(campoCapa, "Imagem muito grande.");
            return false;
        }

        if(e.message == 'extensao_de_imagem_invalida'){
            abrirMensagemDeErroDoInput(campoCapa, "Imagem inválida.");
            return false;
        }

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