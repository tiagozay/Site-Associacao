<?php
    session_start();

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
    <title>Atividade</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/reset.css">
    
    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/header/header.css">
    <link rel="stylesheet" href="assets/styles/header/header-logadoAdmin.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">


    <link rel="stylesheet" href="assets/styles/Admin/atividade/cabecalho.css">
    <link rel="stylesheet" href="assets/styles/Admin/atividade/lista.css">
</head>
<body>
    <header>
        <div class="divHeader">

        </div>
    </header>


    <section class="secaoListaDeUsuarios">
        <div class="container">
            <div class="cabecalhoDaTabela">
            <a href="Admin-pagInicial.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
                <div class="conteudoCabecalho">
               
                    <div class="opcoesTabela">
                        <label for="ordem">
                            <div class="divTextoLabel">Ordenar por </div>
                            <select name="" id="ordem" class="select">
                                <option value="mais_antigas">Mais antigas</option>
                                <option value="mais_recentes">Mais recentes</option>
                            </select> 
                        </label> 
                    </div>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <td class="thead__tr__tdGenerico  thead__tr__tdNome">
                            <div class="thead__tr__td__divGenericaConteudo">
                                Nome <i class="material-icons">arrow_drop_down</i>
                            </div>
                        </td>
                        <td class="thead__tr__tdGenerico thead__tr__tdAcao">
                            <div class="thead__tr__td__divGenericaConteudo">
                                Ação <i class="material-icons">arrow_drop_down</i>
                            </div>
                        </td>
                        <td class="thead__tr__tdGenerico thead__tr__tdData">
                            <div class="thead__tr__td__divGenericaConteudo">
                                Data
                            </div>
                        </td>
                    </tr>
                </thead>

                <tbody id="lista">
            

                </tbody>
       
            </table>

        </div>

        <div id="divLoaderBuscarOperacoes" class="loaderDesativado">
            <div id="loaderBuscarOperacoes"></div>
            Buscando operações...
        </div>
    </section>

    


    <script src="JavaScript/gerarHeader.js"></script>
    <script src="JavaScript/abrirMenuAcoesUsuario.js"></script>
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script src="JavaScript/Helpers/DateHelper.js"></script>
    <script src="JavaScript/buscaOperacoes.js"></script>

    <script>
        gerarHeader();
    </script>

</body>
</html>