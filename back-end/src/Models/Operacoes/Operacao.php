<?php
    namespace APBPDN\Models\Operacoes;

    use DateTime;
    use APBPDN\Models\Usuario;
    use APBPDN\Helpers\DateHelper;
    use Doctrine\ORM\Mapping\Column;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\InheritanceType;
    use Doctrine\ORM\Mapping\DiscriminatorColumn;
    use Doctrine\ORM\Mapping\DiscriminatorMap;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\ManyToOne;

    #[
        Entity, 
        InheritanceType("SINGLE_TABLE"), 
        DiscriminatorColumn('tipo_operacao', type:"string"), 
        DiscriminatorMap([
            'Adicionar publicação' =>  OperacaoAdicionarPublicacao::class,
            'Cadastrar integrante' =>  OperacaoCadastrarIntegrante::class,
            'Cadastrar usuário' =>  OperacaoCadastrarUsuario::class,
            'Editar integrante' =>  OperacaoEditarIntegrante::class,
            'Editar publicação' =>  OperacaoEditarPublicacao::class,
            'Excluir publicação' =>  OperacaoExcluirPublicacao::class,
            'Remover admin de usuário' =>  OperacaoRemoverAdminDeUsuario::class,
            'Remover usuário' =>  OperacaoRemoverUsuario::class,
            'Tornar usuário admin' =>  OperacaoTornarUsuarioAdmin::class
        ])
    ]
    abstract class Operacao
    {
        #[Id(), GeneratedValue(), Column()]
        public int $id;

        #[ManyToOne(targetEntity: Usuario::class, inversedBy: 'operacoes')]
        private Usuario $autor;

        #[Column()]
        protected string $acao;

        #[Column(name: 'dataRegistro')]
        private DateTime $data;

        public function __construct(Usuario $autor)
        {
            $this->autor = $autor;

            $this->data = DateHelper::dataEHoraAtual();
        }

        public function getAutor(): Usuario
        {
            return $this->autor;
        }

        public function getData(): DateTime
        {
            return $this->data;
        }

        public function getDataFormatada(): string
        {
            return DateHelper::formataDataEHora($this->data);
        }

        public function getOperacao(): string
        {
            return $this->operacao;
        }


    }

?>