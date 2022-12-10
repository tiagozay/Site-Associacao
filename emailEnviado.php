<?php
    session_start();

    $emailUsuario = $_SESSION['emailParaQualFoiEnviado'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código enviado</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/emailEnviado.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">

   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">

    <style>
        .mensagemLateralDaTela{
            background-color: rgba(0, 0, 0, 0.97);
        }
    </style>
</head>
<body>
    <main>
        <div class="divCentral">
            <div class="divBtnVoltar">  
                <a href="confirmarEmail.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
            </div>
            Enviamos um código de segurança para: <span class="email"><?=$emailUsuario?></span>
            <form id="formulario">
                <input type="text" class="inputCodigo" required name="chave" autofocus> 
                <button class="btnVerificarCodigo">Verificar</button>
            </form>
            
        </div>
    </main>

    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script>
        let form = document.querySelector("#formulario");

        form.onsubmit = async (event) => {
            event.preventDefault();

            const hpttService = new HttpService();

            let formData = new FormData(form);

            try{

                let res = await hpttService.postFormulario(
                    formData,
                    'back-end/verificaChave.php'
                );

                let text = await res.text();
                
                if(text == 'Chave correta'){
                    location.href = 'redefinirSenha.php';
                }

            }catch(e){
                if(e.message == "Chave inválida"){
                    new MensagemLateralService("A Chave informada é inválida.");
                    return;
                }

                new MensagemLateralService("Erro ao validar chave de segurança.");
            }
                  
        }
    </script>
</body>
</html>
