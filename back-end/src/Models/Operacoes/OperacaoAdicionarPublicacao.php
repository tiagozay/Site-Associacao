<?php
    namespace APBPDN\Models\Operacoes;

    use APBPDN\Models\Usuario;
    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoAdicionarPublicacao extends Operacao
    {
        public function __construct(Usuario $autor, int $id_publicacao)
        {
            parent::__construct($autor);
            $this->acao = "Adicionou nova <a href='publicacao.php?pag=Admin-atividade.php&id=$id_publicacao'>Publicação</a>";
        }
    }
?>