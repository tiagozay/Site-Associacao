<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoAdicionarPublicacao extends Operacao
    {
        public function __construct(string $autor, int $id_publicacao)
        {
            parent::__construct($autor);
            $this->acao = "Adicionou nova <a href='publicacao.php?id=$id_publicacao'>Publicação</a>";
        }
    }
?>