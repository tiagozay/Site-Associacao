async function excluirComentario(id)
{
    const confirmacao = confirm("Deseja excluir seu comentário?");
    if(!confirmacao) return;

    try{

        const httpService = new HttpService();

        loaderComentarios.classList.remove("display-none");

        const res = await httpService.post(
            'back-end/excluirComentario.php',
            `id=${id}`
        );
    
        // const text = await res.text();

        // console.log(text);
            
        const comentarios = await res.json();
    
        loaderComentarios.classList.add("display-none");
            
        escreveComentarios(comentarios);
        

    }catch(e){
        console.log(e);
        loaderComentarios.classList.add("display-none");
        new MensagemLateralService("Erro ao excluír comentário.");
    }

    


}