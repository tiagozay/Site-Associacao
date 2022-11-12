<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/PagLoginCadastro/paginaDeCadastroOuLogin.css">
    <link rel="stylesheet" href="assets/styles/erros/errosFormularioDeCadastroELogin.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <title>Entre ou cadastre-se</title>
</head>
<body>
  
    <section class="sessionCentral">


        <div class="divSeletorLoginOuCadastro">
            <button class="btnLogin adcBordaNoBotao" onclick="mudarForm()">
                Entre
            </button>
            <button class="btnCadastro" onclick="mudarForm()">
                Criar conta
            </button>
        </div>

        <!-- Formulário de login -->
        <form action="src/recebeDoForm/recebeDadosDeLogin.php" method='POST' class="formularioDeLogin mostrarForm">
            <input type="text" name="email" placeholder="Email" autofocus="true" class="inputPadrao especamentoInputs" required>
 
            <div class="divInputSenha especamentoInputs">
                <input type="password" name="senha" placeholder="Senha" class="inputSenhaLogin inputSenha" id="inputSenhaLogin" required>
                <img src="assets/icons/eye.svg" onclick="exibirOuOcultarSenha('inputSenhaLogin')" alt="ícone ver senha" class="iconeVerSenha">
            </div>
       
            <div class="divEsqueciASenhaEBtn marginBtnEnviar">
                <a href="Usuario-confirmarEmail.php">Esqueci minha senha</a>
                <button type="submit" class="btnEnviarLogin">ENTRAR</button>
            </div>
        </form>


        <!-- Formulário de cadastro -->
        <form class="formularioDeCadastro">
            <input type="text" name='nome' placeholder="Nome" class="inputPadrao especamentoInputs">
            <span class="eror display-none" id='msgErro-nome'></span>

            <input type="email" name='email' placeholder="Email" class="inputPadrao especamentoInputs">
            <span class="eror display-none" id='msgErro-email'></span>
            
            <div class="divInputSenha especamentoInputs">
                <input type="password" placeholder="Senha" name="senha" class="inputSenhaCadastro inputSenha" id="inputSenhaCadastro">
                <img src="assets/icons/eye.svg" onclick="exibirOuOcultarSenha('inputSenhaCadastro')" alt="ícone ver senha" class="iconeVerSenha">
            </div>
            <span class="eror display-none" id='msgErro-senha'></span>
            
            <div class="divInputSenha especamentoInputs">
                <input type="password" placeholder="Confirmar senha" name="confSenha" class="inputSenhaCadastro inputSenha" id='inputCSenhaCadastro'>
                <img src="assets/icons/eye.svg" onclick="exibirOuOcultarSenha('inputCSenhaCadastro')" alt="ícone ver senha" class="iconeVerSenha">
            </div>
            <span class="eror display-none" id='msgErro-confSenha'></span>

            <button type="submit" class="btnEnviarCadastro marginBtnEnviar">
                CADASTRAR-SE
                <div class="display-none" id="loaderCadastrar"></div>
            </button>
        </form>


    </section>

    <script src="JavaScript/exibirOuOcultarSenhaInput.js"></script>
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script>

        //ALTERNAR ENTRE O FORM DE LOGIN E CADASTRO

        var btnLogin = document.querySelector('.btnLogin');
        var btnCadastro = document.querySelector('.btnCadastro');

        var formularioDeLogin = document.querySelector(".formularioDeLogin")
        var formularioDeCadastro = document.querySelector(".formularioDeCadastro")
       
        function mudarForm(){
            formularioDeCadastro.classList.toggle('mostrarForm')
            formularioDeLogin.classList.toggle('mostrarForm')

            btnCadastro.classList.toggle('adcBordaNoBotao')
            btnLogin.classList.toggle('adcBordaNoBotao')
        }


        const formularioCadastro = document.querySelector(".formularioDeCadastro");

        formularioDeCadastro.onsubmit = (event) => {

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
            .then( resposta => {

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
                console.log(resposta);
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


    </script>
</body>
</html>