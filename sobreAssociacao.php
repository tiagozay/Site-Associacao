<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="assets/styles/sobre-associacao.css">
    <title>Sobre a APBPDN</title>
</head>
<body>
    <header>
        <div class="divHeader">

        </div>
        <nav class="navOpcoes">
                <button class="btnAbrirMenu" onclick="abrirFecharMenu()"><i class="material-icons">menu_open</i></button>
                <div class="container" id="containerOpcoes">
                    <a href="index.php" class="links">Início</a>
                    <a href="sobreAssociacao.php" class="links active">Sobre <span class="textoAAssociacao">a associação</span> <span class="textoNos">nós</span></a>
                    <a href="Usuario-integrantes.php" class="links">Integrantes</a>
                    <a href="Usuario-contato.php" class="links">Contato</a>
                </div>
            </nav>
    </header>
    
    <main>
        <section class="container sobre-associacao">
            <p>
                <p class='texto-sobre'> No ano de 2018 foi criada a Associação Polono-Brasileira Padre Daniel Niemiec em homenagem ao pároco que realizou diferentes trabalhos na comunidade local e que foram muito além das atividades pastorais, abrangendo iniciativas culturais que enalteceram a etnia polonesa local e nacionalmente. Dentre seus feitos temos o Museu Etnográfico de Santana, a construção dos marcos históricos do Pátio Velho e da Praça da Imigração Polonesa, a Festa do Colono, bem como o grande incentivo para a realização de atividades paroquiais como forma de manter a cultura polonesa nas celebrações e festas religiosas. A associação tem por objetivos manter ativas as tradições culturais, língua, folclore e festividades polonesas, também por perceber que tendo em vista a legislação brasileira para cuidados com patrimônio histórico e cultural, o acesso a recursos nacionais e internacionais seria mais legitimado a partir de uma associação comunitária.</p>

                <p class="texto-sobre p-objetivosDaAssociacao">Objetivos da Associação - preservar a cultura polonesa através da língua, dança, culinária e costumes. - conservar os prédios e monumentos que contam a historia dos poloneses - arrecadar recursos para oficinas de artesanato, culinária, folclore e também para reformas e construção.</p>

            </p>
        </section>
    </main>


    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/gerarHeader.js"></script>
    <!-- <script src="JavaScript/abrirOuFecharMenuSecoes.js"></script>           -->
    <script src="JavaScript/abrirMenuAcoesUsuario.js"></script>

    <script>
        gerarHeader();
    </script>
</body>
</html>