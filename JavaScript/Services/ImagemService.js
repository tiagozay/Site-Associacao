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
            extensaoImagem != 'png' &&
            extensaoImagem != 'jpeg' &&
            extensaoImagem != 'jpg' 
        ){
            throw new Error('extensao_de_imagem_invalida');
        }
    }

    static diminuiTamanhoDeImagem(width, image_file)
    {
        return new Promise( (resolve, reject) => {
    
            let reader = new FileReader();
        
            reader.readAsDataURL(image_file);
        
            reader.onload = (event) => {
        
                let image_url = event.target.result;
        
                let image = document.createElement("img");
                image.src = image_url;
        
                image.onload = (e) => {
        
                    let canvas = document.createElement("canvas");
                    let ratio = width / e.target.width;
                    canvas.width = width;
                    canvas.height = e.target.height * ratio;
                
                    const context = canvas.getContext('2d');
                    context.drawImage(image, 0, 0, canvas.width, canvas.height);
        
                    let new_image_url = canvas.toDataURL('image/jpeg', 100);

                    let arquivo = ImagemService._urlToFile(new_image_url);

                    resolve(arquivo);

                }
            }
        })
    }

    static _urlToFile(url)
    {
        let arr = url.split(',');

        let mime = arr[0].match(/:(.*?);/)[1];
        let data = arr[1];

        let dataStr = atob(data);

        let n = dataStr.length;

        let dataArr = new Uint8Array(n);

        while(n--){
            dataArr[n] = dataStr.charCodeAt(n)
        }

        let file = new File([dataArr], 'File.jpg', {type: mime})

        return file;
    }

}