<?php
    namespace APBPDN\Models\Operacoes;

    use APBPDN\Models\Usuario;
    use Doctrine\ORM\Mapping\Entity;

    #[Entity()]
    class OperacaoEditarPublicacao extends Operacao
    {
        public function __construct(Usuario $autor, int $idPublicacao)
        {
            parent::__construct($autor);
            $this->acao = "Editou a <a href='publicacao.php?pag=Admin-atividade.php&id=$idPublicacao'>Publicação</a>";
        }
    }
?>