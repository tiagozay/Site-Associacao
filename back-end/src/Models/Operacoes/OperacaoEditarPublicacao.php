<?php
    namespace APBPDN\Models\Operacoes;

    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoEditarPublicacao extends Operacao
    {
        public function __construct(string $autor, int $idPublicacao)
        {
            parent::__construct($autor);
            $this->acao = "Editou a <a href='publicacao.php?id=$idPublicacao'>Publicação</a>";
        }
    }
?>