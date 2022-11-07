<?php
    session_start();

    use Componentes\Fontes;
    use Componentes\Header;
    use Classes\Publicacao;
    use Classes\ConectionCreator;

    // require_once "src/Classes/Publicacao.php";
    // require_once "src/Classes/ConectionCreator.php";

    require_once "includes/autoload.php";

    $nivelDoUsuario = 'deslogado';
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        $nome = $_SESSION['nome'];
        $nivelDoUsuario = $_SESSION['nivel'];
    }
    
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    
    <link rel="stylesheet" href="assets/styles/reset.css">
    <?php
        new Fontes($nivelDoUsuario);
    ?>           

    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/header/header.css">

    <!-- Carrega o css correspondente ao nivel/estado do usuário -->
    <?php
        if($nivelDoUsuario == 'deslogado'){
            echo '<link rel="stylesheet" href="assets/styles/header/header-deslogado.css">';
        }else if($nivelDoUsuario == 'usuario'){
            echo '<link rel="stylesheet" href="assets/styles/header/header-logadoUsuario.css">';
        }else if($nivelDoUsuario == 'admin'){
            echo '<link rel="stylesheet" href="assets/styles/header/header-logadoAdmin.css">';
        }
    ?>

    

    <link rel="stylesheet" href="assets/styles/navSecoes.css">
    <link rel="stylesheet" href="assets/styles/Home/noticias.css"> 
</head> 
<body>
    <header>
        <?php
            new Header($nivelDoUsuario);
        ?>

        <nav class="navOpcoes">
            <button class="btnAbrirMenu" onclick="abrirFecharMenu()"><i class="material-icons">menu_open</i></button>
            <div class="container" id="containerOpcoes">
                <a href="index.php" class="links active">Início</a>
                <a href="Usuario-sobreAssociacao.php" class="links">Sobre <span class="textoAAssociacao">a associação</span> <span class="textoNos">nós</span> </a>
                <a href="Usuario-integrantes.php" class="links">Integrantes</a>
                <a href="Usuario-contato.php" class="links">Contato</a>
            </div>
        </nav>
    </header>
    
    <section class="secaoNoticias">
        <div class="noticias__container">
            <?php  
                require_once "src/buscaDeDados/todasPublicacoesParaHome.php";
                foreach($publicacoes as $noticia){
                ?>
                    <a href="publicacao.php?pag=<?php echo basename($_SERVER['PHP_SELF']) ?>&id=<?=$noticia['id']?>" class="card">
                        <div class="card__conteudo">
                            <h2 class="conteudo__titulo"><?=$noticia['titulo']?></h2>
                            <p class="conteudo__data"><?=$noticia['dataRegistroFormatada']?></p>
                        </div>
                        <img class="card__capa" src="assets/imagens_dinamicas/capas_noticias/<?=$noticia['capa']?>" alt="">
                    </a>

                <?php } ?>
            
        </div>
    </section>

    <footer class="rodape">
        <h1>2021 - Associação Polono-Brasileira Padre Daniel Niemec &copy;</h1>

        <h2 class="textoDesenvolvido">Desenvolvido por <a href="https://tiagozay.github.io/portfolio/"> Tiago zay </a>e <a href="https://github.com/WillianMateusUss"> Willian uss </a></h2>
    </footer>

    <script src="JavaScript/abrirOuFecharMenuSecoes.js"></script>          
    <script src="JavaScript/abrirMenuAcoesUsuario.js"></script>
    <script src="JavaScript/verMaisNoticias.js"></script>
    <script src="JavaScript/enviarTamanhoDeTela.js"></script>
</body>
</html>