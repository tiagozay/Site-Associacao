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
        <form class="formularioDeLogin mostrarForm">
            <input type="email" name="email" placeholder="Email" autofocus="true" class="inputPadrao especamentoInputs">
            <span class="eror display-none" id='msgErroLogin-email'></span>
 
            <div class="divInputSenha especamentoInputs">
                <input type="password" name="senha" placeholder="Senha" class="inputSenhaLogin inputSenha" id="inputSenhaLogin">
                <img src="assets/icons/eye.svg" onclick="exibirOuOcultarSenha('inputSenhaLogin')" alt="ícone ver senha" class="iconeVerSenha">
            </div>
            <span class="eror display-none" id='msgErroLogin-senha'></span>

       
            <div class="divEsqueciASenhaEBtn marginBtnEnviar">
                <a href="Usuario-confirmarEmail.php">Esqueci minha senha</a>
                <button type="submit" class="btnEnviarLogin">
                    ENTRAR
                    <div class="display-none" id="loaderLogin"></div>
                </button>
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
    <script src="JavaScript/login.js"></script>
    <script src="JavaScript/cadastroUsuario.js"></script>


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

    </script>
</body>
</html>