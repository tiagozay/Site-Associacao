<?php
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Operacoes\OperacaoAdicionarPublicacao;
    use APBPDN\Models\Publicacao;
    use APBPDN\Services\LoginService;
    use APBPDN\Services\RequestService;
    use APBPDN\Services\VideoService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeUsuarioEAdmin()){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
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

    try{

        $publicacao = new Publicacao(
            $titulo,
            $data,
            $texto,
            $capa,
            $imagens,
            $urlsVideos,
            $permitirCurtidas,
            $permitirComentarios
        );

    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    $entityManager = EntityManagerCreator::create();

    try{

        $entityManager->persist($publicacao);
    
        $entityManager->flush();
    
        $publicacao->salvarCapa();
    
        $publicacao->salvarImagens();

        $operacao = new OperacaoAdicionarPublicacao(
            LoginService::buscaUsuarioLogado($entityManager)->getNome(),
            $publicacao->id
        );

        $entityManager->persist($operacao);

        $entityManager->flush();

        header('HTTP/1.1 200 OK');

        echo $publicacao->id;

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>