<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Usuario;

    require_once 'vendor/autoload.php';

    $ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'mais_antigos';
    $niveis = isset($_GET['niveis']) ? $_GET['niveis'] : 'todos';

    if($ordem != 'mais_antigos' && $ordem != 'mais_recentes' && $ordem != 'ordem_alfabetica'){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Ordem informada é inválida.";
        exit();
    }

    if($niveis != 'admin' && $niveis != 'usuario' && $niveis != 'todos'){
        header('HTTP/1.1 500 Internal Server Error');
        echo "Nivel informado é inválido.";
        exit();
    }


    $selectOrdem = [
        'mais_antigos' => [
            'id' => 'ASC'
        ],
        'mais_recentes' => [
            'id' => 'DESC'
        ],
        'ordem_alfabetica' => [
            'nome' => 'ASC'
        ],
    ];

    $selectNiveis = [
        'todos' => [],
        'admin' => ['nivel' => 'admin'],
        'usuario' => ['nivel' => 'usuario']
    ];


    try{

        $entityManeger = EntityManagerCreator::create();

        $usuarioRepository = $entityManeger->getRepository(Usuario::class);
    
        $usuarios = $usuarioRepository->findBy($selectNiveis[$niveis], $selectOrdem[$ordem]);
    
        $usuarios = Usuario::toArrays($usuarios);
    
        echo json_encode($usuarios);

        header('HTTP/1.1 200 OK');


    }catch( Throwable $e ){
        header('HTTP/1.1 500 Internal Server Error');
        echo $e->getMessage();
    }


?>