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
        public readonly Publicacao $publicacao;

        #[Column()]
        public readonly string $url;

        public function __construct(Publicacao $publicacao, string $url)
        {
            $this->publicacao = $publicacao;
            $this->url = $url;
        }

        public static function toArrays($videos): array 
        {
            return array_map(function($video){
                return $video->toArray();
            }, $videos);
        }

        public function toArray(): array
        {
            return [
                'id' => $this->id,
                'id_publicacao' => $this->publicacao->id,
                'url' => $this->url
            ];
        }
    }
?>