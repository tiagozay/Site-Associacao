class ImagemService
{
    static validaImagem(imagem)
    {
        if(!imagem){
            throw new Error("imagem_nao_informada");
        }

        if((imagem.size / 1000 / 1000) > 20){
            throw new Error("imagem_muito_grande");   
        }


        const extensaoImagem = imagem.name.split('.').pop();

        if(
            extensaoImagem != 'tiff' &&
            extensaoImagem != 'jfif' &&
            extensaoImagem != 'bmp' &&
            extensaoImagem != 'pjp' &&
            extensaoImagem != 'apng' &&
            extensaoImagem != 'gif' &&
            extensaoImagem != 'svg' &&
            extensaoImagem != 'png' &&
            extensaoImagem != 'xbm' &&
            extensaoImagem != 'dib' &&
            extensaoImagem != 'jxl' &&
            extensaoImagem != 'jpeg' &&
            extensaoImagem != 'svgz' &&
            extensaoImagem != 'jpg' &&
            extensaoImagem != 'webp' &&
            extensaoImagem != 'ico' &&
            extensaoImagem != 'tif' &&
            extensaoImagem != 'pjpeg' &&
            extensaoImagem != 'avif'
        ){
            throw new Error('extensao_de_imagem_invalida');
        }
    }
}