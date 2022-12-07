<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;
    use APBPDN\Models\Usuario;
    use APBPDN\Models\Operacoes\OperacaoCadastrarIntegrante;
    use APBPDN\Services\RequestService;
    use APBPDN\Services\LoginService;

    require_once 'vendor/autoload.php';


    if(!LoginService::verificaSeUsuarioEAdmin()){
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

        $entityManager = EntityManagerCreator::create();

        $entityManager->persist($integrante);
    
        $entityManager->flush();

        $operacao = new OperacaoCadastrarIntegrante(
            LoginService::buscaUsuarioLogado($entityManager),
            $integrante->getNome()
        );

        $entityManager->persist($operacao);

        $entityManager->flush();

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>