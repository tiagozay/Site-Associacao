<?php
    namespace APBPDN\Services;

    use APBPDN\Models\Usuario;

    class LoginService
    {
        public static function setarSessoes(Usuario $usuario)
        {
            session_start();

            $_SESSION['id'] = $usuario->id;
            $_SESSION['nome'] = $usuario->getNome();
            $_SESSION['nivel'] = $usuario->getNivel();
        }

        public static function limparSessoes()
        {
            session_start();

            unset($_SESSION['id']);
            unset($_SESSION['nome']);
            unset($_SESSION['nivel']);
        }

        public static function testaSenha(string $senhaDigitada, Usuario $usuario): bool
        {
            return password_verify($senhaDigitada, $usuario->getSenha());
        }

    }


?>