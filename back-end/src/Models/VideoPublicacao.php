<?php
    namespace APBPDN\Models;

    use Doctrine\ORM\Mapping\Column;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\ManyToOne;

    #[Entity()]
    class VideoPublicacao
    {
        #[Id(), GeneratedValue(), Column()]
        public int $id;

        #[ManyToOne(targetEntity: Publicacao::class, inversedBy: 'videos')]
        public readonly Publicacao $publicaco;

        #[Column()]
        public readonly string $url;

        public function __construct(Publicacao $publicacao, string $url)
        {
            $this->publicaco = $publicacao;
            $this->url = $url;
        }
    }
?>