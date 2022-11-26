<?php
    session_start();

    $nivel = $_SESSION['nivel'];

    if($nivel == 'admin'){
        echo '
            <div class="containerHeader">
                <a href="index.php" class="a-Logo"><img src="assets/imagensSite/APBPDN.png" alt=""></a>

                <nav class="navBtns navConfigUsuario">
                    <div class="divNomeEMenu">
                        <p class="textoOla">Olá '. explode(" ",$_SESSION['nome'])[0] .'</p>
                        
                        <div class="menu">
                            <button class="btnAbrirMenuConfigUser"><i class="iconeAbrirMenuConfig material-icons">manage_accounts</i></button>
                            <div class="conteudo">
                                <div class="triangulo"></div>
                                <nav class="opcoes">
                                    <p class="nomeNoMenu">'.$_SESSION['nome'].'</p>
                                    <a href="Usuario-alterarNome.php?pag='. basename($_SERVER['PHP_SELF']) .' "class="btnOpcoesUsuario">Alterar nome</a>

                                    <a href="Usuario-alterarEmail.php?pag='.basename($_SERVER['PHP_SELF']).'" class="btnOpcoesUsuario">Alterar email</a>

                                    <a href="Usuario-alterarSenha.php?pag='.basename($_SERVER['PHP_SELF']).'" class="btnOpcoesUsuario">Alterar senha</a>

                                    <a href="src/logout.php" class="btnOpcoesUsuario">Sair</a>
                                </nav>
                            </div>
                        </div>
                    
                    </div>
                    <a href="Admin-pagInicial.php" class="btnEntrarPainel">Painel <i class="material-icons">settings</i> </a>
                </nav>
            </div>

    ';
    }else if($nivel == 'usuario'){
        echo '
            <div class="containerHeader">
                <a href="index.php" class="a-Logo"><img src="assets/imagensSite/APBPDN.png" alt=""></a>

                <nav class="navBtns navConfigUsuario">
                    <div class="divNomeEMenu">
                        <p class="textoOla">Olá '.explode(" ",$_SESSION['nome'])[0].'</p>
                        
                        <div class="menu">
                            <button class="btnAbrirMenuConfigUser"><i class="iconeAbrirMenuConfig material-icons">manage_accounts</i></button>
                            <div class="conteudo">
                                <div class="triangulo"></div>
                                <nav class="opcoes">
                                    <p class="nomeNoMenu">'.$_SESSION['nome'].'</p>
                                    <a href="Usuario-alterarNome.php?pag='. basename($_SERVER['PHP_SELF']) .' "class="btnOpcoesUsuario">Alterar nome</a>

                                    <a href="Usuario-alterarEmail.php?pag='.basename($_SERVER['PHP_SELF']).'" class="btnOpcoesUsuario">Alterar email</a>

                                    <a href="Usuario-alterarSenha.php?pag='.basename($_SERVER['PHP_SELF']).'" class="btnOpcoesUsuario">Alterar senha</a>

                                    <a href="src/logout.php" class="btnOpcoesUsuario">Sair</a>
                                </nav>
                            </div>
                        </div>
                    
                    </div>
                </nav>
            </div>
        ';
    }else{
        echo 
        '
            <div class="containerHeader">
                <a href="index.php" class="a-Logo"><img src="assets/imagensSite/APBPDN.png" alt=""></a>
                <nav class="navBtns">
                    <a href="login.php" class="btnLogin">ENTRAR <i class="material-icons">login</i> </a>
                </nav>
            </div>
        ';
    }

?>