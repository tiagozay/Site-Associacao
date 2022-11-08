<?php
    namespace APBPDN\Models;

    class ImagemPublicacao
    {
        public int $id;
        public readonly Publicacao $publicaco;
        public readonly string $nome;

        public function __construct(Publicacao $publicacao, string $nome)
        {
            $this->publicaco = $publicacao;
            $this->nome = $nome;
        }
    }
?>