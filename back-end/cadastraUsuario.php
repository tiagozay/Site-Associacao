<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\LoginService;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    try{
        $nome =  RequestService::pegaValorDoCampoPOSTOuLancaExcecao('nome');
        $email = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('email');
        $senha = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('senha');
        $confSenha = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('confSenha');        
    }catch( Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    $entityManeger = EntityManagerCreator::create();

    $userRepository = $entityManeger->getRepository(Usuario::class);

    $usuarioComEmail = $userRepository->findOneBy(['email' => $email]);

    if($usuarioComEmail){
        header('HTTP/1.1 500 Internal Server Error');
        echo "usuario_ja_cadastrado";
        exit();
    }

    //Instância e validação das regras de negócio
    try{
        $usuario = new Usuario($nome, $email, 'usuario', $senha, $confSenha);
    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{

        $entityManeger = EntityManagerCreator::create();

        $entityManeger->persist($usuario);
    
        $entityManeger->flush();

        LoginService::setarSessoes($usuario);

        header('HTTP/1.1 200 OK');

    }catch(Exception){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Erro inesperado";
    }


?>