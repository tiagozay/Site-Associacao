<?php
    
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Comentario;
    use APBPDN\Services\LoginService;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeUsuarioEAdmin()){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
        $idComentario = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('id');
    }catch( Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    $entityManager = EntityManagerCreator::create();

    $comentario = $entityManager->find(Comentario::class, $idComentario);

    try{

        $entityManager->remove($comentario);

        $entityManager->flush();
    
        $publicacao = $comentario->getPublicacao();
    
        $comentarios = $publicacao->getComentarios();
    
        echo json_encode(Comentario::toArrays($comentarios->toArray()));

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

?>