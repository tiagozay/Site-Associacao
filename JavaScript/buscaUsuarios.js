let ordem = 'mais_antigos';
let niveis = 'todos';

let selectOrdem = document.querySelector("#ordenarPor");
let selectNivel = document.querySelector("#niveis");

selectOrdem.onchange = () => {
    ordem = selectOrdem.value;
    buscaUsuarios();
}

selectNivel.onchange = () => {
    niveis = selectNivel.value;
    buscaUsuarios();
}

const quantidadeUsuarios = document.querySelector(".quantidadeUsuarios");

const tbdoy = document.querySelector(".tbody");

function geraCampoDeAcoes(id, nivel)
{
    if(nivel == 'usuario'){
        return `
            <div class='divAcoesNivel divGenericaBtnAcoes'>
                <button onclick='create_modal("")' class='btns_acoes_usuarios'>Tornar admin</button>
            </div>
            <div class='divAcoesExcluir divGenericaBtnAcoes'>
                <button  onclick='excluirUsuario(${id})' class='btns_acoes_usuarios'>Excluir</button>
            </div>
        `;
    }else if(nivel == 'admin'){
        return `
            <div class='divAcoesNivel divGenericaBtnAcoes'>
                <button  onclick='create_modal("")'  class='btns_acoes_usuarios' '>Remover admin</button>
            </div>
            <div class='divAcoesExcluir divGenericaBtnAcoes'>
                <button onclick='excluirUsuario(${id})' class='btns_acoes_usuarios' >Excluir</button>
            </div>
        `;
    }

}


buscaUsuarios();

function buscaUsuarios()
{
    tbdoy.innerHTML = "";

    const loader = document.querySelector("#divLoaderBuscarUsuarios");

    loader.classList.remove("desativarLoader");

    const httpService = new HttpService();

    httpService.get(`back-end/buscaUsuarios.php?ordem=${ordem}&niveis=${niveis}`)
    .then( res => res.json() )
    .then( usuarios => {

        loader.classList.add("desativarLoader");

        quantidadeUsuarios.innerText = `${usuarios.length} Usuários`;

        usuarios.forEach(usuario => {

            let id = usuario['id'];
            let nome = usuario['nome'];
            let email = usuario['email'];
            let nivel = usuario['nivel'];
        
            let acoesUsuario = geraCampoDeAcoes(id, nivel);


            tbdoy.innerHTML += 
            `
                <tr class="tbody__tr">
                    <td class="tbody__tr__tdGenerico tbody__tr__tdNome">
                        <div class="tbody__tr__td__divConteudoGenerica tbody__tr__td__divNome"><p>${nome}</p></div>
                    </td>

                    <td class="tbody__tr__tdGenerico tbody__tr__tdEmail">
                        <div class="tbody__tr__td__divConteudoGenerica tbody__tr__td__divEmail"><p>${email}</p></div>
                    </td>

                    <td class="tbody__tr__tdGenerico tbody__tr__tdNivel">
                        <div class="tbody__tr__td__divConteudoGenerica">
                            <p>${nivel}</p> 
                        </div>    
                    </td>
                    <td  class="tbody__tr__tdAcoes">
                        <i class="material-icons btnAbrirModal" onclick="create_modal('menu de açoes para usuários da lista')">menu</i> 

                        <div class='containerAcoesItemListaUsuarios id-${id}'>
                            ${acoesUsuario}
                        </div>

                    </td>
                </tr>
            `


        });
    } )
    .catch( msg => {
        loader.classList.add("desativarLoader");
        console.log(msg)
    } )
}