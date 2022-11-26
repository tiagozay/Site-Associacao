<?php
    namespace APBPDN\Models;

    use APBPDN\Helpers\EntityManagerCreator;
    use APBPDN\Services\ImagemService;
    use APBPDN\Services\VideoService;
    use DateTime;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping\Column;
    use DomainException;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\OneToMany;
    use stdClass;

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

        private $capaTemporaria;
        private $imagensTemporarias;


        /** @throws DomainException */
        public function __construct(string $titulo, string $data, string $texto, array $capa, array $imagens, array $urlsVideos, bool $permitirCurtidas, bool $permitirComentarios)
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
        public function edita(string $titulo, string $texto, string $data, array $capa, array $novasImagens, array $imagensRestantes, array $urlsVideos, array $videosRestantes ,bool $permitirCurtidas, bool $permitirComentarios)
        {
            $this->setTitulo($titulo);
            $this->setTexto($texto);
            $this->setData($data);
            $this->permitirComentarios = $permitirComentarios;
            $this->permitirCurtidas = $permitirCurtidas;

            //Verifica se uma nova capa foi informada, se sim, sobreescreve a antiga
            if(!ImagemService::imagemNaoInformada($capa)){
                ImagemService::removeImagemDoDiretorio(
                    caminhoImagem: __DIR__."\..\..\..\assets\imagens_dinamicas\capas_publicacoes\\{$this->capa}"
                );

                $this->setCapa($capa);

                $this->salvarCapa();
            }

            //Verifica se a quantidade de imagens que a publicação tem é maior que a que veio do cliente, se isso aconetecer é porque o usuário excluíu imagens, aí ele cai na função para removê-las do servidor
            if($this->getImagens()->count() > count($imagensRestantes)){
                $this->removeImagensQueForamExcluidasPeloUsuario($imagensRestantes);
            }

            //Verifica se a quantidade de videos que a publicação tem é maior que a que veio do cliente, se isso aconetecer é porque o usuário excluíu videos, aí ele cai na função para removê-los do servidor
            if($this->getVideos()->count() > count($videosRestantes)){
                $this->removeVideosQueForamExcluidasPeloUsuario($videosRestantes);
            }
          
            //Verifica se foram informadas novas imagens
            if($novasImagens['error'][0] != 4){
                $this->setImagens($novasImagens);

                $this->salvarImagens();
            }

            //Verifica se foram informadas novos videos
            if(count($urlsVideos) > 0){
                $this->setVideos($urlsVideos);
            }
        }

        private function removeImagensQueForamExcluidasPeloUsuario(array $imagensVindasDoUsuario)
        {
            $entityManager = EntityManagerCreator::create();

            /** @var ArrayCollection */
            $imagensPublicacao = $this->getImagens();

            foreach($imagensPublicacao->toArray() as $imagem){

                if($this->verificaSeImagemFoiExcluidaPeloUsuario($imagem->id, $imagensVindasDoUsuario)){

                    $imagemParaExcluir = $entityManager->find(ImagemPublicacao::class, $imagem->id);

                    $entityManager->remove($imagemParaExcluir);

                    ImagemService::removeImagemDoDiretorio(
                        caminhoImagem: __DIR__."\..\..\..\assets\imagens_dinamicas\imagens_publicacoes\\{$imagemParaExcluir->nome}"
                    );

                }

            }

            $entityManager->flush();         

        }

        private function verificaSeImagemFoiExcluidaPeloUsuario(int $id, array $imagensDoUsuario)
        {
            //Percorre o array de imagens que vieram do usuario buscando por id, se não encontrar é sinal que foi excluída, se encontrar, não foi excluída
            $imagemEncontrada = null;

            foreach($imagensDoUsuario as $imagem){
                if($imagem->id == $id){
                    $imagemEncontrada = $imagem;
                    break;
                }
            }

            return $imagemEncontrada ? false : true; 
        }

        private function removeVideosQueForamExcluidasPeloUsuario(array $videosVindosDoUsuario)
        {
            $entityManager = EntityManagerCreator::create();

            /** @var ArrayCollection */
            $videosPublicacao = $this->getVideos();

            foreach($videosPublicacao->toArray() as $video){

                if($this->verificaSeVideoFoiExcluidoPeloUsuario($video->id, $videosVindosDoUsuario)){

                    $videoParaExcluir = $entityManager->find(VideoPublicacao::class, $video->id);

                    $entityManager->remove($videoParaExcluir);
                }

            }

            $entityManager->flush();         

        }

        private function verificaSeVideoFoiExcluidoPeloUsuario(int $id, array $videosDoUsuario)
        {
            //Percorre o array de videos que do usuario buscando por id, se não encontrar é sinal que foi excluído, se encontrar, não foi excluído
            $videoEncontrado = null;

            foreach($videosDoUsuario as $video){
                if($video->id == $id){
                    $videoEncontrado = $video;
                    break;
                }
            }

            return $videoEncontrado ? false : true; 
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
        public function setData(string $data): void
        {
            $data = trim($data);

            if(empty($data)) throw new DomainException('campo_vazio');

            $this->data = new DateTime($data);
        }
        
        /** @throws DomainException */
        public function setTexto(string $texto): void
        {
            $texto = trim($texto);

            $this->texto = $texto;
        }

        /** @throws DomainException */
        public function setCapa(array $capa): void
        {
            ImagemService::validaImagem($capa);

            $novoNomeCapa = ImagemService::geraNomeParaImagem($capa);

            $capa['name'] = $novoNomeCapa;

            $this->capaTemporaria = $capa;

            $this->capa = $novoNomeCapa;
        }

        public function salvarCapa(): void
        {
            ImagemService::salvaImagemNoDiretorio(
                imagem: $this->capaTemporaria,
                diretorio: __DIR__."\..\..\..\assets\imagens_dinamicas\capas_publicacoes\\"
            );

            $this->capaTemporaria = null;
        }

        public function removerCapa(): void
        {
            ImagemService::removeImagemDoDiretorio(
                __DIR__."\..\..\..\assets\imagens_dinamicas\capas_publicacoes\\".$this->getCapa()
            );
        }

        /** @throws DomainException */
        public function setImagens(array $imagens): void
        {

            //Se não foram informadas imagens, não faz nada
            if($imagens['error'][0] == 4){
                return;
            }

            $imagens = ImagemService::transofrmaArrayDeImagensHttpParaOutroFormato($imagens);

            foreach ($imagens as $imagem) {
                ImagemService::validaImagem($imagem);
            }

            foreach ($imagens as $imagem) {

                $novoNomeImagem = ImagemService::geraNomeParaImagem($imagem);

                $imagem['name'] = $novoNomeImagem;

                $this->imagensTemporarias[] = $imagem;
        
                $this->imagens->add(new ImagemPublicacao($this, $novoNomeImagem));

            }       
        }

        public function salvarImagens(): void
        {
            //Se não tiber imagens, não faz nada
            if(!$this->imagensTemporarias){
                return;
            }

            foreach ($this->imagensTemporarias as $imagem) {

                ImagemService::salvaImagemNoDiretorio(
                    imagem: $imagem, 
                    diretorio: __DIR__."\..\..\..\assets\imagens_dinamicas\imagens_publicacoes\\"
                );

            }

            $this->imagensTemporarias = null;
        }

        public function removerImagens(): void
        {
            /** @var ImagemPublicacao[] */
            $imagens = $this->getImagens();

            foreach($imagens as $imagem){
                ImagemService::removeImagemDoDiretorio(
                    __DIR__."\..\..\..\assets\imagens_dinamicas\imagens_publicacoes\\".$imagem->nome
                );
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
        
        public static function toArraysSimples($publicacoes): array 
        {
            return array_map(function($publicacao){
                return $publicacao->toArraySimples();
            }, $publicacoes);
        }

        public static function toArrays($publicacoes): array 
        {
            return array_map(function($publicacao){
                return $publicacao->toArray();
            }, $publicacoes);
        }

        public function toArraySimples(): array
        {
            return [
                'id' => $this->id,
                'titulo' => $this->getTitulo(),
                'data' => $this->getData(),
                'capa' => $this->getCapa(),
                'quantidadeComentarios' => $this->getQuantidadeComentarios(),
                'quantidadeCurtidas' => $this->getQuantidadeCurtidas(),
            ];
        }

        public function toArray(): array
        {
            return [
                'id' => $this->id,
                'titulo' => $this->getTitulo(),
                'data' => $this->getData(),
                'texto' => $this->getTexto(),
                'capa' => $this->getCapa(),
                'permitirCurtidas' => $this->permitirCurtidas,
                'permitirComentarios' => $this->permitirComentarios,
                'imagens' => ImagemPublicacao::toArrays($this->getImagens()->toArray()),
                'videos' => VideoPublicacao::toArrays($this->getVideos()->toArray()),
                'comentarios' => Comentario::toArrays($this->getComentarios()->toArray()),
                'curtidas' => Curtida::toArrays($this->getCurtidas()->toArray()),
                'quantidadeComentarios' => $this->getQuantidadeComentarios(),
                'quantidadeCurtidas' => $this->getQuantidadeCurtidas(),
            ];
        }

    }
?>