<?php
    namespace APBPDN\Models\Operacoes;

    use APBPDN\Models\Usuario;
    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoExcluirPublicacao extends Operacao
    {
        public function __construct(Usuario $autor)
        {
            parent::__construct($autor);
            $this->acao = "Excluiu uma publicação";
        }
    }
?>