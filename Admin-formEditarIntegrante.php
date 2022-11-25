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

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/Admin/paginaIntegrante/paginaIntegrante.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">
    
    <title>Editar integrante</title>
</head>
<body>
    <section class="sectionIntegrantes">
        <fieldset>
            <legend>Editar integrante</legend>

            <div class="divBtnVoltar">   
                <a href="Admin-pagInicial.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
            </div>
        
            <div class="container">
                <form enctype="multipart/form-data" class="form" id="formulario">
                    <div class="divLabelEInput">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="inputForm">
                        <span class="eror display-none" id='msgErro-nome'></span>
                    </div>
                
                    <div class="divLabelEInput">
                        <label for="cargo">Cargo:</label>
                        <select name="cargo" id="cargo"  class="inputForm">
                            <option disabled selected>SELECIONAR</option>
                            <option value="Presidente">Presidente</option>
                            <option value="Vice presidente">Vice presidente</option>
                            <option value="1º Secretário(a)">1º Secretário(a)</option>
                            <option value="2º Secretário(a)">2º Secretário(a)</option>
                            <option value="1º Tesoureiro(a)">1º Tesoureiro(a)</option>
                            <option value="2º Tesoureiro(a)">2º Tesoureiro(a)</option>
                            <option value="Integrante">Integrante</option>
                        </select>
                        <span class="eror display-none" id='msgErro-cargo'></span>
                    </div>

                    <div class="divLabelEInput">
                        <label for="perfil">Trocar perfil:</label>
                        <input type="file" name="imagem" id="perfil" class="inputPerfil" accept="image/*">
                        <span class="eror display-none" id='msgErro-imagem'></span>
                    </div> 
        
                    <input type="hidden" name="id" id='id'>

                    <button type="submit" id='btnSalvar'>
                        Salvar
                        <div class="display-none" id="loaderEnviar"></div>
                    </button>
                </form>

            </div>
        </fieldset>
    </section>
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script src="JavaScript/Services/ImagemService.js"></script>
    <script src="JavaScript/buscaIntegranteParaEditar.js"></script>
    <script src="JavaScript/editarIntegrante.js"></script>

</body>
</html>