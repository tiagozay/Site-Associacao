<?php
    namespace APBPDN\Services;

    use DomainException;

    class ImagemService
    {

        /** @throws DomainException */
        public static function validaImagem(array $imagem)
        {
            $extensaoImagem = pathinfo($imagem['name'], PATHINFO_EXTENSION);

            if(
                $extensaoImagem != 'jpg' &&
                $extensaoImagem != 'jpeg' &&
                $extensaoImagem != 'png' &&
                $extensaoImagem != 'svg' &&
                $extensaoImagem != 'pdf' &&
                $extensaoImagem != 'tiff' &&
                $extensaoImagem != 'eps'
            ) throw new DomainException("arquivo_invalido");

            $tamanhoDaImagemEmMB = $imagem['size'] / 1000 / 1000;
            if($tamanhoDaImagemEmMB > 20) throw new DomainException("arquivo_grande");
        }

        public static function geraNomeParaImagem(array $imagem): string
        {
            $nomeSeparadoPorPontos = explode('.',$imagem['name']);
            $extencao = end($nomeSeparadoPorPontos);

            $textoAleatorio = date('dmYHis');

            return $textoAleatorio.".".$extencao;
        }

        public static function salvaImagemNoDiretorio(array $imagem, string $diretório): void
        {
            move_uploaded_file(
                $imagem['tmp_name'],
                $diretório.$imagem['name']
            );
        }

        public static function removeImagemDoDiretorio(string $caminhoImagem): void
        {
            unlink($caminhoImagem);
        }

        public static function imagemNaoInformada($imagem): bool
        {
            return $imagem['error'] == 4;
        }
    }
    
?>