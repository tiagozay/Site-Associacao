<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    
    <link rel="stylesheet" href="assets/styles/reset.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/header/header.css">

    <link rel="stylesheet" href="assets/styles/header/header-deslogado.css">
    <link rel="stylesheet" href="assets/styles/header/header-logadoUsuario.css">
    <link rel="stylesheet" href="assets/styles/header/header-logadoAdmin.css">
    


    <link rel="stylesheet" href="assets/styles/navSecoes.css">
    <link rel="stylesheet" href="assets/styles/Home/noticias.css"> 
</head> 
<body>
    <header>
        <div class="divHeader">

        </div>

        <nav class="navOpcoes">
            <button class="btnAbrirMenu" onclick="abrirFecharMenu()"><i class="material-icons">menu_open</i></button>
            <div class="container" id="containerOpcoes">
                <a href="index.php" class="links active">Início</a>
                <a href="sobreAssociacao.php" class="links">Sobre <span class="textoAAssociacao">a associação</span> <span class="textoNos">nós</span> </a>
                <a href="integrantes.php" class="links">Integrantes</a>
                <a href="contato.php" class="links">Contato</a>
            </div>
        </nav>
    </header>
    
    <section class="secaoNoticias">

        <div class="loaderDesativado" id="divLoaderBuscarPublicacoes">
            <div class="" id="loaderBuscarPublicacoes"></div>
            Buscando publicações...
        </div>
       

        <div class="noticias__container">

        </div>
    </section>

    <footer class="rodape">
        <h1>2023 - Associação Polono-Brasileira Padre Daniel Niemec &copy;</h1>

        <h2 class="textoDesenvolvido">Desenvolvido por <a href="https://tiagozay.github.io/portfolio/"> Tiago zay </a>e colaboração de <a href="https://github.com/WillianMateusUss"> Willian uss </a></h2>
    </footer>

    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Helpers/DateHelper.js"></script>
    <script src="JavaScript/gerarHeader.js"></script>
    <script src="JavaScript/abrirMenuAcoesUsuario.js"></script>
    <script src="JavaScript/buscaPublicacoesHome.js"></script>
  
    <script>
   
        gerarHeader();
        buscaPublicacoes();

    </script>
</body>
</html>