<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/reset.css">
    <link rel="stylesheet" href="assets/styles/base.css">

    <link rel="stylesheet" href="assets/styles/header/header.css">
    <link rel="stylesheet" href="assets/styles/header/header-deslogado.css">
    <link rel="stylesheet" href="assets/styles/header/header-logadoUsuario.css">
    <link rel="stylesheet" href="assets/styles/header/header-logadoAdmin.css">

    <link rel="stylesheet" href="assets/styles/navSecoes.css">
    <link rel="stylesheet" href="assets/styles/contato.css">
    <title>Contato</title>
</head>
<body>
    <header>
        <div class="divHeader">

        </div>
        <nav class="navOpcoes">
            <button class="btnAbrirMenu" onclick="abrirFecharMenu()"><i class="material-icons">menu_open</i></button>
            <div class="container" id="containerOpcoes">
                <a href="index.php" class="links">Início</a>
                <a href="sobreAssociacao.php" class="links">Sobre <span class="textoAAssociacao">a associação</span> <span class="textoNos">nós</span></a>
                <a href="integrantes.php" class="links">Integrantes</a>
                <a href="contato.php" class="links  active">Contato</a>
            </div>
        </nav>
    </header>
    
    <main>
        <section class="container">
               
                <a href="mailto:associacaoapbpdn@gmail.com" class="link"> 
                    <i class="material-icons">mail</i> 
                    <span>associacaoapbpdn@gmail.com</span>
                </a>

            <a href="tel:42 9975-0545" class="link">
                <i class="material-icons">call</i> 
                <span>42 99975-0545</span>
            </a>
            <a href="https://www.facebook.com/Associa%C3%A7%C3%A3o-Polono-Brasileira-Padre-Daniel-Niemec-1920410171591253" class="link" target="_blank">
                <i class="material-icons">home</i> 
                <span>Facebook</span>
            </a>
        </section>
    </main>

    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/gerarHeader.js"></script>
    <script src="JavaScript/abrirMenuAcoesUsuario.js"></script>

    <script>
        gerarHeader();
    </script>
</body>
</html>