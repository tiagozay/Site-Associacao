<?php
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Operacoes\Operacao;

    require_once 'vendor/autoload.php';

    $ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'mais_antigas';

    $entityManeger = EntityManagerCreator::create();

    try{

        $operacaoRepository = $entityManeger->getRepository(Operacao::class);

        $oderBy = [];
    
        if($ordem == 'mais_antigas'){
            $oderBy = ['data' => 'ASC'];
        }else if($ordem == 'mais_recentes'){
            $oderBy = ['data' => 'DESC'];
        }

        $operacoes = $operacaoRepository->findBy([], $oderBy);

        $operacoes = Operacao::toArrays($operacoes);
    
        echo json_encode($operacoes);

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }
 
?>