<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;
    use APBPDN\Models\Usuario;

    #[Entity()]
    class OperacaoCadastrarIntegrante extends Operacao
    {
        public function __construct(Usuario $autor, string $nomeIntegrante)
        {
            parent::__construct($autor);
            $this->acao = "Cadastrou integrante <strong class='nomeForte'>$nomeIntegrante</strong>";
        }
    }
?>