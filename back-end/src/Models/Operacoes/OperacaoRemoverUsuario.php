<?php
    namespace APBPDN\Models\Operacoes;

    use APBPDN\Models\Usuario;
    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoRemoverUsuario extends Operacao
    {
        public function __construct(Usuario $autor, string $nomeUsuario)
        {
            parent::__construct($autor);
            $this->acao = "Removeu usuário <strong class='nomeForte'>$nomeUsuario</strong>";
        }
    }
?>