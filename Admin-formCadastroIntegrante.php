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
    <link rel="stylesheet" href="assets/styles/reset.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/Admin/paginaIntegrante/paginaIntegrante.css">
    <link rel="stylesheet" href="assets/styles/modais/modal.css">
    <link rel="stylesheet" href="assets/styles/modais/modaisDeConfirmações.css">
    <title>Integrantes</title>
</head>
<body>
    <div class="containerModal">
        <div class="modal">
            <div class="divSuperiorBtnFechar">
                <p class="tituloModal"></p>
                <i onclick="fecharMenu()" class="material-icons">close</i>
            </div>
            <div class="modal__conteudo">

            </div>
        </div>
    </div>
    <section class="sectionIntegrantes">
        <fieldset>
            <legend>Integrantes</legend>

            <div class="divBtnVoltar">   
                <a href="Admin-pagInicial.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
            </div>
        
            <div class="container">
                <form enctype="multipart/form-data" class="form" id="formulario">
                    <div class="divLabelEInput">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="inputForm">
                    </div>
                
                    <div class="divLabelEInput">
                        <label for="cargo">Cargo:</label>
                        <select name="cargo" id="cargo"  class="inputForm" >
                            <option disabled selected>SELECIONAR</option>
                            <option value="Presidente">Presidente</option>
                            <option value="Vice presidente">Vice presidente</option>
                            <option value="1º Secretário(a)">1º Secretário(a)</option>
                            <option value="2º Secretário(a)">2º Secretário(a)</option>
                            <option value="1º Tesoureiro(a)">1º Tesoureiro(a)</option>
                            <option value="2º Tesoureiro(a)">2º Tesoureiro(a)</option>
                            <option value="Integrante">Integrante</option>
                        </select>
                    </div>

                    <div class="divLabelEInput">
                        <label for="perfil">Perfil:</label>
                        <input type="file" name="imagem" id="perfil" class="inputPerfil" accept="image/*">
                    </div> 
        
                    <button type="submit">Cadastrar integrante</button>
                </form>

            </div>
        </fieldset>
    </section>
    <script src="JavaScript/modal.js"></script>
    <script>

        const formulario = document.querySelector("#formulario");

        formulario.onsubmit = (event) => {
            event.preventDefault();

            const formData = new FormData(formulario);

            fetch('back-end/cadastraIntegrante.php',   
            {   
                method: 'POST',
                body: formData
            })
            .then( resposta => {
                resposta.text()
                .then( texto => console.log(texto) )
            } )

        }

    </script>
</body>
</html>