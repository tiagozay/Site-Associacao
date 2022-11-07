<?php

    use Doctrine\ORM\Tools\Console\ConsoleRunner;
    use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
    use APBPDN\Helpers\EntityManagerCreator;

    require_once 'vendor/autoload.php';


    $entityManager = EntityManagerCreator::create();

    ConsoleRunner::run(
        new SingleManagerProvider($entityManager),
    );