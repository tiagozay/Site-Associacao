<?php
    namespace APBPDN\Models\Operacoes;

    use APBPDN\Models\Usuario;
    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoRemoverIntegrante extends Operacao
    {
        public function __construct(Usuario $autor, $nomeIntegrante)
        {
            parent::__construct($autor);
            $this->acao = "Removeu integrante <strong class='nomeForte'>$nomeIntegrante</strong>";
        }
    }
?>