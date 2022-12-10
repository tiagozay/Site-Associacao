<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar senha</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/alterarNomeESenhaUsuario.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">

</head>
<body>
    <main>
        <form id="formulario">
            <label for="inputSenhaAntiga">
                Digite sua senha atual
                <div class="divInputSenha">
                    <input type="password" class="inputSenha" data-pagina='alterarNomeOuSenha' id='inputSenhaAntiga' name="senha">
                    <img src="assets/icons/eyePreto - .svg" onclick="exibirOuOcultarSenha('inputSenhaAntiga')">
                </div>
                <p class="error display-none" id="msgErro-senha"></p>
            </label>

            <label for="inputSenhaNova">
                Digite sua senha nova
                <div class="divInputSenha">
                    <input type="password" class="inputSenha" data-pagina='alterarNomeOuSenha' id='inputSenhaNova' name="senhaNova">
                    <img src="assets/icons/eyePreto - .svg" onclick="exibirOuOcultarSenha('inputSenhaNova')">
                </div>
                <p class="error display-none" id="msgErro-senhaNova"></p>

            </label>

            <label for="inputSenhaNovaC" class="terceiroInputSenha"> 
                Confirme sua senha nova
                <div class="divInputSenha">
                    <input type="password" class="inputSenha" data-pagina='alterarNomeOuSenha' id='inputSenhaNovaC' name="confSenhaNova">
                    <img src="assets/icons/eyePreto - .svg" onclick="exibirOuOcultarSenha('inputSenhaNovaC')">
                </div>
                <p class="error display-none" id="msgErro-confSenhaNova"></p>
                
            </label>
                  
            <button type="submit" class="btnEnviar">
                CONFIRMAR
                <div class="display-none" id="loader"></div>
            </button>
        </form>
    </main>
    <script src="JavaScript/exibirOuOcultarSenhaInput.js"></script>
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>

    <script>
        const form = document.querySelector("#formulario");
        const loader = document.querySelector("#loader");

        form.onsubmit = async (event) => {
            event.preventDefault();

            let validacao = validaForm(
                form.senha, 
                form.senhaNova,
                form.confSenhaNova,
            );

            if(!validacao){
                return;
            }

            let formData = new FormData(form);

            const httpService = new HttpService();

            try{
                loader.classList.remove("display-none");

                let res = await httpService.postFormulario(
                    formData,
                    'back-end/editarSenhaUsuario.php'
                );

                loader.classList.add("display-none");

                location.href = "login.php";
            
            }catch(e){
                console.log(e);

                loader.classList.add("display-none");

                if(e.message == "Senha inválida"){
                    abrirMensagemDeErroDoInput(form.senha, "Senha incorreta");
                    return;
                }
                fecharMensagemDeErroDoInput(campoSenha);

                
                new MensagemLateralService("Erro ao editar nome.");
            }



        }

        function validaForm(campoSenha, campoSenhaNova, campoConfSenhaNova){
            let senha = campoSenha.value.trim();
            let senhaNova = campoSenhaNova.value.trim();
            let confSenhaNova = campoConfSenhaNova.value.trim();
            

            if(senha.length == 0){
                abrirMensagemDeErroDoInput(campoSenha, "Informe sua senha.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoSenha);

            if(senha.length < 8 || senha.length > 200){
                abrirMensagemDeErroDoInput(campoSenha, "Senha inválida.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoSenha);

            
            if(senhaNova.length == 0 || senhaNova.length < 8 || senhaNova.length > 200){
                abrirMensagemDeErroDoInput(campoSenhaNova, "Senha inválida.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoSenhaNova);

            if(confSenhaNova.length == 0 || confSenhaNova.length < 8 || confSenhaNova.length > 200){
                abrirMensagemDeErroDoInput(campoConfSenhaNova, "Senha inválida.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoConfSenhaNova);

            if(senhaNova != confSenhaNova){
                abrirMensagemDeErroDoInput(campoConfSenhaNova, "As senhas não coincidem!");
                return false;
            }
            fecharMensagemDeErroDoInput(campoConfSenhaNova);

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
    </script>

</body>
</html>