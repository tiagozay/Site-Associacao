<?php
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Publicacao;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    try{
        $id = RequestService::pegaValorDoCampoGETOuLancaExcecao('id');
    }catch(Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{
        $entityManeger = EntityManagerCreator::create();

        $publicacao = $entityManeger->find(Publicacao::class, $id);

        if(!$publicacao){
            header('HTTP/1.1 500 Internal Server Error');
            echo "Publicacao não encontrada!";
            exit();
        }

        echo json_encode($publicacao->toArray());

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }
?>