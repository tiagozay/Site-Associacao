<?php
    session_start();

    if(!$_SESSION['permissaoParaRedefinir']){
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
    <title>Editar senha</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/redefinirSenha.css">

       
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">

</head>
<body>
    <main>
        <form id="formulario">
            <div class="divBtnVoltar">  
                <a href="emailEnviado.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
            </div>

            <?php
                echo "<p class='nome'>Olá ".$_SESSION['nomeDoUsuarioQueQuerRedefinirSenha']."</p>";
            ?>

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
                    'back-end/redefinirSenha.php'
                );

                loader.classList.add("display-none");

                let text = await res.text();

                console.log(text);

                location.href = "login.php";
            
            }catch(e){
                console.log(e);
                loader.classList.add("display-none");
                new MensagemLateralService("Erro ao editar senha.");
            }

        }

        function validaForm(campoSenhaNova, campoConfSenhaNova){
            let senhaNova = campoSenhaNova.value.trim();
            let confSenhaNova = campoConfSenhaNova.value.trim();
            
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
