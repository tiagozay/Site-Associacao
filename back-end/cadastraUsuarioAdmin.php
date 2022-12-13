<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Operacoes\OperacaoCadastrarUsuario;
    use APBPDN\Models\Usuario;
    use APBPDN\Services\RequestService;
    use APBPDN\Services\LoginService;

    require_once 'vendor/autoload.php';

    if(!LoginService::verificaSeUsuarioEAdmin()){
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

    $entityManager = EntityManagerCreator::create();

    $userRepository = $entityManager->getRepository(Usuario::class);

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

        $entityManager = EntityManagerCreator::create();

        $entityManager->persist($usuario);
    
        $entityManager->flush();

        $operacao = new OperacaoCadastrarUsuario(
            LoginService::buscaUsuarioLogado($entityManager)->getNome(),
            $usuario->getNome()
        );

        $entityManager->persist($operacao);

        $entityManager->flush();

        header('HTTP/1.1 200 OK');

    }catch(Throwable $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();

    }


?>