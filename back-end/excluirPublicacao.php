<?php

    use APBPDN\Helpers\EntityManagerCreator;
use APBPDN\Models\ImagemPublicacao;
use APBPDN\Models\Integrante;
use APBPDN\Models\Publicacao;
use APBPDN\Services\ImagemService;
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

        $entityManeger = EntityManagerCreator::create();

        /** @var Publicacao */
        $publicacao = $entityManeger->find(Publicacao::class, $id);
    
        $entityManeger->remove($publicacao);
    
        $entityManeger->flush();
    
        $publicacao->removerCapa();
    
        $publicacao->removerImagens();
    
        header('HTTP/1.1 200 OK');

    }catch(Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }

?>