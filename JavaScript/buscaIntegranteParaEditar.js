const inputNome = document.querySelector("#nome");
const inputCargo = document.querySelector("#cargo");
const inputId = document.querySelector("#id");
const btnSalvar = document.querySelector("#btnSalvar");

buscaIntegranteParaEditar();

function buscaIntegranteParaEditar()
{
    const queryString = location.search;

    const id = queryString.match(/\?id=(.*)/)[1];

    if(isNaN(Number(id))){
        new MensagemLateralService("Id do integrante inválido!");
        return;
    }

    desabilitarForm();

    const httpService = new HttpService();

    httpService.get(`back-end/buscaIntegrante.php?id=${id}`)
    .then(res => res.json())
    // .then(res => res.text())
    .then( integrante => {
        inputNome.value = integrante.nome;
        inputCargo.value = integrante.cargo;
        inputId.value = integrante.id;

        habilitarForm();
    })
    .catch(msg => console.log(msg))
}

function desabilitarForm()
{
    inputNome.classList.add("inputDesativado");
    inputNome.setAttribute("disabled", true);

    inputCargo.classList.add("inputDesativado");
    inputCargo.setAttribute("disabled", true);

    btnSalvar.classList.add("btnDesativado");
    btnSalvar.setAttribute("disabled", true);

}

function habilitarForm()
{
    inputNome.classList.remove("inputDesativado");
    inputNome.removeAttribute("disabled");

    inputCargo.classList.remove("inputDesativado");
    inputCargo.removeAttribute("disabled");

    btnSalvar.classList.remove("btnDesativado");
    btnSalvar.removeAttribute("disabled");

}