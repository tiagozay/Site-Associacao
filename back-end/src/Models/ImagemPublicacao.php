<?php
    namespace APBPDN\Models;

    use Doctrine\ORM\Mapping\Column;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\ManyToOne;

    #[Entity()]
    class ImagemPublicacao
    {
        #[Id(), GeneratedValue(), Column()]
        public int $id;

        #[ManyToOne(targetEntity: Publicacao::class, inversedBy: 'imagens')]
        public readonly Publicacao $publicaco;

        #[Column(length:50)]
        public readonly string $nome;

        public function __construct(Publicacao $publicacao, string $nome)
        {
            $this->publicaco = $publicacao;
            $this->nome = $nome;
        }
    }
?>