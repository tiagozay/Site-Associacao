<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\RequestService;

    require_once 'vendor/autoload.php';

    session_start();

    $_SESSION['nivel'] = 'admin';

    if($_SESSION['nivel'] != 'admin'){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
        $nome = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('nome');
        $email = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('email');
        $nivel = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('nivel');
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
        $usuario = new Usuario($nome, $email, $nivel, $senha, $confSenha);
    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{

        $entityManeger = EntityManagerCreator::create();

        $entityManeger->persist($usuario);
    
        $entityManeger->flush();

        header('HTTP/1.1 200 OK');

    }catch(Exception){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Erro inesperado";
    }


?>