<?php
    session_start();

    $_SESSION['nivel'] = 'admin';

    if($_SESSION['nivel'] != 'admin'){
        header("Location: index.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar usuário</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/Admin/paginaAdicionarUsuario/paginaAdcUsuario.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">


    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">
    
</head>
<body>
        <section class="sectionFormCadastroUsuario">
            <fieldset>
                <legend>Cadastrar usuário</legend>

                <div class="divBtnVoltar">   
                    <a href="Admin-pagInicial.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
                </div>
            

                <div class="container">
                    <form id="formulario">
                        <div class="divLabelEInput">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" class="inputForm" >
                            <span class="eror display-none" id='msgErro-nome'></span>
                        </div>

                        <div class="divLabelEInput">
                            <label for="nome">Email:</label>
                            <input type="email" id="email" name="email" class="inputForm">
                            <span class="eror display-none" id='msgErro-email'></span>
                        </div>

                        <div class="divLabelEInput">
                            <label for="nivel">Nível:</label>
                            <select name="nivel" id="nivel"  class="inputForm">
                                <option value="usuario">Usuário</option>
                                <option value="admin">Administrador</option>
                            </select>
                            <span class="eror display-none" id='msgErro-nivel'></span>
                        </div>

                        <div class="divLabelEInput">
                            <label for="inputSenha">Senha:</label>
                            <div class="divInputSenha">
                                <input type="password" id="inputSenha" name="senha" data-pagina='admin' class="inputForm" >
                                <img src="assets/icons/eyePagAdmin.svg"  onclick="exibirOuOcultarSenha('inputSenha')" alt="">
                            </div>
                            <span class="eror display-none" id='msgErro-senha'></span>
                        
                        </div>

                        <div class="divLabelEInput">
                            <label for="inputCSenha">Confirmar senha:</label>
                            <div class="divInputSenha">
                                <input type="password" id="inputCSenha" name="confSenha" data-pagina='admin' class="inputForm" >
                                <img src="assets/icons/eyePagAdmin.svg" class="img" onclick="exibirOuOcultarSenha('inputCSenha')">
                            </div>
                            <span class="eror display-none" id='msgErro-confSenha'></span>
                        </div>

                        <button type="submit">
                            Cadastrar usuário
                            <div class="display-none" id="loaderCadastrarUsuario"></div>
                        </button>
                    </form>
                </div>
            </fieldset>
        </section>    
        
    <script src="JavaScript/exibirOuOcultarSenhaInput.js"></script>
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script> 

        const formulario = document.querySelector("#formulario");

        formulario.onsubmit = (event) => {

            event.preventDefault();

            const validacao = validaUsuario(
                formulario.nome,
                formulario.email, 
                formulario.nivel,
                formulario.senha,
                formulario.confSenha
            );

            if(!validacao){
                return;
            }

            const httpService = new HttpService();

            let loader = document.querySelector("#loaderCadastrarUsuario");

            loader.classList.remove("display-none");

            let formData = new FormData(formulario);

            httpService.postFormulario(formData, 'back-end/cadastraUsuarioAdmin.php')
            .then( resposta => {
                new MensagemLateralService("Usuário cadastrado com sucesso!");

                formulario.reset();

                loader.classList.add("display-none");
            } )
            .catch( resposta => {
                console.log(resposta);

                loader.classList.add("display-none");

                if(resposta.message == 'usuario_ja_cadastrado'){
                    abrirMensagemDeErroDoInput(formulario.email, "Este e-mail já foi cadastrado.");
                }else{
                    fecharMensagemDeErroDoInput(formulario.email);
                }
            } )

        }
        function validaUsuario(campoNome, campoEmail, campoNivel, campoSenha, campoConfSenha)
        {
            let nome = campoNome.value;
            let email = campoEmail.value;
            let nivel = campoNivel.value;
            let senha = campoSenha.value;
            let confSenha = campoConfSenha.value;

            if(nome.trim().length == 0){
                abrirMensagemDeErroDoInput(campoNome, "Informe o nome do usuáro.");
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

            if(senha.trim().length == 0){
                abrirMensagemDeErroDoInput(campoSenha, "Informe a senha do usuáro.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoSenha);

            if(senha.trim().length < 8){
                abrirMensagemDeErroDoInput(campoSenha, "A senha deve conter no mínimo 8 caracteres.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoSenha);

            if(confSenha.trim().length == 0){
                abrirMensagemDeErroDoInput(campoConfSenha, "Confirme a senha do usuáro.");
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