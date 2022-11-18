let lista = document.querySelector("#divListaIntegrantes__lista");

let loader = document.querySelector("#divLoaderBuscarIntegrantes");

buscarIntegrantes();

function buscarIntegrantes()
{
    const httpService = new HttpService();


    loader.classList.remove("desativarLoader");

    httpService.get('back-end/buscaIntegrantes.php')
    .then( res => res.json() )
    .then( integrantes => {

        loader.classList.add("desativarLoader");

        lista.innerHTML = "";

        integrantes.forEach(integrante => {
            lista.innerHTML += 
            `
                <li>
                    <div>
                        <div class="fotoIntegrante">
                            <img src="assets/imagens_dinamicas/imagens_integrantes/${integrante['nomeImagem']}" alt="">
                        </div>
                        <div class="nomeIntegrante">${integrante['nome']}</div>
                        <div class="cargoIntegrante">${integrante['cargo']}</div>
                        <div class="divAcoes">
                            <a href="Admin-formEditarIntegrante.php?id="><i class="material-icons">edit</i></a>

                            <a onclick="create_modal('confirmação para excluir integrante')" data-nome="" data-id=""><i class="material-icons" data-nome="" data-id="">delete</i></a>
                        </div>
                    </div>
                </li>
            `
        });

    });
}

