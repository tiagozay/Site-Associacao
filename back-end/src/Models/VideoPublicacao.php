<?php
    namespace APBPDN\Models;

    class VideoPublicacao
    {
        public int $id;
        public readonly Publicacao $publicaco;
        public readonly string $url;

        public function __construct(Publicacao $publicacao, string $url)
        {
            $this->publicaco = $publicacao;
            $this->url = $url;
        }
    }
?>