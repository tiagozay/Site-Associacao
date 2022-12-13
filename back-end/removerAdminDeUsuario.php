<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Operacoes\OperacaoRemoverAdminDeUsuario;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\RequestService;
    use APBPDN\Services\LoginService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeUsuarioEAdmin()){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
        $id =  RequestService::pegaValorDoCampoPOSTOuLancaExcecao('id');
    }catch( Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{

        $entityManager = EntityManagerCreator::create();

        /** @var Usuario */
        $usuario = $entityManager->find(Usuario::class, $id);
    
        $usuario->removerDeAdmin();
    
        $entityManager->flush();

        $operacao = new OperacaoRemoverAdminDeUsuario(
            LoginService::buscaUsuarioLogado($entityManager)->getNome(),
            $usuario->getNome()
        );

        $entityManager->persist($operacao);

        $entityManager->flush();
    
        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }

?>