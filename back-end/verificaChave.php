<?php
    session_start();

    use APBPDN\Services\RequestService;

    require "vendor/autoload.php";

    try{    
        $chaveDigitada = RequestService::pegaValorDoCampoPOSTOuLancaExcecao('chave');
    }catch(\Exception $e){
        header('HTTP/1.1 500 Internal Server Error');   
        echo $e->getMessage();
        exit();
    }

    $chaveGerada = isset($_SESSION['chave']) ? $_SESSION['chave'] : exit();

    if($chaveDigitada != $chaveGerada){
        header('HTTP/1.1 500 Internal Server Error');   
        echo "Chave inválida";
        $_SESSION['permissaoParaRedefinir'] = false;
    }else{
        header('HTTP/1.1 200 OK');
        echo "Chave correta";
        $_SESSION['permissaoParaRedefinir'] = true;
    }


?>