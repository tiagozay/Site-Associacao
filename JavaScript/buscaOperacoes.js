const listaDeOperacoes = document.querySelector("#lista");
const selectOrdem = document.querySelector("#ordem");

let loader = document.querySelector("#divLoaderBuscarOperacoes");


const httpService = new HttpService();

let ordem = 'mais_antigas';

selectOrdem.onchange = () => {
    ordem = selectOrdem.value;
    buscaOperacoes();
}

async function buscaOperacoes()
{
    listaDeOperacoes.innerHTML = "";

    loader.classList.remove('loaderDesativado');

    try{

        let res = await httpService.get(`back-end/buscaOperacoes.php?ordem=${ordem}`);

        // let text = await res.text();

        // console.log(text);

        let operacoes = await res.json();

        loader.classList.add('loaderDesativado');

        operacoes.forEach(operacao => {
            listaDeOperacoes.innerHTML += `
                <tr class="tbody__tr">
                    <td class="tbody__tr__tdGenerico tbody__tr__tdNome">
                        <div class="tbody__tr__td__divConteudoGenerica tbody__tr__td__divNome">
                            <p>${operacao['autor']}</p>
                        </div>
                    </td>
                    <td class="tbody__tr__tdGenerico tbody__tr__tdAcao">
                        <div class="tbody__tr__td__divConteudoGenerica">
                            <p>${operacao['acao']}</p> 
                        </div>    
                    </td>
                    <td class="tbody__tr__tdGenerico tbody__tr__tdData">
                        <div class="tbody__tr__td__divConteudoGenerica">
                            <p class="data">${DateHelper.formataDataComHorario(new Date(operacao['data']['date']))}</p> 
                        </div>    
                    </td>
                </tr>
            `
        });

    }catch(e){
        console.log(e);
        loader.classList.add('loaderDesativado');
        new MensagemLateralService("Não foi possível buscar as operações.");
    }

}

buscaOperacoes();