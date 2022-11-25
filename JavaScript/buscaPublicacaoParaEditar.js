const inputTitulo = document.querySelector("#titulo");
const inputData = document.querySelector("#data");
const inputTexto = document.querySelector("#texto");
const inputCapa = document.querySelector("#capa");
const inputImagens = document.querySelector("#imagens");
const selectQtdeNovosVideos = document.querySelector("#quantidadeDeVideos");
const inputsVideos = document.querySelectorAll('.inputVideo');
const inputPermitirComentarios = document.querySelector('#permitirComentarios');
const inputPermitirCurtidas = document.querySelector('#permitirLikes');
const btnSalvar = document.querySelector("#btnSalvar");

const listaDeImagens = document.querySelector(".gridImagens");
const listaDeVideos = document.querySelector(".gridVideos");

buscaPublicacaoParaEditar();

async function buscaPublicacaoParaEditar()
{
    const queryString = location.search;

    const id = queryString.match(/\?id=(.*)/)[1];

    if(isNaN(Number(id))){
        new MensagemLateralService("Id da publicação inválido!");
        return;
    }

    desabilitarForm();

    const httpService = new HttpService();

    let res = await httpService.get(`back-end/buscaPublicacao.php?id=${id}`);

    let publicacao = await res.json();

    habilitarForm();

    inputTitulo.value = publicacao['titulo'];
    inputData.value =  DateHelper.removeHorarioDaData(publicacao['data'].date);
    inputTexto.value = publicacao['texto'];
    inputTexto.value = publicacao['texto'];

    if(publicacao['permitirComentarios']){
        inputPermitirComentarios.setAttribute('checked', true);
    }

    if(publicacao['permitirCurtidas']){
        inputPermitirCurtidas.setAttribute('checked', true);
    }

    publicacao['imagens'].forEach(imagem => {
        
        listaDeImagens.innerHTML += 
        `
            <div class="divImg">
                <div class="telaSuperiorImagem">
                    <button type="button" onclick="create_modal('confirmação para excluir imagem')" data-idImg="${imagem['id']}" class="btnExcluirImagem">
                        <i class="material-icons" data-idImg="${imagem['id']}">delete</i>
                    </button>
                </div>
                <img src="assets/imagens_dinamicas/imagens_publicacoes/${imagem['nome']}" class="imagem">
            </div>
        `
            
    });

    
    publicacao['videos'].forEach(video => {
        
        listaDeVideos.innerHTML += 
        `
            <div class="divVideo">
                <button type="button" data-idvideo=${video['id']} onclick="create_modal('confirmação para excluir video')"><i class="material-icons" data-idvideo=${video['id']}>delete</i></button>
                <object>
                    <param name="movie" value="${video['url']}" />
                    <embed src="${video['url']}" type="application/x-shockwave-flash"/>
                </object>
            </div>
        `
            
    });

}

function desabilitarForm()
{
    inputTitulo.classList.add("inputDesativado");
    inputTitulo.setAttribute("disabled", true);

    inputData.classList.add("inputDesativado");
    inputData.setAttribute("disabled", true);

    inputTexto.classList.add("inputDesativado");
    inputTexto.setAttribute("disabled", true);

    inputCapa.classList.add("inputDesativado");
    inputCapa.setAttribute("disabled", true);

    inputImagens.classList.add("inputDesativado");
    inputImagens.setAttribute("disabled", true);

    selectQtdeNovosVideos.classList.add("inputDesativado");
    selectQtdeNovosVideos.setAttribute("disabled", true);

    inputPermitirComentarios.classList.add("inputDesativado");
    inputPermitirComentarios.setAttribute("disabled", true);
    
    inputPermitirCurtidas.classList.add("inputDesativado");
    inputPermitirCurtidas.setAttribute("disabled", true);
    
    btnSalvar.classList.add("btnDesativado");
    btnSalvar.setAttribute("disabled", true);

}

function habilitarForm()
{
    inputTitulo.classList.remove("inputDesativado");
    inputTitulo.removeAttribute("disabled");

    inputData.classList.remove("inputDesativado");
    inputData.removeAttribute("disabled");

    inputTexto.classList.remove("inputDesativado");
    inputTexto.removeAttribute("disabled");

    inputCapa.classList.remove("inputDesativado");
    inputCapa.removeAttribute("disabled");

    inputImagens.classList.remove("inputDesativado");
    inputImagens.removeAttribute("disabled");

    selectQtdeNovosVideos.classList.remove("inputDesativado");
    selectQtdeNovosVideos.removeAttribute("disabled");

    inputPermitirComentarios.classList.remove("inputDesativado");
    inputPermitirComentarios.removeAttribute("disabled");
    
    inputPermitirCurtidas.classList.remove("inputDesativado");
    inputPermitirCurtidas.removeAttribute("disabled");
    
    btnSalvar.classList.remove("btnDesativado");
    btnSalvar.removeAttribute("disabled");

}