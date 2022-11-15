<?php
    namespace APBPDN\Services;

    use Doctrine\DBAL\Types\SimpleArrayType;
    use DomainException;

    class ImagemService
    {

        /** @throws DomainException */
        public static function validaImagem(array $imagem)
        {
            $extensaoImagem = pathinfo($imagem['name'], PATHINFO_EXTENSION);

            if(
                $extensaoImagem != 'tiff' &&
                $extensaoImagem != 'jfif' &&
                $extensaoImagem != 'bmp' &&
                $extensaoImagem != 'pjp' &&
                $extensaoImagem != 'apng' &&
                $extensaoImagem != 'gif' &&
                $extensaoImagem != 'svg' &&
                $extensaoImagem != 'png' &&
                $extensaoImagem != 'xbm' &&
                $extensaoImagem != 'dib' &&
                $extensaoImagem != 'jxl' &&
                $extensaoImagem != 'jpeg' &&
                $extensaoImagem != 'svgz' &&
                $extensaoImagem != 'jpg' &&
                $extensaoImagem != 'webp' &&
                $extensaoImagem != 'ico' &&
                $extensaoImagem != 'tif' &&
                $extensaoImagem != 'pjpeg' &&
                $extensaoImagem != 'avif'
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

        public static function transofrmaArrayDeImagensHttpParaOutroFormato(array $imagensForm): array
        {
            $imagens = [];
            for($i = 0; $i < count($imagensForm['name']); $i++){
                $imagens[] = [
                    'name'=>$imagensForm['name'][$i], 
                    'size'=>$imagensForm['size'][$i], 
                    'type'=>$imagensForm['type'][$i],
                    'tmp_name'=>$imagensForm['tmp_name'][$i]
                ];
            }

            return $imagens;
        }

        public static function salvaImagemNoDiretorio(array $imagem, string $diretorio): void
        {
            $diretorio = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $diretorio);

            move_uploaded_file(
                $imagem['tmp_name'],
                $diretorio.$imagem['name']
            );
        }

        public static function removeImagemDoDiretorio(string $caminhoImagem): void
        {
            unlink($caminhoImagem);
        }

        public static function imagemNaoInformada(array $imagem): bool
        {
            return $imagem['error'] == 4;
        }
    }
    
?>