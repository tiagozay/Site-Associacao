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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/header/header.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">

    <link rel="stylesheet" href="assets/styles/header/header-logadoAdmin.css">
    
    <link rel="stylesheet" href="assets/styles/Admin/paginaInicialAdmin/acoes/Admin-acoes.css">
    <link rel="stylesheet" href="assets/styles/Admin/paginaInicialAdmin/seletorListaNoticiasUsuarios/seletorListaNoticiasOuUsuarios.css">
    <link rel="stylesheet" href="assets/styles/Admin/paginaInicialAdmin/listaDeNoticias/Admin-listaNoticias.css">

    <link rel="stylesheet" href="assets/styles/Admin/paginaInicialAdmin/listaDeUsuarios/Admin-sectionLista.css"> 
    <link rel="stylesheet" href="assets/styles/Admin/paginaInicialAdmin/listaDeUsuarios/Admin-cabecalhoDaLista.css"> 
    <link rel="stylesheet" href="assets/styles/Admin/paginaInicialAdmin/listaDeUsuarios/Admin-listaUsuarios.css">   
    <link rel="stylesheet" href="assets/styles/modais/modal.css">   
    <link rel="stylesheet" href="assets/styles/modais/modaisDeConfirmações.css">   
    <link rel="stylesheet" href="assets/styles/modais/modalAcoesUsuarios.css">   
    


    <title>Painel administrativo</title>
</head>
<body>
    <input type="hidden" class="idUsuario" value="<?=$id?>">

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
    <header>
    </header>
    

    <section class="secaoAcoes">
        <i class="material-icons" onclick="abrirOuFecharMenuAcoes()">menu_open</i>
        <div class="container containerAcoes">
            <a href="Admin-formCadastroNoticias.php" class="btnAcoes">PUBLICAR</a>
            <a href="Admin-formCadastroUsuario.php" class="btnAcoes">CADASTRAR USUÁRIO</a>
            <a href="Admin-formCadastroIntegrante.php" class="btnAcoes">INTEGRANTES</a>
            <a href="Admin-atividade.php" class="btnAcoes">ATIVIDADE</a>
        </div>
    </section>


    <section class="secaoSeletorNoticiasOuUsuarios">
        <div class="container">
            <button id="btnMostrarNoticias" class="">Publicações</button>
            <button id="btnMostrarUsuarios" class="bordaInferior" >Usuarios</button>
        </div>
    </section>

    <section class="secaoListaDeNoticias">
        <div class="container">
            <ul>            
            </ul>
        </div>
    </section>

    <section class="secaoListaDeUsuarios">
        <div class="container">

            <div class="cabecalhoDaTabela">
                <div class="opcoesTabela">

                    <p class="quantidadeUsuarios">0 Usuários </p> 
                    <div class="pype">|</div>

                    <label for="ordem">
                        <div class="divTextoLabel">Ordenar por </div>
                        <select id="ordenarPor" class="select">
                            <option value="mais_antigos">Mais antigos</option>
                            <option value="mais_recentes">Mais recentes</option>
                            <option value="ordem_alfabetica">Ordem alfabética</option>
                        </select> 
                    </label> 
                    <div class="pype">|</div>

                    <label for="niveis">
                        <div class="divTextoLabel">Níveis</div> 
                        <select id="niveis">
                            <option value="todos"> <a href="index.php">Todos</a></option>
                            <option value="usuario">Usuários</option>
                            <option value="admin">Administradores</option>
                        </select> 
                    </label>
                    <div class="pype">|</div>

                    <label for="buscar">
                        <div class="divTextoLabel">Buscar</div> 
                        <input type="search" id="buscar">
                    </label>


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

                        <td class="thead__tr__tdGenerico  thead__tr__tdEmail">
                            <div class="thead__tr__td__divGenericaConteudo">
                                Email <i class="material-icons">arrow_drop_down</i>
                            </div>
                        </td>

                        <td class="thead__tr__tdGenerico thead__tr__tdNivel">
                            <div class="thead__tr__td__divGenericaConteudo">
                                Nível <i class="material-icons">arrow_drop_down</i>
                            </div>
                        </td>
                        <td class="thead__tr__tdGenerico thead__tr__tdAcoes">
                            <div class="thead__tr__td__divGenericaConteudo thead__tr__td__divAcoes">
                                Ações
                            </div>
                        </td>
                    </tr>
                </thead>

                <tbody class="tbody">

                </tbody>

            </table>
            
            <div class="desativarLoader"  id="divLoaderBuscarUsuarios">
                    <div id="loaderBuscarUsuarios"></div>
                    Buscando usuários...
                </div>
        </div>
    </section>
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script src="JavaScript/buscaUsuarios.js"></script>
    <script src="JavaScript/excluirUsuario.js"></script>



    <script>


        var btnMostrarUsuarios = document.querySelector("#btnMostrarUsuarios")
        btnMostrarUsuarios.addEventListener("click", function(){buscaUsuarios()})

        var indicador = false;

        //MOSTRAR OU ESCONDER MENU DE AÇÕES
        /*tem uma continuação no outro arquivo...*/
        var btns = document.querySelectorAll(".btnAcoes")
        var indicadorDeMenuAberto = false
        function abrirOuFecharMenuAcoes(){
            for(let i = 0; i < btns.length; i++){
                btns[i].classList.toggle("abrirMenu")
            }
            btns[3].classList.toggle("gerarBordaNoUltimoBotao")           
        }
        


        //TORCAR LISTAS DE USUÁRIO E NOTICIAS
        var btnMostrarNoticias = document.querySelector("#btnMostrarNoticias")
        var btnMostrarUsuarios = document.querySelector("#btnMostrarUsuarios")

        btnMostrarNoticias.addEventListener("click",function(){trocarDeLista()})
        btnMostrarUsuarios.addEventListener("click",function(){trocarDeLista()})

        var secaoListaDeNoticias = document.querySelector(".secaoListaDeNoticias")
        var secaoListaDeUsuarios = document.querySelector(".secaoListaDeUsuarios")

        function trocarDeLista(){
            secaoListaDeNoticias.classList.toggle("displayNone")
            secaoListaDeUsuarios.classList.toggle("displayNone")

            btnMostrarNoticias.classList.toggle("bordaInferior")
            btnMostrarUsuarios.classList.toggle("bordaInferior")
        }
    </script>
 
    <script src="JavaScript/configConformeTamanhoDeTela.js"></script>
    <script src="JavaScript/abrirMenuAcoesUsuario.js"></script>
    <script src="JavaScript/verMaisUsuarios.js"></script>
    <script src="JavaScript/tornarUsuarioAdmin.js"></script>
    <script src="JavaScript/removerUsuarioDeAdmin.js"></script>
    <script src="JavaScript/excluirUsuario.js"></script>
</body>
</html>
