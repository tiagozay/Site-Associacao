<?php
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;
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

        $integrante = $entityManeger->find(Integrante::class, $id);

        if(!$integrante){
            header('HTTP/1.1 500 Internal Server Error');
            echo "Integrante não encontrado!";
            exit();
        }

        echo json_encode($integrante->toArray());

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }
?>