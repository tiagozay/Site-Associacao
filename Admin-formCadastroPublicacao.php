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
    <title>Adicionar publicação</title>
    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">
    <link rel="stylesheet" href="assets/styles/Admin/paginaAdicionarPublicacao/paginaAdcPublicacao.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">
</head>
<body>
    <section class="sectionformularioCadatroNoticias">
        <fieldset>
            <legend>Adicionar publicação</legend>

            <div class="divBtnVoltar">
                <a href="Admin-pagInicial.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
            </div>

            <div class="container">
                <form id="formulario" enctype="multipart/form-data">
                    <div class="divLabelEInput">
                        <label for="titulo">Titulo*:</label>
                        <input type="text" name="titulo" id="titulo" class="inputForm">
                        <span class="eror display-none" id='msgErro-titulo'></span>
                    </div>

                    <div class="divLabelEInput">
                        <label for="data">Data*:</label>
                        <input type="date" name="data" id="data" class="inputForm">
                        <span class="eror display-none" id='msgErro-data'></span>
                    </div>

                    <div class="divLabelEInput">
                        <label for="texto">Texto:</label>
                        <textarea  name="texto" id="texto" cols="30" rows="7" class="inputForm"></textarea>
                    </div>

                    <div class="divLabelEInput">
                        <label for="video">Quantidade de videos:</label>
                        <select id="quantidadeDeVideos" class="selectQuantidadeVideos" name="quantidadeDeVideos">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div id="divInputsVideos">

                    </div>
                    
                    <div class="divLabelEInput">
                        <label for="capa">Capa*:</label>
                        <input type="file" name="capa" id="capa" class="inputForm" accept="image/*">
                        <span class="eror display-none" id='msgErro-capa'></span>
                    </div>

                    <div class="divLabelEInput">
                        <label for="imagens">Imagens:</label>
                        <input type="file" name="imagens[]" id="imagens" class="inputForm" accept="image/*" multiple="multiple">
                        <span class="eror display-none" id='msgErro-imagens[]'></span>
                    </div>


                    <div class="divLabelEInput">
                        <label for="permitirComentarios" class="labelPComentarios">
                            <input type="checkbox" name="permitirComentarios" checked id="permitirComentarios">
                            Permitir comentários
                        </label>
                    </div>

                    <div class="divLabelEInput">
                        <label for="permitirCurtidas" class="labelPLikes">
                            <input type="checkbox"  name="permitirCurtidas" checked id="permitirCurtidas">
                            Permitir curtidas
                        </label>
                    </div>

                    <!-- <input type="hidden" name="qtdeVideos" value="0" id="inputQtdeVideos"> -->

                  
                    <button type="submit">
                        Cadastrar publicação
                        <div class="display-none" id="loaderCadastrarPublicacao"></div>
                    </button>
                </form>
            </div>
        </fieldset>
    </section>
    <script src="JavaScript/geraInputsDeVideos.js"></script>
    <script src="JavaScript/Services/ImagemService.js"></script>
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script src="JavaScript/cadastraPublicacao.js"></script>

</body>
</html>