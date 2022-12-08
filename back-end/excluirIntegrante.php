<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;
    use APBPDN\Models\Operacoes\OperacaoRemoverIntegrante;
    use APBPDN\Services\ImagemService;
    use APBPDN\Services\LoginService;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    session_start();

    $_SESSION['nivel'] = 'admin';

    if($_SESSION['nivel'] != 'admin'){
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

        /** @var Integrante */
        $integrante = $entityManager->find(Integrante::class, $id);
    
        $entityManager->remove($integrante);
    
        $entityManager->flush();
    
        ImagemService::removeImagemDoDiretorio(
            __DIR__."\..\assets\imagens_dinamicas\imagens_integrantes\\".$integrante->getNomeImagem()
        );

        $operacao = new OperacaoRemoverIntegrante(
            LoginService::buscaUsuarioLogado($entityManager),
            $integrante->getNome()
        );

        $entityManager->persist($operacao);

        $entityManager->flush();
    
        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }

?>