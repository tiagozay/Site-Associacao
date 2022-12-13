<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoTornarUsuarioAdmin extends Operacao
    {
        public function __construct(string $autor, string $nomeUsuario)
        {
            parent::__construct($autor);
            $this->acao = "Tornou <strong class='nomeForte'>$nomeUsuario</strong> administrador(a)";
        }
    }
?>