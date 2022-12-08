const listaIntegrantes = document.querySelector("#lista");

async function buscaIntegrantes()
{
    const httpService = new HttpService();

    let res = await httpService.get('back-end/buscaIntegrantes.php');

    // let text = await res.text();

    // console.log(text);

    let integrantes = await res.json();

    integrantes.forEach(integrante => {

        listaIntegrantes.innerHTML += 
        `
            <li>
                <img class="foto" src="assets/imagens_dinamicas/imagens_integrantes/${integrante['nomeImagem']}"></img>
                <div class="detalhes">
                    <div class="nome divInfo">${integrante['nome']}</div>
                    <div class="cargo divInfo">${integrante['cargo']}</div>
                </div>
            </li>
        `
    });
}

buscaIntegrantes();