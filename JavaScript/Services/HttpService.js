class HttpService
{
    postFormulario(formulario, url) 
    {
        const formData = new FormData(formulario);

        return fetch(url, {   
            method: 'POST',
            body: formData
        })
        .then( res => this._handleErrors(res) )
    }

    _handleErrors(res) 
    {
        if(!res.ok){

            //Se não houver sucesso da requisição, pega a mensagem de texto que vem do back-end e lança um erro, fazendo com que no próximo catch tenha essa mensagem

            return res.text()
            .then( msgErro => {
                throw new Error(msgErro);
            });

        } 

        return res;
    }
}