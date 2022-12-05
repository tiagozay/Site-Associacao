const campoTitulo = document.querySelector(".noticia__titulo");
const campoData = document.querySelector(".noticia__data");
const campoCapa = document.querySelector(".noticia__imagem");
const campoTexto = document.querySelector(".noticia__paragrafo");
const campoImagens = document.querySelector(".imagens");
const btnCurtir = document.querySelector(".btnGostei");
const comentarios = document.querySelector(".telaComentarios");

let idUsuario = document.querySelector(".idUsuario").value;

let idPublicacao;

let publicacaoExibida;

async function buscaPublicacao()
{
    const queryString = location.search;

    idPublicacao = queryString.match(/\?id=(.*)/)[1];

    const httpService = new HttpService();

    let res = await httpService.get(`back-end/buscaPublicacao.php?id=${idPublicacao}`);

    publicacaoExibida = await res.json();

    campoTitulo.innerText = publicacaoExibida['titulo'];
    campoData.innerText = DateHelper.formataData(new Date(publicacaoExibida['data']['date']));
    campoCapa.src = `assets/imagens_dinamicas/capas_publicacoes/${publicacaoExibida['capa']}`;
    campoTexto.innerText = publicacaoExibida['texto'];

    publicacaoExibida['imagens'].forEach(imagem => {
        campoImagens.innerHTML += 
        `
            <button class="btnImg" onclick="openModalImg('assets/imagens_dinamicas/imagens_publicacoes/${imagem['nome']}')">
                <img src='assets/imagens_dinamicas/imagens_publicacoes/${imagem['nome']}'>
            </button>
           
        `;
    });

    publicacaoExibida['videos'].forEach(video => {
        campoImagens.innerHTML += 
        `
            <object class="btnImg">
                <param name="movie" value="${video['url']}" />
                <embed src="${video['url']}" type="application/x-shockwave-flash"/>
            </object>
        `;
    });

    escreveQuantidadeDeCurtidas(publicacaoExibida['quantidadeCurtidas']);

    if(!publicacaoExibida['permitirCurtidas']){
        btnCurtir.classList.add("btnGosteiDesativado");
    }else{
        toggleBoolean_usuarioJaCurtiu = verificaSeUsuarioJaCurtiu(publicacaoExibida['curtidas']);
    }


    if(!publicacaoExibida['permitirComentarios']){
        comentarios.classList.add("comentariosDesativados");
    }
}

function verificaSeUsuarioJaCurtiu(curtidas)
{
    let curtidaUsuario = curtidas.find((curtida) => 
        curtida['usuario']['id'] == idUsuario
    );

    return curtidaUsuario ? true : false;
}

buscaPublicacao();

