<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoCadastrarIntegrante extends Operacao
    {
        public function __construct($autor, string $nomeIntegrante)
        {
            parent::__construct($autor);
            $this->acao = "Cadastrou integrante <strong class='nomeForte'>$nomeIntegrante</strong>";
        }
    }
?>