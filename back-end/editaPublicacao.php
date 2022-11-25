<?php
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;
    use APBPDN\Models\Publicacao;
    use APBPDN\Services\RequestService;
    use APBPDN\Services\VideoService;

    require_once 'vendor/autoload.php';

    session_start();

    $_SESSION['nivel'] = 'admin';

    if($_SESSION['nivel'] != 'admin'){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
        $id = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('id');
        $titulo = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('titulo');
        $data = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('data');
        $texto = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('texto');
        $quantidadeDeVideos = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('quantidadeDeVideos');

        $urlsVideos = [];

        for($i = 1; $i <= $quantidadeDeVideos; $i++){
            $urlsVideos[] = VideoService::pegaUlrDeIframe($_POST["video$i"]);
        }

        $capa = RequestService::pegaValorDoCampoFILESOuLancaExcecao('capa');
        $imagens = RequestService::pegaValorDoCampoFILESOuLancaExcecao('imagens');
        $permitirComentarios = isset($_POST['permitirComentarios']) ? 1 : 0;
        $permitirCurtidas = isset($_POST['permitirCurtidas']) ? 1 : 0;

    }catch( Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    $entityManager = EntityManagerCreator::create();

    /** @var Publicacao */
    $publicacao = $entityManager->find(Publicacao::class, $id);

    $publicacao->edita(
        $titulo,
        $texto, 
        $data,
        $capa,
        $imagens, 
        $urlsVideos, 
        $permitirCurtidas,
        $permitirComentarios
    );


    

    $entityManager->flush();


    exit();


    try{

       

    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }


    try{

        $entityManager->persist($publicacao);
    
        $entityManager->flush();
    
        $publicacao->salvarCapa();
    
        $publicacao->salvarImagens();

        header('HTTP/1.1 200 OK');

    }catch(Exception){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Erro inesperado";
    }


?>