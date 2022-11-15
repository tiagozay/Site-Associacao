<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;

    require_once 'vendor/autoload.php';

    session_start();

    $_SESSION['nivel'] = 'admin';

    if($_SESSION['nivel'] != 'admin'){
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado!";
        exit();
    }

    try{
        $nome =  isset($_POST['nome']) ? $_POST['nome'] : throw new Exception('Campo nome não informado');
        $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : throw new Exception('Campo cargo não informado');
        $imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : throw new Exception('Campo imagem não informado');
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

    echo json_encode($integrante->salvarImagem());

    try{

        

        $entityManeger = EntityManagerCreator::create();

        $entityManeger->persist($integrante);
    
        $entityManeger->flush();

        header('HTTP/1.1 200 OK');

    }catch(Exception){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Erro inesperado";
    }


?>