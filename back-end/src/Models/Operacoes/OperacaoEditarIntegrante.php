<?php
    namespace APBPDN\Models\Operacoes;

    use APBPDN\Models\Usuario;
    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoEditarIntegrante extends Operacao
    {
        public function __construct(Usuario $autor, string $nomeIntegrante)
        {
            parent::__construct($autor);
            $this->acao = "Editou integrante <strong class='nomeForte'>$nomeIntegrante</strong>";
        }
    }
?>