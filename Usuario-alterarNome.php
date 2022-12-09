<?php
    session_start();

    $nome = $_SESSION['nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar nome</title>
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
            <label for="inputSenha">
                Digite sua senha
                <div class="divInputSenha">
                    <input type="password" class="inputSenha" name="senha" data-pagina='alterarNomeOuSenha' id='inputSenha'>
                    <img src="assets/icons/eyePreto - .svg" onclick="exibirOuOcultarSenha('inputSenha')">
                </div>
                <p class="error display-none" id="msgErro-senha">Informe sua senha</p>
                
            </label>
          
            <label for="nome">
                Nome
                <input type="text" value="<?=$nome?>" id="nome" name="nome">
                <p class="error display-none" id="msgErro-nome">Preencha com seu nome</p>
            </label>
            
            <button class="btnEnviar" type="submit">
                SALVAR
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

            let validacao = validaForm(form.senha, form.nome);

            if(!validacao){
                return;
            }

            let formData = new FormData(form);

            const httpService = new HttpService();

            try{
                loader.classList.remove("display-none");

                let res = await httpService.postFormulario(
                    formData,
                    'back-end/editarNomeUsuario.php'
                );

                loader.classList.add("display-none");

                location.href = "index.php";
            
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

        function validaForm(campoSenha, campoNome){
            let senha = campoSenha.value.trim();
            let nome = campoNome.value.trim();

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

            if(nome.length == 0){
                abrirMensagemDeErroDoInput(campoNome, "Preencha com seu nome.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoNome);

            if(nome.length < 3 || nome.length > 80){
                abrirMensagemDeErroDoInput(campoNome, "Nome inválido.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoNome);

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