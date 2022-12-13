<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoExcluirPublicacao extends Operacao
    {
        public function __construct(string $autor)
        {
            parent::__construct($autor);
            $this->acao = "Excluiu uma publicação";
        }
    }
?>