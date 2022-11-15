<?php

    use APBPDN\Models\Usuario;
    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Services\LoginService;

    require_once 'vendor/autoload.php';

    try{
        $email = isset($_POST['email']) ? $_POST['email'] : throw new Exception('Campo email não informado');
        $senha = isset($_POST['senha']) ? $_POST['senha'] : throw new Exception('Campo senha não informado');  
    }catch( Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    try{
        Usuario::validaEmail($email);
        Usuario::validaSenha($senha);
    }catch(DomainException $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
        exit();
    }

    $entityManeger = EntityManagerCreator::create();

    $userRepository = $entityManeger->getRepository(Usuario::class);

    $usuario = $userRepository->findOneBy(['email' => $email]);

    if(!$usuario){
        header('HTTP/1.1 500 Internal Server Error');
        echo "usuario_nao_encontrado";
        exit();
    }

    $teste = LoginService::testaSenha($senha, $usuario);

    if(!$teste){
        header('HTTP/1.1 500 Internal Server Error');
        echo "senha_invalida";
        exit();
    }

    LoginService::setarSessoes($usuario);

    header('HTTP/1.1 200 OK');

?>