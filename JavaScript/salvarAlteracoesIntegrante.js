const form = document.querySelector("#formulario");

form.onsubmit = (event) => {
    event.preventDefault();

    const validacao = validaIntegrante(form.nome, form.cargo, form.imagem)

    if(!validacao){
        return;
    }

    const loader = document.querySelector("#loaderEnviar");

    loader.classList.remove("display-none");

    const httpService = new HttpService();

    httpService.postFormulario(form, 'back-end/editaIntegrante.php')
    .then( () => {
        loader.classList.add("display-none");

        location.href = 'Admin-formCadastroIntegrante.php';
    })
    .catch( () => {
        loader.classList.add("display-none");

        new MensagemLateralService("Erro ao editar integrante.");
    });

}


function validaIntegrante(campoNome, campoCargo, campoImagem)
{
    let nome = campoNome.value;
    let cargo = campoCargo.value;
    let imagem = campoImagem.files[0];

    //Faz essa validação, pois se colocarmos apenas required no campo, se eu preencher com espaços vazios acaba passando
    if(nome.trim().length == 0){
        abrirMensagemDeErroDoInput(campoNome, "Preencha o nome.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoNome);
    

    if(cargo == 'SELECIONAR'){
        abrirMensagemDeErroDoInput(campoCargo, "Informe o cargo.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoCargo);


    try{
        ImagemService.validaImagem(imagem);
        fecharMensagemDeErroDoInput(campoImagem);
    }catch(e){

        if(e.message == 'imagem_muito_grande'){
            abrirMensagemDeErroDoInput(campoImagem, "Imagem muito grande.");
            return false;
        }

        if(e.message == 'extensao_de_imagem_invalida'){
            abrirMensagemDeErroDoInput(campoImagem, "Imagem inválida.");
            return false;
        }
    }
        
    return true;
}

function abrirMensagemDeErroDoInput(input, mensagem){
    input.focus();

    let msgErro = document.querySelector(`#msgErro-${input.name}`);
    msgErro.classList.remove('display-none');
    msgErro.innerHTML = mensagem;
}

function fecharMensagemDeErroDoInput(input){
    let msgErro = document.querySelector(`#msgErro-${input.name}`);
    msgErro.classList.add('display-none');
    msgErro.innerHTML = "";
}

