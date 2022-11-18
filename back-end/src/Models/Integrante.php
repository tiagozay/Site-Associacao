<?php
    namespace APBPDN\Models;

    use APBPDN\Services\ImagemService;
    use Doctrine\ORM\Mapping\Column;
    use DomainException;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;

    #[Entity]
    class Integrante
    {
        #[Column, Id, GeneratedValue]
        public int $id;

        #[Column(length: 90)]
        private string $nome;

        #[Column(length: 25)]
        private string $cargo;

        #[Column(length: 50)]
        private string $nomeImagem;

        private $imagemTemporaria;


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

            $this->imagemTemporaria = $imagem;

            $this->nomeImagem = $novoNomeImagem;
        }

        public function salvarImagem(): void
        {
            ImagemService::salvaImagemNoDiretorio(
                imagem: $this->imagemTemporaria, 
                diretorio: __DIR__."\..\..\..\assets\imagens_dinamicas\imagens_integrantes\\"
            );
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


        private static function defineNivelDoCargo(array &$integrantes): array
        {
            //Pega cada integrante e atribui um valor de 1 a 7 de acordo com seu cargo. Esse valor indica o nivel do cargo, que será usado na ordenação.
            
            $cargos = [
                'Presidente' => 1,
                'Vice presidente' => 2,
                '1º Secretário(a)' => 3,
                '2º Secretário(a)' => 4,
                '1º Tesoureiro(a)' => 5,
                '2º Tesoureiro(a)' => 6,
                'Integrante' => 7
            ];
    
            foreach($integrantes as &$integrante){
    
                $numeroCargo = $cargos[$integrante['cargo']];
        
                $integrante['numeroCargo'] = $numeroCargo;
        
            }

            return $integrantes;
        }

        public static function ordenaIntegrantesPorCargo(array $integrantes): array
        {
            //Depois de definir o nível de cada cargo, roda um loop de 1 a 7, onde para cada numero percorre a lista de integrantes buscando os que o cargo é desse nível e adicionando-os no array, fazendo assim uma ordenação crescente dos integrantes pelo cargo

            $integrantes = Integrante::defineNivelDoCargo($integrantes);

            $integrantesOrdenados = [];

            for($nivelCargo = 1; $nivelCargo <= 7; $nivelCargo++){
        
                foreach($integrantes as $integrante){
        
                    if($integrante['numeroCargo'] == $nivelCargo){
                        $integrantesOrdenados[] = $integrante;
                    }
                }
        
            }

            return $integrantesOrdenados;

        }

        public static function toArrays(array $integrantes) : array 
        {
            return array_map(function($integrante){
                return $integrante->toArray();
            }, $integrantes);
        }

        public function toArray(): array
        {
            return [
                'id' => $this->id,
                'nome' => $this->nome,
                'cargo' => $this->cargo,
                'nomeImagem' => $this->nomeImagem,
            ];
        }


    }
?>