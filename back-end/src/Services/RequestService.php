<?php
    namespace APBPDN\Services;

    class RequestService
    {

        //Função utlizada onde é obrigatório que determinado campo seja informado
        /** @throws Exception */
        public static function pegaValorDoCampoPOSTOuLancaExcecao(string $nomeDoCampo)
        {
            if(isset($_POST[$nomeDoCampo])){
                return $_POST[$nomeDoCampo];
            }

            throw new \Exception("Campo $nomeDoCampo não informado");
        }

        //Função utlizada onde é obrigatório que determinado campo seja informado
        /** @throws Exception */
        public static function pegaValorDoCampoFILESOuLancaExcecao(string $nomeDoCampo)
        {
            if(isset($_FILES[$nomeDoCampo])){
                return $_FILES[$nomeDoCampo];
            }

            throw new \Exception("Campo $nomeDoCampo não informado");
        }

        //Função utlizada onde é obrigatório que determinado campo seja informado
        /** @throws Exception */
        public static function pegaValorDoCampoGETOuLancaExcecao(string $nomeDoCampo)
        {
            if(isset($_GET[$nomeDoCampo])){
                return $_GET[$nomeDoCampo];
            }

            throw new \Exception("Campo $nomeDoCampo não informado");
        }
    }
?>