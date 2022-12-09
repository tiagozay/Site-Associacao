<?php
    session_start();

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\LoginService;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeHaUsuarioLogado()){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Usuário não está logado.";
        exit();
    }

    try{
        $senha = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('senha');       
        $nome =  RequestService::pegaValorDoCampoPOSTOuLancaExcecao('nome');
    }catch( Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }


    $entityManeger = EntityManagerCreator::create();

    /** @var Usuario */
    $usuario = $entityManeger->find(Usuario::class, $_SESSION['id']);

    if(!LoginService::testaSenha($senha, $usuario)){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Senha inválida";
        exit(); 
    }
    

    try{
        
        $usuario->setNome($nome);

    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{
    
        $entityManeger->flush();

        LoginService::setarSessoes($usuario);

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }

?>