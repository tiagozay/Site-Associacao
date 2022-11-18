<?php

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Models\Integrante;

    require_once 'vendor/autoload.php';

    $entityManeger = EntityManagerCreator::create();

    $integranteRepository = $entityManeger->getRepository(Integrante::class);

    $integrantes = $integranteRepository->findAll();

    $integrantes = Integrante::toArrays($integrantes);

    $integrantesOrdenados = Integrante::ordenaIntegrantesPorCargo($integrantes);

    echo json_encode($integrantesOrdenados);
?>