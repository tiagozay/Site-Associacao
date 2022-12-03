<?php
    require_once 'vendor/autoload.php';

    use APBPDN\Services\LoginService;

    LoginService::limparSessoes();

    header('Location: ../index.php');
?>