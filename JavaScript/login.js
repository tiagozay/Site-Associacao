const formularioLogin = document.querySelector(".formularioDeLogin");

formularioLogin.onsubmit = (event) => {

    event.preventDefault();

    const validacao = validaUsuarioLogin(
        formularioLogin.email, 
        formularioLogin.senha
    );

    if(!validacao){
        return;
    }

    const httpService = new HttpService();

    let loader = document.querySelector("#loaderLogin");

    loader.classList.remove("display-none");

    httpService.postFormulario(formularioLogin, 'back-end/login.php')
    .then( () => {

        formularioLogin.reset();

        loader.classList.add("display-none");
        
        location.href = "index.php";
    } )
    .catch( resposta => {
        
        loader.classList.add("display-none");

        if(resposta.message == 'usuario_nao_encontrado' || resposta.message == 'senha_invalida'){
            abrirMensagemDeErroDoInputLogin(formularioLogin.email, "E-mail ou senha inválidos.");
            abrirMensagemDeErroDoInputLogin(formularioLogin.senha, "E-mail ou senha inválidos.");
        }

        if(resposta.message == 'quantidade_de_tentativas_excedida'){
            new MensagemLateralService("Quantidade de tentativas excedida.");
        }

    } );

}

function validaUsuarioLogin(campoEmail, campoSenha)
{
    let email = campoEmail.value;
    let senha = campoSenha.value;


    if(email.trim().length == 0){
        abrirMensagemDeErroDoInputLogin(campoEmail, "Informe um e-mail.");
        return false;
    }
    fecharMensagemDeErroDoInputLogin(campoEmail);

    if(email.trim().length > 260){
        abrirMensagemDeErroDoInputLogin(campoEmail, "E-mail inválido.");
        return false;
    }
    fecharMensagemDeErroDoInputLogin(campoEmail);

    if(senha.trim().length == 0){
        abrirMensagemDeErroDoInputLogin(campoSenha, "Informe a senha.");
        return false;
    }
    fecharMensagemDeErroDoInputLogin(campoSenha);

    if(senha.trim().length < 8){
        abrirMensagemDeErroDoInputLogin(campoSenha, "Senha inválida.");
        return false;
    }
    fecharMensagemDeErroDoInputLogin(campoSenha);

    if(senha.trim().length > 200){
        abrirMensagemDeErroDoInputLogin(campoSenha, "Senha inválida.");
        return false;
    }
    fecharMensagemDeErroDoInputLogin(campoSenha);


    return true;

}

function abrirMensagemDeErroDoInputLogin(input, mensagem){
    input.focus();

    let msgErro = document.querySelector(`#msgErroLogin-${input.name}`);
    msgErro.classList.remove('display-none');
    msgErro.innerHTML = mensagem;
}

function fecharMensagemDeErroDoInputLogin(input){
    let msgErro = document.querySelector(`#msgErroLogin-${input.name}`);
    msgErro.classList.add('display-none');
    msgErro.innerHTML = "";
}