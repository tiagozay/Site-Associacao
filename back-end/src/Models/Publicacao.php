<?php
    namespace APBPDN\Models;

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Services\ImagemService;
    use DateTime;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping\Column;
    use DomainException;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\OneToMany;

    #[Entity()]
    class Publicacao
    {
        #[Id(), GeneratedValue(), Column()]
        public int $id;

        #[Column()]
        private string $titulo;

        #[Column(name: 'dataRegistro', type:'date')]
        private DateTime $data;

        #[Column()]
        private string $texto;

        #[Column(length:50)]
        private string $capa;

        #[Column()]
        public bool $permitirCurtidas;

        #[Column()]
        public bool $permitirComentarios;

        #[OneToMany(mappedBy: 'publicacao', targetEntity: ImagemPublicacao::class, cascade:['persist', 'remove'])]
        private Collection $imagens;

        #[OneToMany(mappedBy: 'publicacao', targetEntity: VideoPublicacao::class, cascade:['persist', 'remove'])]
        private Collection $videos;

        #[OneToMany(mappedBy: 'publicacao', targetEntity: Comentario::class, cascade:['persist', 'remove'])]
        private Collection $comentarios;

        #[OneToMany(mappedBy: 'publicacao', targetEntity: Curtida::class, cascade:['persist', 'remove'])]
        private Collection $curtidas;

        /** @throws DomainException */
        public function __construct(string $titulo, DateTime $data, string $texto, array $capa, array $imagens, array $urlsVideos, bool $permitirCurtidas, bool $permitirComentarios)
        {
            $this->imagens = new ArrayCollection();
            $this->videos = new ArrayCollection();
            $this->comentarios = new ArrayCollection();
            $this->curtidas = new ArrayCollection();

            $this->setTitulo($titulo);
            $this->setData($data);
            $this->setTexto($texto);
            $this->setCapa($capa);
            $this->setImagens($imagens);
            $this->setVideos($urlsVideos);
            $this->permitirCurtidas = $permitirCurtidas;
            $this->permitirComentarios = $permitirComentarios;

        }

        /** @throws DomainException */
        public function edita(string $titulo, string $texto, DateTime $data, array $capa, array $imagens, array $urlsVideos, bool $permitirCurtidas, bool $permitirComentarios)
        {
            $this->setTitulo($titulo);
            $this->setTexto($texto);
            $this->setData($data);
            $this->permitirComentarios = $permitirComentarios;
            $this->permitirCurtidas = $permitirCurtidas;

            //Verifica se uma nova capa foi informada, se sim, sobreescreve a antiga
            if(!ImagemService::imagemNaoInformada($capa)){
                ImagemService::removeImagemDoDiretorio(caminhoImagem: "assets/imagens_dinamicas/capas_publicacoes/{$this->capa}");

                $this->setCapa($capa);
            }

            //Verifica se foram informadas novas imagens
            if($imagens['error'][0] != 4){
                $this->setImagens($imagens);
            }

            //Verifica se foram informadas novos videos
            if(count($urlsVideos) > 0){
                $this->setVideos($urlsVideos);
            }
        }

        /** @throws DomainException */
        public function comentar(string $comentario, Usuario $usuario)
        {
            $comentario = new Comentario($this, $usuario, $comentario);

            $this->setComentario($comentario);
        }

        /** @throws DomainException */
        public function curtir(Usuario $usuario)
        {
            if($this->verificaSeUsuarioJaCurtiu($usuario)){

                $this->descurtir($usuario);

                return;
            }

            $curtida = new Curtida($this, $usuario);

            $this->setCurtida($curtida);
        }

        public function verificaSeUsuarioJaCurtiu(Usuario $usuario): bool
        {
            return $this->buscaCurtidaDeUsuario($usuario) ? true : false;
        }

        private function buscaCurtidaDeUsuario(Usuario $usuario): ?Curtida
        {
            return array_filter($this->curtidas->toArray(), function($curtida){

                global $usuario;

                if($curtida->getUsuario()->id == $usuario->id){
                    return true;
                }
            })[0];
        }

        /** @throws DomainException */
        public function setTitulo(string $titulo): void
        {
            $titulo = trim($titulo);

            if(empty($titulo)) throw new DomainException('campo_vazio');

            $this->titulo = $titulo;
        }

        /** @throws DomainException */
        public function setData(DateTime $data): void
        {
            $this->data = $data;
        }
        
        /** @throws DomainException */
        public function setTexto(string $texto): void
        {
            $texto = trim($texto);

            if(empty($texto)) throw new DomainException('campo_vazio');

            $this->texto = $texto;
        }

        /** @throws DomainException */
        public function setCapa(array $capa): void
        {
            ImagemService::validaImagem($capa);

            $novoNomeCapa = ImagemService::geraNomeParaImagem($capa);

            $capa['name'] = $novoNomeCapa;

            ImagemService::salvaImagemNoDiretorio(imagem: $capa, diretório: "assets/imagens_dinamicas/capas_publicacoes/");

            $this->capa = $novoNomeCapa;
        }

        /** @throws DomainException */
        public function setImagens(array $imagens): void
        {
            $imagens = ImagemService::transofrmaArrayDeImagensHttpParaOutroFormato($imagens);

            foreach ($imagens as $imagem) {
                ImagemService::validaImagem($imagem);
            }

            foreach ($imagens as $imagem) {

                $novoNomeImagem = ImagemService::geraNomeParaImagem($imagem);

                $imagem['name'] = $novoNomeImagem;

                ImagemService::salvaImagemNoDiretorio(imagem: $imagem, diretório: "assets/imagens_dinamicas/imagens_publicacoes/");

                $this->imagens[] = new ImagemPublicacao($this, $novoNomeImagem);

            }
       
        }

        /** @throws DomainException */
        public function setVideos(array $urlsVideos): void
        {
            foreach ($urlsVideos as $urlVideo) {

                $video = new VideoPublicacao($this, $urlVideo);

                $this->videos->add($video);
                
            }       
        }

        private function setComentario(Comentario $comentario): void
        {
            $this->comentarios->add($comentario);
        }

        private function setCurtida(Curtida $curtida): void
        {
            $this->curtidas->add($curtida);
        }

        public function excluirComentario(Comentario $comentario): void
        {
            $entityManager = EntityManagerCreator::create();

            $entityManager->remove($comentario);

            $entityManager->flush();
        }

        private function descurtir(Usuario $usuario): void
        {
            $curtida = $this->buscaCurtidaDeUsuario($usuario);

            $entityManager = EntityManagerCreator::create();

            $entityManager->remove($curtida);

            $entityManager->flush();
        }

        private function buscaChaveComentario(Comentario $comentario): ?int
        {
            $chave = null;

            for($i = 0; $i < $this->comentarios->count(); $i++){
                if($this->comentarios->get($i)->id == $comentario->id){
                    $chave = $i;
                    break;
                }
            }

            return $chave;
        }

        private function buscaChaveCurtida(Curtida $curtida): ?int
        {
            $chave = null;

            for($i = 0; $i < $this->curtidas->count(); $i++){
                if($this->curtidas->get($i)->id == $curtida->id){
                    $chave = $i;
                    break;
                }
            }

            return $chave;
        }

        private function buscaChaveVideo(VideoPublicacao $video): ?int
        {
            $chave = null;

            for($i = 0; $i < $this->videos->count(); $i++){
                if($this->videos->get($i)->id == $video->id){
                    $chave = $i;
                    break;
                }
            }

            return $chave;
        }

        private function buscaChaveImagem(ImagemPublicacao $imagem): ?int
        {
            $chave = null;

            for($i = 0; $i < $this->imagens->count(); $i++){
                if($this->imagens->get($i)->id == $imagem->id){
                    $chave = $i;
                    break;
                }
            }

            return $chave;
        }

       


        public function getTitulo(): string
        {
            return $this->titulo;
        }

        public function getData(): DateTime
        {
            return $this->data;
        }

        public function getTexto(): string
        {
            return $this->texto;
        }

        public function getCapa(): string
        {
            return $this->capa;
        }

        /** @return ImagemPublicacao[] */
        public function getImagens(): iterable
        {
            return $this->imagens;
        }

          /** @return VideoPublicacao[] */
          public function getVideos(): iterable
          {
              return $this->videos;
          }

        /** @return Comentario[] */
        public function getComentarios(): iterable
        {
            return $this->comentarios;
        }

        /** @return Curtida[] */
        public function getCurtidas(): iterable
        {
            return $this->curtidas;
        }

        public function getQuantidadeCurtidas(): int
        {
            return $this->curtidas->count();
        }

        public function getQuantidadeComentarios(): int
        {
            return $this->comentarios->count();
        }
        

    }
?>