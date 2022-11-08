<?php
    namespace APBPDN\Models;

    use DomainException;

    class Comentario
    {
        public int $id;
        private Publicacao $publicacao;
        private Usuario $usuario;
        private string $comentario;

        /** @throws DomainException */
        public function __construct(Publicacao $publicacao, Usuario $usuario, string $comentario)
        {
            $this->publicacao = $publicacao;
            $this->usuario = $usuario;

            $comentario = trim($comentario);

            if( empty($comentario) || strlen($comentario) > 400) throw new DomainException();

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