<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoRemoverAdminDeUsuario extends Operacao
    {
        public function __construct(string $autor, string $nomeUsuario)
        {
            parent::__construct($autor);
            $this->acao = "Removeu admin do usuário <strong class='nomeForte'>$nomeUsuario</strong>";
        }
    }
?>