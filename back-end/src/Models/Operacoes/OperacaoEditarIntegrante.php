<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoEditarIntegrante extends Operacao
    {
        public function __construct($autor, string $nomeIntegrante)
        {
            parent::__construct($autor);
            $this->acao = "Editou integrante <strong class='nomeForte'>$nomeIntegrante</strong>";
        }
    }
?>