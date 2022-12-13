<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Operacoes\OperacaoExcluirPublicacao;
    use APBPDN\Models\Publicacao;
    use APBPDN\Services\LoginService;
    use APBPDN\Services\RequestService;

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

        /** @var Publicacao */
        $publicacao = $entityManager->find(Publicacao::class, $id);
    
        $entityManager->remove($publicacao);
    
        $entityManager->flush();
    
        $publicacao->removerCapa();
    
        $publicacao->removerImagens();

        $operacao = new OperacaoExcluirPublicacao(
            LoginService::buscaUsuarioLogado($entityManager)->getNome()
        );

        $entityManager->persist($operacao);

        $entityManager->flush();
    
        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }

?>