<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;
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
        $nome =  RequestService::pegaValorDoCampoPOSTOuLancaExcecao('nome');
        $cargo = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('cargo');
        $imagem = RequestService::pegaValorDoCampoFILESOuLancaExcecao('imagem');
    }catch( Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{
        
        $entityManeger = EntityManagerCreator::create();

        /** @var Integrante */
        $integrante = $entityManeger->find(Integrante::class, $id);
    
        $integrante->edita($nome, $cargo, $imagem);
    
        $entityManeger->flush();
    
    }catch( Throwable $e ){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>