const formularioCadastro = document.querySelector(".formularioDeCadastro");

formularioCadastro.onsubmit = (event) => {

    event.preventDefault();

    const validacao = validaUsuario(
        formularioCadastro.nome,
        formularioCadastro.email, 
        formularioCadastro.senha,
        formularioCadastro.confSenha
    );

    if(!validacao){
        return;
    }

    const httpService = new HttpService();

    let loader = document.querySelector("#loaderCadastrar");

    loader.classList.remove("display-none");

    httpService.postFormulario(formularioCadastro, 'back-end/cadastraUsuario.php')
    .then( () => {

        formularioCadastro.reset();

        loader.classList.add("display-none");
        
        location.href = "index.php";
    } )
    .catch( resposta => {

        loader.classList.add("display-none");

        if(resposta.message == 'usuario_ja_cadastrado'){
            abrirMensagemDeErroDoInput(formularioCadastro.email, "E-mail inválido ou já cadastrado.");
        }else{
            fecharMensagemDeErroDoInput(formularioCadastro.email);
        }
    } )

}

function validaUsuario(campoNome, campoEmail, campoSenha, campoConfSenha)
{
    let nome = campoNome.value;
    let email = campoEmail.value;
    let senha = campoSenha.value;
    let confSenha = campoConfSenha.value;

    if(nome.trim().length == 0){
        abrirMensagemDeErroDoInput(campoNome, "Informe seu nome.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoNome);

    if( nome.length < 3 || nome.length > 80){
        abrirMensagemDeErroDoInput(campoNome, "Tamanho do nome inválido!");
        return false;
    }
    fecharMensagemDeErroDoInput(campoNome);

    if(email.trim().length == 0){
        abrirMensagemDeErroDoInput(campoEmail, "Informe um e-mail.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoEmail);

    if(email.trim().length > 260){
        abrirMensagemDeErroDoInput(campoEmail, "E-mail inválido");
        return false;
    }
    fecharMensagemDeErroDoInput(campoEmail);

    if(senha.trim().length == 0){
        abrirMensagemDeErroDoInput(campoSenha, "Informe a senha.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoSenha);

    if(senha.trim().length < 8){
        abrirMensagemDeErroDoInput(campoSenha, "A senha deve conter no mínimo 8 caracteres.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoSenha);

    if(senha.trim().length > 200){
        abrirMensagemDeErroDoInput(campoSenha, "Senha inválida.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoSenha);

    if(confSenha.trim().length == 0){
        abrirMensagemDeErroDoInput(campoConfSenha, "Confirme a senha.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoConfSenha);

    if(confSenha != senha){
        abrirMensagemDeErroDoInput(campoConfSenha, "As senhas não coincidem.");
        return false;
    }
    fecharMensagemDeErroDoInput(campoConfSenha);

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