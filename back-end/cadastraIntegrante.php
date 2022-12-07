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
        $nome =  RequestService::pegaValorDoCampoPOSTOuLancaExcecao('nome');
        $cargo = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('cargo');
        $imagem = RequestService::pegaValorDoCampoFILESOuLancaExcecao('imagem');
    }catch( Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    //Instância e validação das regras de negócio
    try{
        $integrante = new Integrante($nome, $cargo, $imagem);
    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{

        $integrante->salvarImagem();

        $entityManeger = EntityManagerCreator::create();

        $entityManeger->persist($integrante);
    
        $entityManeger->flush();

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>