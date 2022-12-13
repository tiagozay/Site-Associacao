<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;
    use APBPDN\Models\Operacoes\OperacaoEditarIntegrante;
    use APBPDN\Services\RequestService;
    use APBPDN\Services\LoginService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeUsuarioEAdmin()){
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
        
        $entityManager = EntityManagerCreator::create();

        /** @var Integrante */
        $integrante = $entityManager->find(Integrante::class, $id);
    
        $integrante->edita($nome, $cargo, $imagem);
    
        $entityManager->flush();

        $operacao = new OperacaoEditarIntegrante(
            LoginService::buscaUsuarioLogado($entityManager)->getNome(),
            $integrante->getNome()
        );

        $entityManager->persist($operacao);

        $entityManager->flush();
    
    }catch( Throwable $e ){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>