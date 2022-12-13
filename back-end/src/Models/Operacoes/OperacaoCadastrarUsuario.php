<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoCadastrarUsuario extends Operacao
    {
        public function __construct(string $autor, string $nomeUsuarioCadastrado)
        {
            parent::__construct($autor);
            $this->acao = "Cadastrou usuário <strong class='nomeForte'>$nomeUsuarioCadastrado</strong>";
        }
    }
?>