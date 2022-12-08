<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Publicacao;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    try{
        $idExcessao = RequestService::pegaValorDoCampoGETOuLancaExcecao('idExcessao');
    }catch(Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{

        $entityManeger = EntityManagerCreator::create();

        $publicacaoRepository = $entityManeger->getRepository(Publicacao::class);

        $qb = $entityManeger->createQuery(
            "SELECT p.id, p.data, p.titulo, p.capa FROM APBPDN\Models\Publicacao p where p.id != $idExcessao ORDER BY p.data DESC" 
        );

        $qb->setMaxResults(3);

        $publicacoes=  $qb->getResult();
            
        header('HTTP/1.1 200 OK');

        echo json_encode($publicacoes);


    }catch( Throwable $e ){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>