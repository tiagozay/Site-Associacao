<?php
    session_start();
    if(isset($_SESSION['id'])){
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
    <title>Confirmar e-mail</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/confirmarEmail.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">

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
                <a href="login.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
            </div>
            <label for="email">
                Digite seu email
                <input type="email" id="email" class="inputEmail" name="email">
                <p class="error display-none" id="msgErro-email"></p>
            </label>

                  
            <button type="submit" class="btnEnviar">
                CONTINUAR
                <div class="display-none" id="loader"></div>
            </button>
        </form>
    </main>

    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script>
        let form = document.querySelector("#formulario");
        let loader = document.querySelector("#loader");

        form.onsubmit = async (event) => {
            event.preventDefault();

            let validacao = validaForm(form.email);

            if(!validacao){
                return;
            }

            const httpService = new HttpService();

            let formData = new FormData(form);
        
            loader.classList.remove("display-none");

            try{

                let res = await httpService.postFormulario(
                    formData,
                    'back-end/enviarEmail.php'
                );

                let text = await res.text();

                console.log(text);

                loader.classList.add("display-none");

                location.href = 'emailEnviado.php';
                
            }catch(e){
                loader.classList.add("display-none");

                console.log(e);

                if(e.message == "E-mail inválido"){
                    abrirMensagemDeErroDoInput(form.email, "E-mail inválido"); 
                    return;
                }
                fecharMensagemDeErroDoInput(form.email);

                new MensagemLateralService("Não foi possível enviar o e-mail.");
            }
         
        }

        function validaForm(campoEmail){
            let email = campoEmail.value.trim();

            if(email.length == 0){
                abrirMensagemDeErroDoInput(campoEmail, "Informe seu e-mail");
                return false;
            }
            fecharMensagemDeErroDoInput(campoEmail);

            if(email.length > 260){
                abrirMensagemDeErroDoInput(campoEmail, "E-mail inválido");

                return false;
            }
            fecharMensagemDeErroDoInput(campoEmail);

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