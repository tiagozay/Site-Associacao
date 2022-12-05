<?php
    
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Comentario;
    use APBPDN\Models\Publicacao;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\LoginService;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeHaUsuarioLogado()){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
        $idPublicacao = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('idPublicacao');
        $idUsuario = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('idUsuario');
        $comentario = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('comentario');
    }catch( Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    $entityManager = EntityManagerCreator::create();

    /** @var Publicacao */
    $publicacao = $entityManager->find(Publicacao::class, $idPublicacao);

    /** @var Usuario */
    $usuario = $entityManager->find(Usuario::class, $idUsuario);


    try{

        $publicacao->comentar($comentario, $usuario);

        $entityManager->flush();

        $comentarios = $publicacao->getComentarios();

        echo json_encode(Comentario::toArrays($comentarios->toArray()));

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

?>