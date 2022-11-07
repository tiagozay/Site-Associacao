<?php
    namespace APBPDN\Helpers;

    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\ORMSetup;

    require_once "vendor/autoload.php";

    require_once "../credenciais-banco.php";

    class EntityManagerCreator
    {
        public static function create(): EntityManager
        {

            $config = ORMSetup::createAttributeMetadataConfiguration(
                [__DIR__."/.."],
                true, 
            );
       
            $conn = array(
                'driver' => 'pdo_mysql',
                'host' => HOST,
                'dbname' => DB_NAME,
                'user' => USER,
                'password' => PASSWORD,
            );

            // obtaining the entity manager
            return EntityManager::create($conn, $config);
        }
    }

?>