const listaPublicacoes = document.querySelector("#listaPublicacoes");
const loaderBuscarPublicacoes = document.querySelector("#divLoaderBuscarPublicacoes");

buscaPublicacoes();

function buscaPublicacoes()
{
    const httpService = new HttpService();

    loaderBuscarPublicacoes.classList.remove("desativarLoader");

    httpService.get('back-end/buscaPublicacoes.php')
    .then( res => res.json() )
    .then( publicacoes => {

        loaderBuscarPublicacoes.classList.add("desativarLoader");

        listaPublicacoes.innerHTML = "";

        escrevePublicacoesNaLista(publicacoes);
    })
    .catch( () => {
        loaderBuscarPublicacoes.classList.add("desativarLoader");

        new MensagemLateralService("Não foi possível buscar as publicações.");
    });

}

function escrevePublicacoesNaLista(publicacoes)
{
    publicacoes.forEach(publicacao => {
        listaPublicacoes.innerHTML += 
        `
            <li class="cardPublicacao">
                <div class="card__conteudo">
                    <h2 class="conteudo__titulo">${publicacao['titulo']}</h2>

                    <div class="conteudo__dataOpcoesCurtidasEComentarios">
                        <p class="conteudo__data">${DateHelper.formataData(new Date(publicacao['data']['date']))}</p>

                        <div id="curtidasEComentarios">
                            <div id="curtidas">
                                <i class="material-icons">thumb_up</i>
                                ${publicacao['quantidadeCurtidas']}
                            </div>
                            
                            <div id="comentarios">
                                <i class="material-icons">question_answer</i> 
                                ${publicacao['quantidadeComentarios']}
                            </div>
                            
                        </div>

                        <div id="divOpcoesPublicacao">
                            <a href='Admin-formEditarPublicacao.php?id=${publicacao['id']}' class="material-icons" id="btnEditarPublicacao">edit</a>
                            <button class="material-icons" id="btnExcluirPublicacao" onclick='excluirPublicacao(${publicacao['id']})'>delete</button>
                        </div>
                    </div>
                

                </div>
                <img class="card__capa" src="assets/imagens_dinamicas/capas_publicacoes/${publicacao['capa']}" alt="">

            </li> 
        `
    });
}