<?php
    namespace APBPDN\Models;

use APBPDN\Models\Operacoes\Operacao;
use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping\Column;
    use DomainException;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\GeneratedValue;
    use Doctrine\ORM\Mapping\Id;
    use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

    #[Entity]
    class Usuario
    {
        #[Column, Id, GeneratedValue]
        public int $id;

        #[Column(length: 80)]
        private string $nome;

        #[Column(length: 260, unique: true)]
        private string $email;

        #[Column(length: 20)]
        private string $nivel;

        #[Column(length: 255)]
        private string $senha;

        #[OneToMany(mappedBy: 'usuario', targetEntity: Operacao::class, cascade:['persist', 'remove'])]
        private Collection $operacoes;

        /** @throws \DomainException */
        public function __construct(string $nome, string $email, string $nivel, string $senha, string $confSenha)
        {
            $this->setNome($nome);
            $this->setEmail($email);
            $this->setNivel($nivel);
            $this->setSenha($senha, $confSenha);
        }


        /** @throws \DomainException */
        public function setNome(string $nome): void
        {
            $nome = trim($nome);

            if(empty($nome)) throw new DomainException("campo_vazio");

            if(strlen($nome) > 80) throw new DomainException("nome_invalido");

            if(strlen($nome) < 3)  throw new DomainException("nome_curto");

            $this->nome = $nome;
        }

        /** @throws \DomainException */
        public function setEmail(string $email): void
        {
            $email = trim($email);

            if(empty($email)) throw new DomainException("campo_vazio");

            if(strlen($email) > 260) throw new DomainException("email_incorreto");

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new DomainException("email_incorreto");  

            $this->email = $email;
        }

        /** @throws \DomainException */
        public function setNivel(string $nivel): void
        {
            $nivel = trim($nivel);

            if(empty($nivel)) throw new DomainException("campo_vazio");

            if($nivel != 'admin' && $nivel != 'usuario') throw new DomainException("nivel_invalido");

            $this->nivel = $nivel;
        }

        /** @throws \DomainException */
        public function setSenha(string $senha, string $confSenha): void
        {
            $senha = trim($senha);
            $confSenha = trim($confSenha);

            if(empty($senha)) throw new DomainException("campo_vazio");
            if(empty($confSenha)) throw new DomainException("campo_vazio");

            if(strlen($senha) > 200) throw new DomainException("senha_invalida");
            if(strlen($confSenha) > 200) throw new DomainException("senha_invalida");

            if($senha != $confSenha) throw new DomainException("senhas_nao_coincidem");

            if(strlen($senha) < 8)  throw new DomainException("senha_curta");

            $this->senha = Usuario::criptografarSenha($senha);
        }

        public function setOperacao(Operacao $operacao): void
        {
            $this->operacoes->add($operacao);
        }

        public function getNome(): string
        {
            return $this->nome;
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function getNivel(): string
        {
            return $this->nivel;
        }

        public function getSenha(): string
        {
            return $this->senha;
        }

        public function tornarAdmin(): void
        {
            $this->nivel = 'admin';
        }

        public function removerDeAdmin(): void
        {
            $this->nivel = 'usuario';
        }

        public static function criptografarSenha(string $senha): string
        {
            return password_hash($senha, PASSWORD_DEFAULT);
        }
    }
?>