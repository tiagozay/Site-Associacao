class MensagemLateralService
{
    _time_out_iniciar_fade_out;
    _time_out_remover_elemento;

    constructor(mensagem)
    {
        //Quando a tela for menor de 700px, a mensagem aparece com alert, facilitando a visualização em dispositivos moveis
        if(window.innerWidth <= 700){
            alert(mensagem);
            return;
        }

        const body = document.querySelector("body");

        const containerMensagem = document.createElement("div");
        containerMensagem.classList.add("mensagemLateralDaTela");

        containerMensagem.innerHTML = 
        `
            <p>${mensagem}</p>
            <button class='material-icons' id="btnFecharMensagemLateral">close</button>
        `

        body.appendChild(containerMensagem);

        this._defineMetodoNoBtnDeFechar();

        this._defineFadeOutParaFecharSozinho();
    }

    _defineFadeOutParaFecharSozinho()
    {
        const containerMensagem = document.querySelector(".mensagemLateralDaTela");

        clearInterval(this._time_out_iniciar_fade_out);
        clearInterval(this._time_out_remover_elemento);

        this._time_out_iniciar_fade_out = setTimeout( () => {

            containerMensagem.classList.add('fade-out-1000');

            this._time_out_remover_elemento = setTimeout(()=>{
                containerMensagem.classList.remove('fade-out-1000');
                this.fechar();
            }, 1000);

        }, 2500 );

    }

    _defineMetodoNoBtnDeFechar()
    {
        const btnFecharMensagemLateral = document.querySelector("#btnFecharMensagemLateral");

        btnFecharMensagemLateral.onclick = () => {
            this.fechar();
        }
    }

    fechar()
    {
        clearInterval(this._time_out_iniciar_fade_out);
        clearInterval(this._time_out_remover_elemento);

        const body = document.querySelector("body");

        const containerMensagem = document.querySelector(".mensagemLateralDaTela");

        body.removeChild(containerMensagem);

    }
}
