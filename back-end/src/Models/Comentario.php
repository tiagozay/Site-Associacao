<?php
    namespace APBPDN\Models;

    use DomainException;
    use Doctrine\ORM\Mapping\Column;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\ManyToOne;

    #[Entity()]
    class Comentario
    {
        #[Id(), GeneratedValue(), Column()]
        public int $id;

        #[ManyToOne(targetEntity:Publicacao::class, inversedBy: 'comentarios')]
        private Publicacao $publicacao;

        #[ManyToOne(targetEntity: Usuario::class)]
        private Usuario $usuario;

        #[Column(length: 400)]
        private string $comentario;

        /** @throws DomainException */
        public function __construct(Publicacao $publicacao, Usuario $usuario, string $comentario)
        {
            $comentario = trim($comentario);

            if( empty($comentario) || strlen($comentario) > 400) throw new DomainException();

            $this->publicacao = $publicacao;
            $this->usuario = $usuario;

            $usuario->setComentario($this);

            $this->comentario = $comentario;
            
        }

        public function getPublicacao(): Publicacao
        {
            return $this->publicacao;
        }

        public function getUsuario(): Usuario
        {
            return $this->usuario;
        }

        public function getComentario(): string
        {
            return $this->comentario;
        }
    }
?>