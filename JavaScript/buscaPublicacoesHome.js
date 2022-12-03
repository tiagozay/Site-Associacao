const listaNoticias = document.querySelector(".noticias__container");
const loader = document.querySelector("#divLoaderBuscarPublicacoes");

async function buscaPublicacoes()
{
    const httpService = new HttpService();

    loader.classList.remove("loaderDesativado");

    let res = await httpService.get('back-end/buscaPublicacoes.php');

    let publicacoes = await res.json();

    escrevePublicacoes(publicacoes);
    
    loader.classList.add("loaderDesativado");
}

function escrevePublicacoes(publicacoes)
{
    publicacoes.forEach(publicacao => {

        let id = publicacao['id'];
        let titulo = publicacao['titulo'];
        let data = DateHelper.formataData(new Date(publicacao['data']['date']));
        let nomeCapa = publicacao['capa'];


        listaNoticias.innerHTML += 
        `
            <a href="publicacao.php?id=${id}" class="card">
                <div class="card__conteudo">
                    <h2 class="conteudo__titulo">${titulo}</h2>
                    <p class="conteudo__data">${data}</p>
                </div>
                <img class="card__capa" src="assets/imagens_dinamicas/capas_publicacoes/${nomeCapa}">
            </a>
        `
    });
}