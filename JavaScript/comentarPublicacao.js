let formAdcComentario = document.querySelector(".formAdcComentario");

formAdcComentario.onclick = () => {
    if(!idUsuario){
        new MensagemLateralService("Você precisa estar logado para comentar!");
        formAdcComentario.comentario.setAttribute("readonly", true);
    }
}

formAdcComentario.onsubmit = async (event) => {
    event.preventDefault();

    let comentario = formAdcComentario.comentario.value.trim();

    if(comentario.length == 0){
        abrirMsgErro("Preencha este campo.");
        return;
    }

    if(comentario.length > 400){
        abrirMsgErro("Cometário muito longo.");
        return;
    }

    fecharMsgErro();
    

    const httpService = new HttpService();

    loaderComentarios.classList.remove("display-none");

    try{
        let res = await httpService.post(
            'back-end/comentarPublicacao.php',
            `idPublicacao=${idPublicacao}&idUsuario=${idUsuario}&comentario=${comentario}`
        );
    
        loaderComentarios.classList.add("display-none");
    
        let novosComentarios = await res.json();
        
        formAdcComentario.comentario.value = "";
        
        escreveComentarios(novosComentarios);
    }catch(e){
        loaderComentarios.classList.add("display-none");
        new MensagemLateralService("Erro ao comentar");
    }

}

function abrirMsgErro(mensagem)
{
    let msg = document.querySelector("#erro_form_comentario");
    msg.classList.remove("display-none");
    msg.textContent = mensagem;
}


function fecharMsgErro()
{
    let msg = document.querySelector("#erro_form_comentario");
    msg.classList.add("display-none");
    msg.textContent = "";
}