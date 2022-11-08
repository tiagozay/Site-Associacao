<?php

    use APBPDN\Models\Integrante;

    require_once 'vendor/autoload.php';

    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $imagem = $_FILES['imagem'];

    echo json_encode($imagem);
    exit();

    // $integrante = new Integrante($nome, $cargo, $imagem);

    // echo json_encode($integrante->toArray());
?>