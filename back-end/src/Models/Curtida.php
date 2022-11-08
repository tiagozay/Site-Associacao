<?php
    namespace APBPDN\Models;

    use DomainException;

    class Curtida
    {
        public int $id;
        private Publicacao $publicacao;
        private Usuario $usuario;

        /** @throws DomainException */
        public function __construct(Publicacao $publicacao, Usuario $usuario)
        {
            $this->publicacao = $publicacao;
            $this->usuario = $usuario;
        }

        public function getPublicacao(): Publicacao
        {
            return $this->publicacao;
        }

        public function getUsuario(): Usuario
        {
            return $this->usuario;
        }
    }
?>