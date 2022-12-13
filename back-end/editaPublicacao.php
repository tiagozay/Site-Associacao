<?php
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Operacoes\OperacaoEditarPublicacao;
    use APBPDN\Models\Publicacao;
    use APBPDN\Services\RequestService;
    use APBPDN\Services\VideoService;
    use APBPDN\Services\LoginService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeUsuarioEAdmin()){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
        $id = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('id');
        $titulo = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('titulo');
        $data = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('data');
        $texto = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('texto');
        $quantidadeDeVideos = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('quantidadeDeNovosVideos');

        $urlsVideos = [];

        for($i = 1; $i <= $quantidadeDeVideos; $i++){
            $urlsVideos[] = VideoService::pegaUlrDeIframe($_POST["video$i"]);
        }

        $capa = RequestService::pegaValorDoCampoFILESOuLancaExcecao('capa');
        $novasImagens = RequestService::pegaValorDoCampoFILESOuLancaExcecao('novasImagens');
        $imagensRestantes = isset($_POST['imagensRestantes']) ? $_POST['imagensRestantes'] : [];
        $videosRestantes = isset($_POST['videosRestantes']) ? $_POST['videosRestantes'] : [];

        $imagensRestantes = json_decode($imagensRestantes);
        $videosRestantes = json_decode($videosRestantes);

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

    try{

        $publicacao->edita(
            $titulo,
            $texto, 
            $data,
            $capa,
            $novasImagens,
            $imagensRestantes,
            $urlsVideos,
            $videosRestantes,
            $permitirCurtidas,
            $permitirComentarios
        );

    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }


    try{
    
        $entityManager->flush();

        $operacao = new OperacaoEditarPublicacao(
            LoginService::buscaUsuarioLogado($entityManager)->getNome(),
            $publicacao->id
        );

        $entityManager->persist($operacao);

        $entityManager->flush();

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>