const titlePagina = document.querySelector("title");
const campoTitulo = document.querySelector(".noticia__titulo");
const campoData = document.querySelector(".noticia__data");
const campoCapa = document.querySelector(".noticia__imagem");
const campoTexto = document.querySelector(".noticia__paragrafo");
const campoImagens = document.querySelector(".imagens");
const btnCurtir = document.querySelector(".btnGostei");
const comentarios = document.querySelector(".telaComentarios");
const divListaComentarios = document.querySelector(".comentarios");
const divListaMaisPublicacoes = document.querySelector(".noticias");

const loaderComentarios = document.querySelector("#loaderBuscarComentarios");

let idUsuario = document.querySelector(".idUsuario").value;
let nivelUsuario = document.querySelector(".nivelUsuario").value;

let idPublicacao;

let publicacaoExibida;

async function buscaPublicacao()
{
    const queryString = location.search;

    idPublicacao = queryString.match(/\?id=(.*)/)[1];

    const httpService = new HttpService();

    try{
        let res = await httpService.get(`back-end/buscaPublicacao.php?id=${idPublicacao}`);
    
        publicacaoExibida = await res.json();
    }catch(e){

        if(e.message == 'Publicacao não encontrada!'){
            location.href = 'index.php';
            return;
        }

        new MensagemLateralService("Não foi possível buscar a publicação.");

        return;
    }


    titlePagina.textContent = publicacaoExibida['titulo'];

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

    escreveComentarios(publicacaoExibida['comentarios']);

    buscaMaisPublicacoes();


}

async function buscaMaisPublicacoes()
{
    const httpService = new HttpService();

    let res = await httpService.get(`back-end/busca3UltimasPublicacoesComExcessao.php?idExcessao=${idPublicacao}`);

    let publicacoes = await res.json();

    publicacoes.forEach( publicacao => {
        divListaMaisPublicacoes.innerHTML +=
        `
            <a href="publicacao.php?id=${publicacao['id']}" class="linkNoticia">
                <div class="conteudoOutraNoticia">
                    <h3 class="tituloOutraNoticia">${publicacao['titulo']}</h3>
                    <h4 class="dataOutraNoticia">${DateHelper.formataData(new Date(publicacao['data']['date']))}</h4>
                </div>
                <img src="assets/imagens_dinamicas/capas_publicacoes/${publicacao['capa']}" class="capaNoticia" alt="">
            </a>
        `;
    } )
}

function escreveQuantidadeDeCurtidas(quantidade)
{
    spanQuantidade.innerHTML = `(${quantidade})`;
}

function escreveComentarios(comentarios)
{   
    divListaComentarios.innerHTML = "";

    comentarios.forEach( (comentario) => {

        let btnExcluirComentario = "";

        if(comentario['usuario']['id'] == idUsuario){
            btnExcluirComentario = 
            `
                <button class='btnExluirComentario material-icons' onclick='excluirComentario(${comentario['id']})'>
                delete</button> 
            `            
        }else if(nivelUsuario == 'admin'){
            btnExcluirComentario = 
            `
                <button class='btnExluirComentario material-icons' onclick='excluirComentarioAdmin(${comentario['id']})'>
                    delete
                </button> 
            `
        }


        divListaComentarios.innerHTML += `
            <article class="comentario" data-idComentario=${comentario['id']}>
                <div class="comentario__usuario">
                    <i class="material-icons">person</i>
                    ${comentario['usuario']['nome']}
                    ${btnExcluirComentario}
                </div>
                <div class="comentario__conteudo">
                    ${comentario['comentario']}
                </div>
            </article>
        `;
    } );
}

function verificaSeUsuarioJaCurtiu(curtidas)
{
    let curtidaUsuario = curtidas.find((curtida) => 
        curtida['usuario']['id'] == idUsuario
    );

    return curtidaUsuario ? true : false;
}

buscaPublicacao();

