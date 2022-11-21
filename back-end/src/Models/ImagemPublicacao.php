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
        public readonly Publicacao $publicacao;

        #[Column(length:50)]
        public readonly string $nome;

        public function __construct(Publicacao $publicacao, string $nome)
        {
            $this->publicacao = $publicacao;
            $this->nome = $nome;
        }

        public static function toArrays($imagens): array 
        {

            return array_map(function($imagem){
                return $imagem->toArray();
            }, $imagens);
        }

        public function toArray(): array
        {
            return [
                'id' => $this->id,
                'id_publicacao' => $this->publicacao->id,
                'nome' => $this->nome
            ];
        }
    }
?>