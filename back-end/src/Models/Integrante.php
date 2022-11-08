<?php
    namespace APBPDN\Models;

    use APBPDN\Services\ImagemService;
    use Doctrine\ORM\Mapping\Column;
    use DomainException;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;

    class Integrante
    {
        #[Column, Id, GeneratedValue]
        public int $id;

        private string $nome;
        private string $cargo;
        private string $nomeImagem;


        /** @throws DomainException */
        public function __construct(string $nome, string $cargo, array $imagem)
        {
            $this->setNome($nome);
            $this->setCargo($cargo);
            $this->setImagem($imagem);
        }

        /** @throws DomainException */
        public function setNome(string $nome): void
        {
            $nome = trim($nome);

            if(empty($nome)) throw new DomainException("campo_vazio");

            if(strlen($nome) > 90) throw new DomainException("nome_grande");

            $this->nome = $nome;
        }

        /** @throws DomainException */
        public function setCargo(string $cargo): void
        {
            $cargo = trim($cargo);

            if(empty($cargo)) throw new DomainException("campo_vazio");

            if(strlen($cargo) > 25) throw new DomainException("cargo_invalido");

            $this->cargo = $cargo;
        }

        /** @throws DomainException */
        public function setImagem(array $imagem): void
        {

            ImagemService::validaImagem($imagem);

            $novoNomeImagem = ImagemService::geraNomeParaImagem($imagem);

            $imagem['name'] = $novoNomeImagem;

            ImagemService::salvaImagemNoDiretorio(imagem: $imagem, diretório: "assets/imagens_dinamicas/imagens_integrantes/");

            $this->nomeImagem = $novoNomeImagem;
        }

        public function getNome(): string
        {
            return $this->nome;
        }

        public function getCargo(): string
        {
            return $this->cargo;
        }

        public function getNomeImagem(): string
        {
            return $this->nomeImagem;
        }

        public function edita(string $nome, string $cargo, array $imagem): void
        {
            //Verifica se uma nova imagem foi selecionada, se não foi, altera somente nome e cargo, se foi, altera ela também
            if(!ImagemService::imagemNaoInformada($imagem)){

                ImagemService::removeImagemDoDiretorio(caminhoImagem: "assets/imagens_dinamicas/imagens_integrantes/{$this->nomeImagem}");

                $this->setImagem($imagem);
            }

            $this->setNome($nome);
            $this->setCargo($cargo);
        }

        public function toArray(): array
        {
            return [
                'nome' => $this->nome,
                'cargo' => $this->cargo,
                'nomeImagem' => $this->nomeImagem,
            ];
        }


    }
?>