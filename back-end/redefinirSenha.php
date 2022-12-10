<?php
    session_start();

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    if(!$_SESSION['permissaoParaRedefinir']){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Sem permissão para alterar senha.";
        exit();
    }

    try{
        $senhaNova = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('senhaNova');     
        $confSenhaNova = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('confSenhaNova');    
    }catch( Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }


    $entityManeger = EntityManagerCreator::create();

    /** @var Usuario */
    $usuario = $entityManeger->find(Usuario::class, $_SESSION['idDoUsuarioQueQuerRedefinirSenha']);

    try{
        
        $usuario->setSenha($senhaNova, $confSenhaNova);

    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{
    
        $entityManeger->flush();

        $_SESSION['senhaAlterada'] = true;

        unset($_SESSION['permissaoParaRedefinir']);
        unset($_SESSION['idDoUsuarioQueQuerRedefinirSenha']);
        unset($_SESSION['nomeDoUsuarioQueQuerRedefinirSenha']);
        unset($_SESSION['chave']);
        unset($_SESSION['emailParaQualFoiEnviado']);


        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }

?>