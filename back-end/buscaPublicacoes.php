<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Publicacao;

    require_once 'vendor/autoload.php';

    try{

        $entityManeger = EntityManagerCreator::create();

        $publicacaoRepository = $entityManeger->getRepository(Publicacao::class);
    
        $publicacoes = $publicacaoRepository->findBy([], ['data' => 'DESC']);
    
        $publicacoes = Publicacao::toArraysSimples($publicacoes);
    
        echo json_encode($publicacoes);
    
        header('HTTP/1.1 200 OK');


    }catch( Throwable $e ){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>