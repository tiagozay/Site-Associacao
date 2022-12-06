<?php
    if(empty($_GET['id'])){
        header("Location: index.php");
        exit();
    }

    session_start();

    $nivelDoUsuario = 'deslogado';
    $idUsuario = null;
    if(isset($_SESSION['id'])){
        $idUsuario = $_SESSION['id'];
        $nomeUsuario = $_SESSION['nome'];
        $nivelDoUsuario = $_SESSION['nivel'];
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <title>Publicação</title>

    <link rel="stylesheet" href="assets/styles/reset.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/header/header.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">

    <link rel="stylesheet" href="assets/styles/header/header-deslogado.css">
    <link rel="stylesheet" href="assets/styles/header/header-logadoUsuario.css">
    <link rel="stylesheet" href="assets/styles/header/header-logadoAdmin.css">


    <link rel="stylesheet" href="assets/styles/modais/modal.css"> 
    <link rel="stylesheet" href="assets/styles/modais/modaisDeConfirmações.css"> 
    <link rel="stylesheet" href="assets/styles/publicacao/publicacao.css">
    <link rel="stylesheet" href="assets/styles/publicacao/comentarios.css">
    <link rel="stylesheet" href="assets/styles/publicacao/maisPublicacoes.css">

    <style>
        .mensagemLateralDaTela{
            background-color: rgba(0, 0, 0, 0.87);
        }
    </style>
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

    <div class="containerModalImg">
        
    </div>
    <header class="semFundo">
        <div class="divHeader">

        </div>
    </header>
    
    <main>

        <a href="index.php" class="btnVoltarPag"><i class="material-icons">logout</i> Voltar</a>
        <section class="noticia">

            <!-- Armazena id da publicacao -->
            <input type="hidden" value="" class="idPublicacao">

            <!-- Armazena id do usuário -->
            <input type="hidden" value="<?=$idUsuario?>" class="idUsuario">

             <!-- Armazena nivel do usuário -->
             <input type="hidden" value="<?=$nivelDoUsuario?>" class="nivelUsuario">
            
            <h1 class="noticia__titulo"></h1>

            <p class="noticia__data"></p>

            <button class="btnImagemCapa">
                <img src="assets/imagens_dinamicas/capas_noticias/" class="noticia__imagem">
            </button>
         

            <p class="noticia__paragrafo">
     
            </p>

            <div class="imagens">
            </div>

            <button class="btnGostei" onclick="curtirPublicacao(event)">
                Gostei 
                <i class="material-icons">thumb_up</i> 
                <span id="quantidade">(0)</span>
            </button>
            
        </section>

        <section class="telaComentarios">
            <h2>Comentários</h2>

            <form class="formAdcComentario">
                <div id="formAdcComentario__divInput">
                    <input type="text" placeholder="Ecreva um comentário" class="inputComentar" name="comentario">
                    <p id="erro_form_comentario" class="display-none"></p>
                </div>
    
                <button class="material-icons btnComentar">send</button>
            </form>

            <div class="display-none" id="loaderBuscarComentarios"></div>

            <div class="comentarios">
 
            </div>
        </section>

    
        <section class="maisNoticias">
            <h2 class="titulo">Mais publicações</h2>

            <div class="noticias">

            </div>
           
        </section>
  

     
    <footer class="rodape">
        <h1>2022 - Associação Polono-Brasileira Padre Daniel Niemec &copy;</h1>
        <h2 class="textoDesenvolvido">Desenvolvido por <a href="https://tiagozay.github.io/portfolio/" target="blank"> Tiago zay </a>e <a href="https://github.com/WillianMateusUss" target="blank">Willian uss</a> </h2>
    </footer>



    </main>

    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script src="JavaScript/Helpers/DateHelper.js"></script>
    <script src="JavaScript/gerarHeader.js"></script>
    <script src="JavaScript/buscaPublicacao.js"></script>
    <script src="JavaScript/curtirPublicacao.js"></script>
    <script src="JavaScript/comentarPublicacao.js"></script>
    <script src="JavaScript/excluirComentario.js"></script>
    <script src="JavaScript/excluirComentarioAdmin.js"></script>
   

    <!-- <script src="JavaScript/modal.js"></script> -->
    <script src="JavaScript/abrirMenuAcoesUsuario.js"></script>
    <!-- <script src="JavaScript/curtirNoticia.js"></script>
    <script src="JavaScript/comentarNoticia.js"></script>
    <script src="JavaScript/excluirComentario.js"></script>
    <script src="JavaScript/adminExcluirComentario.js"></script> -->
    <script>
                        
        gerarHeader();

        var containerModalImg = document.querySelector(".containerModalImg")

        onkeydown = ()=>{
            if(event.keyCode == 27){
                fecharModal()
            }
        }

        function openModalImg(caminhoImagem){
            const comberturaImg = document.createElement("div")
            comberturaImg.classList.add("coberturaDaImg")

            
            const img = document.createElement("img");
            img.classList.add("imagem");
            img.setAttribute("src", caminhoImagem);
            
            img.onload = () => {
                containerModalImg.classList.add("abrirModal");
                document.body.classList.add("removerScroll");

                const divInconeFechar = document.createElement("div")
                divInconeFechar.classList.add("divInconeFechar")

                const iconeFechar = document.createElement("button")
                iconeFechar.classList.add("material-icons")
                iconeFechar.classList.add("btnFechar")
                iconeFechar.textContent = 'close'
                iconeFechar.addEventListener('click',()=>{fecharModal()})

                containerModalImg.appendChild(comberturaImg)
                containerModalImg.appendChild(img)
                comberturaImg.appendChild(iconeFechar)

                larguraImg = window.getComputedStyle(img).width
                alturaImg = window.getComputedStyle(img).height

                comberturaImg.style.width = larguraImg
                comberturaImg.style.height = alturaImg
            }

        }
        containerModalImg.addEventListener("click", ()=>{
            if(event.target.classList[0] == 'containerModalImg'){
                fecharModal()
            }
        })

        function fecharModal(){
            containerModalImg.innerHTML = ""
            containerModalImg.classList.remove("abrirModal")
            document.body.classList.remove("removerScroll")
        }

        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
    </script>
</body>
</html>