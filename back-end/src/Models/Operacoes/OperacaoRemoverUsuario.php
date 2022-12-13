<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Console\Style\StyleInterface;

    #[Entity()]
    class OperacaoRemoverUsuario extends Operacao
    {
        public function __construct(string $autor, string $nomeUsuario)
        {
            parent::__construct($autor);
            $this->acao = "Removeu usuário <strong class='nomeForte'>$nomeUsuario</strong>";
        }
    }
?>