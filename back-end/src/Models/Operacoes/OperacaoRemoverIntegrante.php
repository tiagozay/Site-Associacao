<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoRemoverIntegrante extends Operacao
    {
        public function __construct(string $autor, $nomeIntegrante)
        {
            parent::__construct($autor);
            $this->acao = "Removeu integrante <strong class='nomeForte'>$nomeIntegrante</strong>";
        }
    }
?>