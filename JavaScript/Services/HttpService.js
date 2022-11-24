class HttpService
{
    postFormulario(formData, url) 
    {
        return fetch(url, {   
            method: 'POST',
            body: formData
        })
        .then( res => this._handleErrors(res) )
    }

    post(url, body)
    {
        return fetch(
            url,
            {   
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                method: 'POST',
                body
            }
        )
        .then( res => this._handleErrors(res) )

    }

    get(url)
    {
        return fetch(url)
        .then( res => this._handleErrors(res) );
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