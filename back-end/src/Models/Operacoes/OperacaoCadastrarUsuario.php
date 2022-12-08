<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;
    use APBPDN\Models\Usuario;

    #[Entity()]
    class OperacaoCadastrarUsuario extends Operacao
    {
        public function __construct(Usuario $autor, string $nomeUsuario)
        {
            parent::__construct($autor);
            $this->acao = "Cadastrou usuário <strong class='nomeForte'>$nomeUsuario</strong>";
        }
    }
?>