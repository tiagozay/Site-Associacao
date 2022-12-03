const campoTitulo = document.querySelector(".noticia__titulo");
const campoData = document.querySelector(".noticia__data");
const campoCapa = document.querySelector(".noticia__imagem");
const campoTexto = document.querySelector(".noticia__paragrafo");
const campoImagens = document.querySelector(".imagens");
const btnCurtir = document.querySelector(".btnGostei");
const comentarios = document.querySelector(".telaComentarios");

async function buscaPublicacao()
{
    const queryString = location.search;

    const id = queryString.match(/\?id=(.*)/)[1];

    const httpService = new HttpService();

    let res = await httpService.get(`back-end/buscaPublicacao.php?id=${id}`);

    let publicacao = await res.json();

    campoTitulo.innerText = publicacao['titulo'];
    campoData.innerText = DateHelper.formataData(new Date(publicacao['data']['date']));
    campoCapa.src = `assets/imagens_dinamicas/capas_publicacoes/${publicacao['capa']}`;
    campoTexto.innerText = publicacao['texto'];

    publicacao['imagens'].forEach(imagem => {
        campoImagens.innerHTML += 
        `
            <button class="btnImg" onclick="openModalImg('assets/imagens_dinamicas/imagens_publicacoes/${imagem['nome']}')">
                <img src='assets/imagens_dinamicas/imagens_publicacoes/${imagem['nome']}'>
            </button>
           
        `;
    });

    publicacao['videos'].forEach(video => {
        campoImagens.innerHTML += 
        `
            <object class="btnImg">
                <param name="movie" value="${video['url']}" />
                <embed src="${video['url']}" type="application/x-shockwave-flash"/>
            </object>
        `;
    });

    if(!publicacao['permitirCurtidas']){
        btnCurtir.classList.add("btnGosteiDesativado");
    }

    if(!publicacao['permitirComentarios']){
        comentarios.classList.add("comentariosDesativados");
    }

    


}

buscaPublicacao();

