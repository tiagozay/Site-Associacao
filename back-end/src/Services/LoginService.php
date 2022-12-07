<?php
    namespace APBPDN\Services;

    use APBPDN\Models\Usuario;
    use APBPDN\Helpers\EntityManagerCreator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
    use Exception;

    // require_once '../vendor/autoload.php';

    class LoginService
    {
        public static function setarSessoes(Usuario $usuario)
        {
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }
          
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nome'] = $usuario->getNome();
            $_SESSION['nivel'] = $usuario->getNivel();
        }

        public static function limparSessoes()
        {
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }

            unset($_SESSION['id']);
            unset($_SESSION['nome']);
            unset($_SESSION['nivel']);
        }

        public static function verificaSeHaUsuarioLogado(): bool
        {
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }

            return isset($_SESSION['id']);
        }

        public static function verificaSeUsuarioEAdmin(): bool
        {
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }

            return $_SESSION['nivel'] == 'admin';
        }

        public static function testaSenha(string $senhaDigitada, Usuario $usuario): bool
        {
            return password_verify($senhaDigitada, $usuario->getSenha());
        }

        /** @throws Exception */
        public static function buscaUsuarioLogado(EntityManager $entityManager): ?Usuario
        {
            if(!LoginService::verificaSeHaUsuarioLogado()){
                throw new Exception("Não há um usuário logado");
            }

            return $entityManager->find(Usuario::class, $_SESSION['id']);
        }

        public static function buscaQuantidadeDeTentativasUsuario(Usuario $usuario): int 
        {
            $host = HOST;
            $db_name = DB_NAME;
            $user = USER;
            $password = PASSWORD;

            $pdo = new \PDO("mysql:host=$host;dbname=$db_name", "$user", "$password");

            $timezone = new \DateTimeZone('America/Sao_Paulo');
            $agora = new \DateTime('now', $timezone);
            $diaDeHoje = $agora->format("d");
            $mes = $agora->format('m');
            $ano = $agora->format('Y');
            $horario = $agora->format("H:i:s");


            //Busca na tabela de tentativas registros de determinado usuário, que sejem do dia, mes e ano (data) atual e que a diferença do horário atual com cada registro seja menor que 15 minutos. Assim, toda tentativa desse usuário nesse dia que tenha menos de 15 minutos do acontecimento será buscado.
            $stmt = $pdo->prepare("
                SELECT * FROM tentativas_de_login 
                WHERE email = :email AND 
                DAY(dataRegistro) = '$diaDeHoje' AND
                MONTH(dataRegistro) = $mes AND
                YEAR(dataRegistro) = $ano AND
                TIMEDIFF('$horario',TIME(dataRegistro)) < '00:15:00'"
            );

            
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->execute();

            return count($stmt->fetchAll(\PDO::FETCH_ASSOC));

        }

        public static function adicionaTentativaDeUsuario(Usuario $usuario)
        {
            $host = HOST;
            $db_name = DB_NAME;
            $user = USER;
            $password = PASSWORD;

            $pdo = new \PDO("mysql:host=$host;dbname=$db_name", "$user", "$password");

            $timezone = new \DateTimeZone('America/Sao_Paulo');
            $agora = new \DateTime('now', $timezone);
            $data = $agora->format("Y-m-d H:i:s");

            $stmt = $pdo->prepare("INSERT INTO tentativas_de_login (email, dataRegistro) values (:email, '$data')");
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->execute();

        }


    }


?>